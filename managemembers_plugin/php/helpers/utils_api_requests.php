<?php

// use DomainException;
use Firebase\JWT\BeforeValidException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Firebase\JWT\SignatureInvalidException;
// use InvalidArgumentException;
// use UnexpectedValueException;

function is_headers(WP_REST_Request $request)
{
    $headers = $request->get_headers();
    if (!$headers || count($headers) === 0) {
        return false;
    }

    return true;
}

function get_cookie(WP_REST_Request $request)
{
    $headers = $request->get_headers();
    $cookie = $headers['cookie'][0] ?? false;
    return $cookie;
}

function get_token(string $cookie)
{

    $cookie_arr = explode(';', trim($cookie));

    $token = false;
    foreach ($cookie_arr as $value) {
        if (str_contains($value, 'token=')) {

            $token_arr = explode('=', $value);
            $token = $token_arr[1];

        }
    }
    return $token;
}

function decode_token(string $token)
{
    try {
        $decoded = JWT::decode($token, new Key(JWT_SECRET_KEY, 'HS256'));
        $decoded = json_decode(json_encode($decoded), true);
        return $decoded;
    } catch (InvalidArgumentException $e) {
        return ['error'=>$e->getMessage()];
    } catch (DomainException $e) {
        return ['error'=>$e->getMessage()];
    } catch (SignatureInvalidException $e) {
        return ['error'=>$e->getMessage()];
    } catch (BeforeValidException $e) {
        return ['error'=>$e->getMessage()];
    } catch (ExpiredException $e) {
        return ['error'=>$e->getMessage()];
    } catch (UnexpectedValueException $e) {
        return ['error'=>$e->getMessage()];
    }

}

