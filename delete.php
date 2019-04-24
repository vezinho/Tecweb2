<?php
include('class/mysql.php');
$db = new Database();
$db->connect();

// Declarando todos os campos que são obrigatorios
$required = array('id');

// Loop que verifica se os campos obrigatorios estão vazios
$error = false;
foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

//Se tiver vazio mostra erro caso contrario faz o delete
if ($error) {
    echo "Todos os campos são obrigatorios";
  } else {
    extract($_POST);    
    $db->delete('usuarios','id="'.$id.'"');
}
