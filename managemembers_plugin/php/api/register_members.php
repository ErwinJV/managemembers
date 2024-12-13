<?php

function add_member(WP_REST_Request $request)
{

    if (!is_headers($request)) {
        return new WP_REST_Response(json_encode(['error' => 'Bad Request - Undefined headers']), 400);
    }

    global $wpdb;

    $params = $request->get_json_params();
    $name = sanitize_text_field($params['name']);
    $last_name = sanitize_text_field($params['lastName']);
    $email = sanitize_email($params['email']);
    $document = intval($params['document']);
    $member_status = sanitize_text_field($params['memberStatus']) ?? 'trial';
    $created = date('Y-m-d H:i:s');

    if ($name && $last_name && $email && $document) {

        $query = "SELECT email FROM {$wpdb->prefix}members WHERE email = '{$email}';";
        if ($wpdb->query($query)) {
            return new WP_REST_Response(json_encode(['error' => 'Email already exists']), 400);
        }
        $query = "SELECT document FROM {$wpdb->prefix}members WHERE document = {$document};";
        if ($wpdb->query($query)) {
            return new WP_REST_Response(json_encode(['error' => 'Document already exists']), 400);
        }

        $table = $wpdb->prefix . 'members';

        $response = false;
        $error = "";
        try {

            $response = $wpdb->insert($table,
                [
                    'name' => $name,
                    'last_name' => $last_name,
                    'email' => $email,
                    'document' => $document,
                    'member_status' => $member_status,
                    'created' => $created],
                [
                    '%s',
                    '%s',
                    '%s',
                    '%d',
                    '%s',
                    '%s',
                ]);

        } catch (Exception $e) {
            $error = $e->getMessage();
        }

        if ($error) {
            return new WP_REST_Response(json_encode(['error' => $error]), 500);
        }
        if (!$response) {
            return new WP_REST_Response(json_encode(['error' => 'Something wen wrong']), 404);
        }

        return new WP_REST_Response(json_encode(['msg' => 'Success']), 200);
    }

    return new WP_REST_Response(json_encode(['error' => 'All fields are required']), 400);
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
