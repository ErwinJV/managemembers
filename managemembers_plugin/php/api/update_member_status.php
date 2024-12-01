<?php


function upgrade_member(WP_REST_Request $request)
{
    global $wpdb;

    
    require __DIR__ . '/validate_request.php';


    $params = $request->get_json_params();
    $id = intval($params['id']);
    $status = sanitize_text_field($params['status']);

    if ($status !== 'member' && $status !== 'trial') {
        return new WP_REST_Response(null, 400);
    }

    $query = "UPDATE {$wpdb->prefix}members SET member_status = %s WHERE id = %d;";

    try
    {
        $response = $wpdb->query($wpdb->prepare($query, [$status, $id]));

        if ($response) {
            return new WP_REST_Response('Success!', 200);
        } else {
            return new WP_REST_Response('Something went wrong', 500);
        }

    } catch (Exception $e) {
        return new WP_REST_Response($e->getMessage(), 500);
    }

}

function upgrade_member_rest_route()
{
    register_rest_route('members/v1', 'update_member_status', [
        'methods' => 'POST',
        'callback' => 'upgrade_member',
        'permission_callback' => '__return_true',
    ]);
}

add_action('rest_api_init', 'upgrade_member_rest_route');
