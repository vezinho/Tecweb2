<?php
include('class/mysql.php');
$db = new Database();
$db->connect();
extract($_GET); 
$db->sql("SELECT * FROM usuarios where id = '".$id."'");
$res = $db->getResult();
?>
<!DOCTYPE html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <title></title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
        <script>
        	
        </script>
    </head>
    <body>
    <form action="/update.php" method="POST">
            <div class="form-group">
                <label>Nome</label>
                <input name="id" type="hidden" value="<?php echo $id?>">
                <input name="nome" class="form-control" value="<?php echo $res[0]['nome']?>">
            </div>
            <div class="form-group">
                <label>Data de Nascimento</label>
                <input name="data_nasc" type="date" class="form-control"value="<?php echo $res[0]['data_nasc']?>">
            </div>
            <div class="form-group">
                <label>Salário</label>
                <input name="salario" class="form-control" value="<?php echo $res[0]['salario']?>">
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Editar</button>
            </div>
            </form>
    </body>
</html>
