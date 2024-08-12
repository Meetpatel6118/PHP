<?php
session_start();

include_once('./config/dbconnection.php');

function auto_logout($field)
{
    $t = time();
    $t0 = $_SESSION[$field];
    $diff = $t - $t0;
    if ($diff > 1500 || !isset($t0)) {
        return true;
    } else {
        $_SESSION[$field] = time();
    }
}
?>