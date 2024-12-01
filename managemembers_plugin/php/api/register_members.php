<?php
 

function add_member(WP_REST_Request $request)
{
    global $wpdb;

    require __DIR__ . '/validate_request.php';
   

    try
    {

        $params = $request->get_json_params();

        $name = sanitize_text_field($params['name']);
        $last_name = sanitize_text_field($params['lastName']);
        $email = sanitize_email($params['email']);
        $document = intval($params['document']);

        $created = date('Y-m-d H:i:s');

        if ($name && $last_name && $email && $document) {
            $query = "INSERT INTO {$wpdb->prefix}members VALUES ( %s, %s, %s, 'trial', %s );";
            $response = $wpdb->query($wpdb->prepare($query, [$name, $last_name, $email, $document, $created]));

            if (!$response) {
                return new WP_REST_Response('Something went wrong', 404);
            }

            return new WP_REST_Response('SUCCESS', 200);
        }

    } catch (Exception $e) {
        return new WP_REST_Response($e->getMessage(), 500);
    }

}

function register_member_api_rest()
{
    register_rest_route('members/v1', '/add', [
        'methods' => 'POST',
        'callback' => 'add_member',
        'permission_callback' => '__return_true',
    ]);
}

add_action('rest_api_init', 'register_member_api_rest');
