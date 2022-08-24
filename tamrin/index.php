<?php
session_start();
include_once 'config.php';
if (isset($_GET['logout']))
{
    session_destroy();
    $redirectPath = $rootPath. 'login.php';
    header("Location: $redirectPath");
}
if (!isset($_SESSION['username'])) {
    $redirectPath = $rootPath . 'login.php';
    header("Location: $redirectPath");
}else
{
    if ($connectType=='json')
    {
        include_once 'jsonIndex.php';
    }elseif ($connectType=='mysql')
    {
        include_once 'dbIndex.php';
    }
}
?>