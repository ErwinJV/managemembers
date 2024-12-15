<?php



function update_member(WP_REST_Request $request)
{    

   
    if(!is_headers($request)){
        return new WP_REST_Response(json_encode(['msg'=>'Bad Request - Headers not defined']),400);
    }

    $cookie = get_cookie($request);

    if(!$cookie){
        return new WP_REST_Response(json_encode(['msg'=>'Bad Request - Cookies not defined','cookie'=>get_cookie($request)]),400);
    }

    $token = get_token($cookie);

    if(!$token){
        return new WP_REST_Response(json_encode(['msg'=>'Bad Request - Token not defined','token'=>$token]),400);
    }

    $decode_token = decode_token($token);

    if(isset($decode_token['error'])){
        return new WP_REST_Response(json_encode(['msg'=>$decode_token['error']]),400);  
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
    
        $params = $request->get_json_params();

        $id = intval($params['id']);
        $name = sanitize_text_field($params['name']);
        $last_name = sanitize_text_field($params['lastName']);
        $email = sanitize_email($params['email']);
        $document = intval($params['document']);
        $member_status = sanitize_text_field($params['memberStatus']);

        $table = $wpdb->prefix . 'members';

        $response = false;
        try{
           
            $response = $wpdb->update($table, [
                'name'=>$name,
                'last_name'=>$last_name,
                'email'=>$email,
                'document'=>$document,
                'member_status'=>$member_status,  
            ],
            [
                'id'=>$id,
            ],
            [
               '%s',
               '%s',
               '%s',
               '%d',
               '%s'
            ],
            [
            '%d'
            ]
        );

        }catch(Exception $e){
           $error = $e->getMessage();
        }
 
       
        if($error){
           return new WP_REST_Response(json_encode(['msg'=>$error]), 500);
        }

        if(gettype($response) !=='integer'){
          return  new WP_REST_Response(json_encode(['databaseResponse'=>$response,'params'=>$params]), 404);
        }

        return  new WP_REST_Response(['msg'=>'Success','params'=>$params], 200);
                        


}

function update_member_rest_route()
{
    register_rest_route('members/v1','update',[
        'methods'=> 'POST',
        'callback'=>'update_member',
        'permission_callback'=>'__return_true'
    ]);
}

add_action('rest_api_init','update_member_rest_route');
