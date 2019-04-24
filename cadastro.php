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
    <form action="/insert.php" method="POST">
            <div class="form-group">
                <label>Nome</label>
                <input name="id" type="hidden">
                <input name="nome" class="form-control">
            </div>
            <div class="form-group">
                <label>Data de Nascimento</label>
                <input name="data_nasc"  type="date" class="form-control">
            </div>
            <div class="form-group">
                <label>Salário</label>
                <input name="salario" class="form-control">
            </div>
            <div class="form-group">
            <button type="submit" class="btn btn-primary">Cadastrar</button>
            </div>
            </form>
    </body>
</html>
