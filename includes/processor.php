<?php

function secure($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
function validateName($nam)
{
    if (preg_match('/^[a-z\d-]{2,20}$/i', $nam)) {
        return true;
    } else {
        return false;
    }
}
function validatePasswordLength($pwrd)
{
    $pwrdLen = strlen($pwrd);
    if (($pwrdLen >= 5) && ($pwrdLen <= 20)) {
        return true;
    } else {
        return false;
    }
}
function confirm_logged_in()
{
    if (!isset($_SESSION['username']) && !isset($_SESSION['logged'])) {
        header('location: index.php');
    }
}

if (isset($_GET['log_out'])) {
    session_unset();
    session_destroy();
    header('location: index.php');
    exit;
}
