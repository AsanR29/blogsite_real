<?php

Class databaseEntity {
    public $seed, $static_iv, $iv;

    function __construct($table_name){
        $encryption_keys = file_get_contents('../data/keys.json');
        $keys = json_decode($encryption_keys);
        $seed = $keys->$table_name;
        $static_iv = $keys->static_iv;

        $this->seed = $seed;
        $this->static_iv = $static_iv;
        return;
    }

    function encrypt($value){
        return openssl_encrypt($value, "aes-128-cbc", $this->seed, 0, $this->iv);
    }
    function encryptUnique($value){
        return openssl_encrypt($value, "aes-128-cbc", $this->seed, 0, $this->static_iv);
    }
    function encryptPassword($value){
        return password_hash($value, PASSWORD_BCRYPT);
    }

    function decrypt($value){
        return openssl_decrypt($value, "aes-128-cbc", $this->seed, 0, $this->iv);
    }
    function decryptUnique($value){
        return openssl_decrypt($value, "aes-128-cbc", $this->seed, 0, $this->static_iv);
    }

    function removeIV(){
        $this->iv = false;
        $this->static_iv = false;
        $this->seed = false;
    }

    function createIV(){
        $iv = substr(base64_encode(openssl_random_pseudo_bytes(16)), 0, 16);
        return $iv;
    }
}