<?php 
 try{

    $current_user = wp_get_current_user();
    $roles = $current_user->roles;
    
    $headers = $request->get_headers();
    

    if(
       !is_user_logged_in() ||
       !in_array('administrator', $roles) ||
       !in_array('editor', $roles))
    {

        return new WP_REST_Response(null,403);
        
    }

    return new WP_REST_Response("Headers",200);
 }catch(Exception $e){
     return new WP_REST_Response(json_encode([
        'error'=> $e->getMessage(),
     ]),500);
 }

    
     
