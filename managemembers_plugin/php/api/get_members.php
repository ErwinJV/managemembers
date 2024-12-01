<?php 


function get_members(WP_REST_Request $request)
{    
    global $wpdb;


    $is_logged = is_user_logged_in();
    try
    {
        $query = "SELECT * FROM {$wpdb->prefix}members";
        $classes = $wpdb->get_results($query,ARRAY_A);

        $headers = $request->get_headers();
        $cookie =   $headers['cookie'] ? $headers['cookie'][0]: '';
        
        
        


        
        
        return new WP_REST_Response(wp_get_current_user(),200);
    }catch(Exception $e)
    {
        return new WP_REST_Response('Something wrong',404);
    }
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
