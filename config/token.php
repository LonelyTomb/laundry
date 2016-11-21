<?php

function get_token()
{
    $token = hash('SHA512', mt_rand(0, mt_getrandmax()).microtime(true));
    $_SESSION['token'] = $token;

    return $token;
}
function check_token($token)
{
    $sessiontoken = get_token_from_session();
    $valid = strlen($sessiontoken) == 128 && strlen($token) == 128 && $sessiontoken == $token;
    get_token();
    return $valid;
}
function get_token_from_post()
{
    return isset($_POST['token']) ? $_POST['token'] : '';
}
function get_token_from_url()
{
    return isset($_GET['token']) ? $_GET['token'] : '';
}
function get_token_from_session()
{
    return isset($_SESSION['token']) ? $_SESSION['token'] : '';
}
