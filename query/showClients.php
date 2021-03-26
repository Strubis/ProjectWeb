<!doctype html>
<html lang="pt-br">
  <head>
    <title>Consultando Clientes</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  </head>
  <body>
    <b4-header>
      <div class="card text-white bg-dark mb-3">
        <h2 align="center">Clientes Cadastrados</h2>
        <a class="text-light" href="../index.php" >Home</a>
      </div>
    </b4-header>

      <div class="table-responsive">
              <?php
                    include "conn.inc";
                    $sql = "SELECT cliente.nome_cliente, cliente.email_cliente, telefone.ddd, telefone.numero, enderecos.nome_cidade, enderecos.sigla_estado, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.bairro FROM 
                            cliente INNER JOIN telefone ON cliente.idCliente = telefone.fkCliente
                                    INNER JOIN enderecos ON cliente.idCliente = enderecos.fkCliente";
                    $res = mysqli_query($con, $sql);

                    while( $reg = mysqli_fetch_row($res) ){
                        $nameClient = $reg[0];
                        $emailClient = $reg[1];
                        $numberClient = [ $reg[2], $reg[3] ];
                        $stateCityClient = [ $reg[4], $reg[5] ];
                        $addressClient = [ $reg[6], $reg[7], $reg[8], $reg[9], $reg[10] ];
                        
                        echo "<table class='table table-sm table-striped table-dark table-hover w-50 d-inline-block p-2 m-0'>";
                        echo "<tbody>";
                        echo "<tr>";
                        echo "<th scope='row'>Nome:</th>";
                        echo "<td>$nameClient</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>Email:</th>";
                        echo "<td>$emailClient</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>Número:</th>";
                        echo "<td>$numberClient[0] $numberClient[1]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>Cidade:</th>";
                        echo "<td>$stateCityClient[0] - $stateCityClient[1]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>Endereço Completo:</th>";
                        echo "<td>$addressClient[1], $addressClient[2] - $addressClient[4] $addressClient[3]</td>";
                        echo "</tr>";
                        echo "<tr>";
                        echo "<th scope='row'>CEP:</th>";
                        echo "<td>$addressClient[0]</td>";
                        echo "</tr>";
                        echo "</tbody>";
                        echo "</table>";
                        
                    }
                    mysqli_close($con);
              ?>
      </div>
      
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>