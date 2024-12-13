<?php 


function get_members(WP_REST_Request $request)
{   
    
    if(!is_headers($request)){
        return new WP_REST_Response(json_encode(['error'=>'Bad Request - Headers not defined']),400);
    }

    $cookie = get_cookie($request);

    if(!$cookie){
        return new WP_REST_Response(json_encode(['error'=>'Bad Request - Cookies not defined','cookie'=>$cookie]),400);
    }

    $token = get_token($cookie);

    if(!$token){
        return new WP_REST_Response(json_encode(['error'=>'Bad Request - Token not defined','token'=>$token]),400);
    }

    $decode_token = decode_token($token);

    if(isset($decode_token['error'])){
        return new WP_REST_Response(json_encode($decode_token),403);  
    }
    $error = "";
    $capabilities = [];
    
    try{
     
     $capabilities = $decode_token['data']['capabilities'];
  
    }catch(Exception $e){
       $error = $e->getMessage();
    }

    $authorized = false;
     
    if(isset($capabilities['administrator'])){
       $authorized = $capabilities['administrator'];
    }
     
    if(isset($capabilities['editor'])){
       $authorized = $capabilities['editor'];
    }
    
    if(!$authorized){
        return new WP_REST_Response(json_encode(['msg'=>'You are not authorized']),403);
    }

    global $wpdb;

    $members = [];
    $pages = 0;

    try{
    $query_count = "SELECT COUNT(*) FROM {$wpdb->prefix}members;";
    $members_count = $wpdb->get_results($query_count,ARRAY_A);
    $count = intval($members_count[0]['COUNT(*)']);
    $offset = intval($_GET['offset'] ?? 0);
    $limit = intval($_GET['limit'] ?? "10");

    $query = "SELECT * FROM {$wpdb->prefix}members LIMIT {$limit} OFFSET {$offset};";
    $members = $wpdb->get_results($query,ARRAY_A);
    $pages = ceil($count/$limit);
    }catch(Exception $e){
       $error = $e->getMessage();
    }
   
    if($error){
      return new WP_REST_Response(json_encode(['error'=>$error]),500);

    }
    
    return new WP_REST_Response(json_encode(['pages'=>$pages,'members'=>$members,'offset'=>$_GET['offset'],'capabilities'=>$capabilities['administrator']],),200);
 
  
}

function get_member_rest_route()
{
    register_rest_route('members/v1','all',[
        'methods'=>'GET',
        'callback'=>'get_members',
        'permission_callback'=>'__return_true'
    ]);
}

add_action('rest_api_init','get_member_rest_route');

