<!doctype html>
<html lang="pt-br">
  <head>
    <title>Atualizando Dados</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

    <script>
    
    function limpa_formulário_cep() {
            //Limpa valores do formulário de cep.
            document.getElementById('rua').value=("");
            document.getElementById('bairro').value=("");
            document.getElementById('cidade').value=("");
            document.getElementById('uf').value=("");
    }

    function meu_callback(conteudo) {
        if (!("erro" in conteudo)) {
            //Atualiza os campos com os valores.
            document.getElementById('rua').value=(conteudo.logradouro);
            document.getElementById('bairro').value=(conteudo.bairro);
            document.getElementById('cidade').value=(conteudo.localidade);
            document.getElementById('uf').value=(conteudo.uf);
        } 
        else {
            //CEP não Encontrado.
            limpa_formulário_cep();
            alert("CEP não encontrado.");
        }
    }
        
    function pesquisacep(valor) {

        //Nova variável "cep" somente com dígitos.
        var cep = valor.replace(/\D/g, '');

        //Verifica se campo cep possui valor informado.
        if (cep != "") {

            //Expressão regular para validar o CEP.
            var validacep = /^[0-9]{8}$/;

            //Valida o formato do CEP.
            if(validacep.test(cep)) {

                //Preenche os campos com "..." enquanto consulta webservice.
                document.getElementById('rua').value="...";
                document.getElementById('bairro').value="...";
                document.getElementById('cidade').value="...";
                document.getElementById('uf').value="...";

                //Cria um elemento javascript.
                var script = document.createElement('script');

                //Sincroniza com o callback.
                script.src = 'https://viacep.com.br/ws/'+ cep + '/json/?callback=meu_callback';

                //Insere script no documento e carrega o conteúdo.
                document.body.appendChild(script);

            } 
            else {
                //cep inválido.
                limpa_formulário_cep();
                alert("Formato de CEP inválido.");
            }
        }
        else {
            //cep sem valor, limpa formulário.
            limpa_formulário_cep();
        }
    };

    </script>

  </head>
  <body>
    <b4-header>
        <div class="card text-white bg-dark mb-3">
            <h2 align="center">Atualizando Dados do Cliente</h2>
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
                <button class="btn btn-outline-secondary my-2 my-sm-0" type="submit" name="search" id="search">Pesquisar</button>
            </form>
        </div>
    </nav>
    
    <div class="form-row">
        <?php
            }else{
                if( $_GET['nome'] != '' ){
                    $nome_cl = $_GET['nome'];
                    $sql = "SELECT cliente.nome_cliente, cliente.email_cliente, telefone.ddd, telefone.numero, enderecos.nome_cidade, enderecos.sigla_estado, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.bairro 
                            FROM cliente INNER JOIN telefone ON cliente.idCliente = telefone.fkCliente
                                        INNER JOIN enderecos ON cliente.idCliente = enderecos.fkCliente 
                            WHERE nome_cliente LIKE '%$nome_cl%'";
                        
                    $reg = mysqli_query($con, $sql);
                    if( mysqli_affected_rows($con) > 0 ){
                        while( $res = mysqli_fetch_row($reg) ){
                            echo "<div class='form-row'>";
                            echo "<div class='form-group col-md-4'>
                                    <label for='inputName'>Nome</label>
                                    <input type='text' name='nome' class='form-control' id='nome' value='$res[0]'>
                                </div>
                                <div class='form-group col-md-4'>
                                    <label for='inputEmail'>Email</label>
                                    <input type='email' name='email' class='form-control' id='email' value='$res[1]'>
                                </div>
                                <div class='form-group col-md-1'>
                                    <label for='ddd'>DDD</label>
                                    <input type='text' name='ddd' class='form-control' id='ddd' value='$res[2]' size='5' maxlength='3'>
                                </div>
                                <div class='form-group col-md-2'>
                                    <label for='telefone'>Telefone</label>
                                    <input type='text' name='telefone' class='form-control' id='telefone' value='$res[3]' maxlength='9'>
                                </div>";
                            echo "</div>";
                            echo "<div class='form-row'>";
                            echo "<div class='form-group col-md-6'>
                                    <label for='cidade'>Cidade</label>
                                    <input type='text' name='cidade' class='form-control' id='cidade' value='$res[4]'>
                                </div>
                                <div class='form-group col-md-1'>
                                    <label for='uf'>Estado</label>
                                    <input type='text' name='uf' class='form-control' id='uf' value='$res[5]'>
                                </div>
                                <div class='form-group col-md-1.5'>
                                    <label for='cep'>CEP</label>
                                    <input type='text' name='cep' class='form-control' id='cep' value='$res[6]' size='10' maxlength='9' onblur='pesquisacep(this.value);'>
                                </div>
                                <div class='form-group col-md-3'>
                                    <label for='bairro'>Bairro</label>
                                    <input type='text' name='bairro' class='form-control' id='bairro' value='$res[10]'>
                                </div>";
                            echo "</div>";
                            echo "<div class='form-row'>";
                            echo "<div class='form-group col-md-6'>
                                    <label for='rua'>Endereço</label>
                                    <input type='text' name='rua' class='form-control' id='rua' value='$res[7]' size='40' maxlength='100'>
                                </div>
                                <div class='form-group col-md-2'>
                                    <label for='numero'>Número</label>
                                    <input type='text' name='numero' class='form-control' id='numero' value='$res[8]' maxlength='5'>
                                </div>
                                <div class='form-group col-md-3'>
                                    <label for='complemento'>Complemento</label>
                                    <input type='text' name='complemento' class='form-control' id='complemento' value='$res[9]'>
                                </div>";
                            echo "</div>";
                        }
                
        ?>
    
    <?php
        if( !isset($_POST['atualizar']) ){
      ?>
                <form method="POST" >
                    <button type="submit" class="btn btn-secondary" name="atualizar" id="atualizar">Atualizar</button>
                </form>
    <?php
            }else{
                $sql = "SELECT cliente.nome_cliente, cliente.email_cliente, telefone.ddd, telefone.numero, enderecos.nome_cidade, enderecos.sigla_estado, enderecos.cep, enderecos.endereco, enderecos.numero, enderecos.complemento, enderecos.bairro 
                            FROM cliente INNER JOIN telefone ON cliente.idCliente = telefone.fkCliente
                                        INNER JOIN enderecos ON cliente.idCliente = enderecos.fkCliente 
                            WHERE nome_cliente LIKE '%$nome_cl%'";
                        
                $reg = mysqli_query($con, $sql);
                
                while( $res = mysqli_fetch_row($reg) ){
                    $nome = $res[0];
                    $email = $res[1];
                    $rua = $res[7];
                    $numero = $res[8];
                    $ddd = $res[2];
                    $telefone = $res[3];
                    $bairro = $res[10];
                    $complemento = $res[9];
                    $cidade = $res[4];
                    $estado = $res[5];
                    $cep = $res[6];
                }
                
                $sql = "call updateClient('$nome_cl','$nome','$email','$ddd',
                        '$telefone','$cep','$rua','$numero',
                        '$complemento','$bairro','$cidade','$estado');";

                $reg = mysqli_query($con, $sql);

                if( mysqli_affected_rows($con) > 0 ){
                    echo '<script>alert("Atualizado realizado!")</script>';
                }else{
                    $err = mysqli_error($con);
                    echo '<script>alert("Erro ao atualizar!");window.location.href="../index.php"</script>';
                }
            }
        }else{
            echo "<script>alert('Cliente não encontrado!');window.location.href='updateClient.php'</script>";
        }
    }else{
        echo "<script>alert('Cliente não encontrado!');window.location.href='updateClient.php'</script>";
    }
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