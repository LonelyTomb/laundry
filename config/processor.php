<?php

function secure($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
// Level & Level [Deepness] Conversion
function getLevelDeepness($lvl)
{
    $lvl_deep = './';
    for ($i = 0; $i < $lvl; ++$i) {
        $lvl_deep .= '../';
    }

    return $lvl_deep;
}
function confirm_logged_in()
{
    if (isset($_SESSION['user']['username']) && isset($_SESSION['user']['logged'])) {
        return true;
    }

    return false;
}
function confirm_admin()
{
    if (isset($_SESSION['admin']) && $_SESSION['admin']['username'] !== '') {
        return true;
    }

    return false;
}

if (isset($_GET['log_out'])) {
    if (in_array('admin', explode('/', $_SERVER['PHP_SELF']))) {
        unset($_SESSION['admin']);
        header('location: index.php');
    } elseif (!in_array('admin', explode('/', $_SERVER['PHP_SELF']))) {
        unset($_SESSION['user']);
        header('location: index.php');
    }
    exit;
}
