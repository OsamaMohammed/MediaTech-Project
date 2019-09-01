<?php
require_once '../vendor/autoload.php';

use \Firebase\JWT\JWT;

class OSAJWT{
    private static $key = "I<%Q.7Q;,+C,R+2KabHHVvj/[b:2Ev@)qzSIQW(^4]iL>l-2Q%HdIEGc";
    private static $expire = 60 * 60 * 24 ;// 24 hours

    public static function decodeToken($jwt){
        try{
            $token = JWT::decode($jwt, self::$key, array('HS256'));
        }catch(ExpiredException $e) {
            // echo('Provided token is expired.');
            return false;
        } catch(Exception $e) {
            // echo('An error while decoding token.');
            return false;
        }
        if (time() > $token->time){
            // echo("Session expired, please refresh the page.");
            return false;
        }
        return $token;
    }

    public static function encodeToken($user_id){
        $token = array(
            "time" => ( time() + self::$expire),
            'urid' => $user_id
        );
        return JWT::encode($token, self::$key);
    }
}