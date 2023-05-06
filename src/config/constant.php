<?php
$key = '2sC7{zKjxuVnW1T*-^_I(5P@#0Lp)';
$cipher = "AES-256-CBC";
$options = 0;

function data_decrypt($str, $iv){
    global $cipher;
    global $key;
    global $options;
    return openssl_decrypt($str, $cipher, $key, $options, $iv);
}

function data_encrypt($str, $iv){
    global $cipher;
    global $key;
    global $options;
    return openssl_encrypt($str, $cipher, $key, $options, $iv);
}