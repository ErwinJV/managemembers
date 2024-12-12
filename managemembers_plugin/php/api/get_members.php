<?php 


function get_members(WP_REST_Request $request)
{    
    global $wpdb;


    $members = [];
    $pages = 0;
    $error = "";
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
    
    return new WP_REST_Response(json_encode(['pages'=>$pages,'members'=>$members,'offset'=>$_GET['offset']],),200);
 
  
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

