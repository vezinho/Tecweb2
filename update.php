<?php
include('class/mysql.php');
$db = new Database();
$db->connect();

// Declarando todos os campos que são obrigatorios
$required = array('id','nome', 'data_nasc', 'salario');

// Loop que verifica se os campos obrigatorios estão vazios
$error = false;
foreach($required as $field) {
  if (empty($_POST[$field])) {
    $error = true;
  }
}

//Se tiver vazio mostra erro caso contrario faz o update
if ($error) {
    echo "Todos os campos são obrigatorios";
  } else {
    extract($_POST);    
    $db->update('usuarios',array('nome'=>$nome,'data_nasc'=>$data_nasc,'salario'=>$salario),'id="'.$id.'"');    
    echo "<script>alert('Atualizado com Sucesso!');window.location.href='/';</script>";
    
}
