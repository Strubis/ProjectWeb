<!doctype html>
<html lang="pt-br">
  <head>
    <title>Apagando Cliente</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <b4-header>
        <div class="card text-white bg-dark mb-3">
            <h2 align="center">Apagando dados do cliente</h2>
            <a class="text-light" href="../index.php" >Home</a>
        </div>
    </b4-header>

    <?php
        include "conn.inc";
        if( !isset($_GET['search']) ){
    ?>
    <nav class="navbar navbar-expand-sm navbar-light bg-light">
        <div class="collapse navbar-collapse" id="collapsibleNavId">
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" name="nome" type="text" placeholder="Nome do Cliente">
                <button class="btn btn-outline-secondary my-2 my-sm-0" data-toggle="modal" data-target="#modelId" type="submit" name="search" id="search">Pesquisar</button>
            </form>
        </div>
    </nav>
    
    
    <?php
        }else{
            if( $_GET['nome'] != '' ){
                $nome_cl = $_GET['nome'];

                $sql = "SELECT idCliente FROM cliente
                            WHERE nome_cliente like '%$nome_cl%'";
                $reg = mysqli_query($con, $sql);
                    
                if( mysqli_affected_rows($con) > 0){
                    $sql = "DELETE FROM cliente WHERE nome_cliente LIKE '%$nome_cl%'";
                    $reg = mysqli_query($con, $sql);
                    $sql = "DELETE FROM telefone WHERE fkCliente = (SELECT idCliente 
                                    FROM cliente WHERE nome_cliente like '%$nome_cl%')";
                    $reg = mysqli_query($con, $sql);
                    $sql = "DELETE FROM enderecos WHERE fkCliente = (SELECT idCliente 
                                    FROM cliente WHERE nome_cliente like '%$nome_cl%')";
                    $reg = mysqli_query($con, $sql);

                    echo "<script>alert('Feito!');window.location.href='../index.php'</script>";
                }else{
                    echo "<script>alert('Cliente não encontrado!');window.location.href='../index.php'</script>";   
                }
            }else{
                echo "<script>alert('Cliente não encontrado!');window.location.href='../index.php'</script>";   
            }
            
        }
        mysqli_close($con);
    ?>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>