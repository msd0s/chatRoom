<?php
$dbhost='localhost';
$dbname='chatroom';
$dbuser='root';
$dbpass='';

$dsn="mysql:host=$dbhost;dbname=$dbname";
$con= new PDO($dsn,$dbuser,$dbpass);

$connectType='mysql'; //use mysql || json

$explodedURI=explode('?',$_SERVER['REQUEST_URI']);
$explodedSlashes=explode('/',$explodedURI[0]);
array_pop($explodedSlashes);
$finalAddress = implode('/',$explodedSlashes);

$rootPath=$_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$finalAddress.'/';