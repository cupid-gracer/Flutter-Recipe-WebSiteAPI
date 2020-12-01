<?php
use \Firebase\JWT\JWT;

class ImplementJwt
{
    //////////The function generate token///////////// 
    PRIVATE $key = "recipe_private_key"; 
    public function GenerateToken($data)
    {          
        $jwt = JWT::encode($data, $this->key);
        return $jwt;
    }

   //////This function decode the token//////////////////// 
    public function DecodeToken($token)
    {          
        $decoded = JWT::decode($token, $this->key, array('HS256'));
        $decodedData = (array) $decoded;
        return $decodedData;
    }
}