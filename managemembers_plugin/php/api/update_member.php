<?php

function update_member(WP_REST_Request $request)
{
    global $wpdb;
    
    
    require __DIR__ . 'validate_request.php';


    try
    {
        $params = $request->get_json_params();
    
        $id = intval($params['id']);
        $name = sanitize_text_field($params['name']);
        $last_name = sanitize_text_field($params['lastName']);
        $email = sanitize_email($params['email']);
        $document = intval($params['document']);
        $member_status = sanitize_text_field($params['member_status']);
    
        $query = "UPDATE {$wpdb->prefix}members SET `name` = %s,`last_name` = %s, `email` = %s,
                                                    `document` = %d, `member_status`= %s 
                                                    WHERE `id` = %d;";

        $response = $wpdb->query($wpdb->prepare($query, [
            $name,
            $last_name,
            $email,
            $document,
            $member_status,
            $id
        ]));


        return $response ? new WP_REST_Response('Success!', 200)
                         : new WP_REST_Response('Something went wrong', 404);

    } catch (Exception $e) {
         
        return new WP_REST_Response('Something went wrong', 500);
    }

}

function update_member_rest_route()
{
    register_rest_route('members/v1','update_member',[
        'methods'=> 'POST',
        'callback'=>'update_member',
        'permission_callback'=>'__return_true'
    ]);
}

add_action('rest_api_init','update_member_rest_route');
