<?php
include('class/mysql.php');
$db = new Database();
$db->connect();

// Declarando todos os campos que são obrigatorios
$required = array('nome', 'data_nasc', 'salario');

// Loop que verifica se os campos obrigatorios estão vazios
$error = false;
foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

//Se tiver vazio mostra erro caso contrario faz o insert
if ($error) {
    echo "Todos os campos são obrigatorios";
  } else {
    extract($_POST);
    $db->insert('usuarios',array('nome'=>$nome,'data_nasc'=>$data_nasc,'salario'=>$salario));
    echo "<script>alert('Cadastrado com Sucesso!');window.location.href='/';</script>";
}

   

