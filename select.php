<?php
include('class/mysql.php');
$db = new Database();
$db->connect();
$db->select('usuarios');
$res = $db->getResult();
echo json_encode($res);
