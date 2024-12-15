<?php

use Firebase\JWT\JWT;

function add_jwt($user_login){

    global $wpdb;

  $user_query = "SELECT ID, user_login FROM {$wpdb->prefix}users WHERE user_login = '{$user_login}';";
  $user = $wpdb->get_results($user_query,ARRAY_A);


  $user_role = get_user_meta($user[0]['ID'],'wp_capabilities',true);


  $payload = [
     "iss" => site_url(),
     "aud" => site_url(),
     "iat" => time(),
     "exp" => time() + (60*60*24*7), 
     "data" => [
         "id" => 1,
         "username" => $user_login,
         "capabilities"=>$user_role,
         
     ]
   ];

   
 
 // Generar el JWT
 $jwt = JWT::encode($payload, JWT_SECRET_KEY,'HS256');
 setcookie('token', $jwt, time() + (60*60*24*7), '/');
 //header('Authorization: Bearer' . $jwt);

 }
 
 add_action('wp_login','add_jwt');