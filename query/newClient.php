<!doctype html>
<html lang="pt-br">
  <head>
    <title>Cadastrando Cliente</title>
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
            <h2 align="center">Cadastrando Cliente</h2>
            <a class="text-light" href="../index.php" >Home</a>
        </div>
      </b4-header>


      <?php
        include "conn.inc";
        if( !isset($_POST["cadastrar"]) ){
      ?>

    <form method="POST" action="newClient.php">
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="inputName">Nome</label>
                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome">
            </div>
            <div class="form-group col-md-6">
                <label for="inputEmail">Email</label>
                <input type="email" name="email" class="form-control" id="email" placeholder="Email">
            </div>
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="rua">Endereço</label>
                <input type="text" name="rua" class="form-control" id="rua" placeholder="Rua Principal" size="40" maxlength="100">
            </div>
            <div class="form-group col-md-2">
                <label for="numero">Número</label>
                <input type="text" name="numero" class="form-control" id="numero" placeholder="1234" maxlength="5">
            </div>
            <div class="form-group col-md-1">
                <label for="ddd">DDD</label>
                <input type="text" name="ddd" class="form-control" id="ddd" placeholder="xx" size="5" maxlength="3">
            </div>
            <div class="form-group col-md-2">
                <label for="telefone">Telefone</label>
                <input type="text" name="telefone" class="form-control" id="telefone" placeholder="9xxxx-xxxx" maxlength="9">
            </div>
        </div>
        <div class="form-group">
            <label for="bairro">Bairro</label>
            <input type="text" name="bairro" class="form-control" id="bairro" placeholder="Jardim Américo...">
        </div>
        <div class="form-group">
            <label for="complemento">Complemento</label>
            <input type="text" name="complemento" class="form-control" id="complemento" placeholder="Apartamento, sobrado, kitnet...">
        </div>
        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="cidade">Cidade</label>
                <input type="text" name="cidade" class="form-control" id="cidade">
            </div>
            <div class="form-group col-md-4">
                <label for="uf">Estado</label>
                <input type="text" name="uf" class="form-control" id="uf">
            </div>
            <div class="form-group col-md-1.5">
                <label for="cep">CEP</label>
                <input type="text" name="cep" class="form-control" id="cep" size="10" maxlength="9" onblur="pesquisacep(this.value);">
            </div>
        </div>
        <button type="submit" class="btn btn-secondary" name="cadastrar">Cadastrar</button>
    </form>
    <?php
        }else{
            $nome=$_POST['nome'];
            $email=$_POST['email'];
            $rua=$_POST['rua'];
            $numero=$_POST['numero'];
            $ddd=$_POST['ddd'];
            $telefone=$_POST['telefone'];
            $bairro=$_POST['bairro'];
            $complemento=$_POST['complemento'];
            $cidade=$_POST['cidade'];
            $estado=$_POST['uf'];
            $cep=$_POST['cep'];

            $sql = "call insertClient('$nome','$email','$ddd',
                    '$telefone','$cep','$rua','$numero','$complemento',
                    '$bairro','$cidade','$estado');";

            $req = mysqli_query($con, $sql);

            if( mysqli_affected_rows($con) > 0 ){
                echo "<script>alert('Cadastro realizado!');window.location.href='../index.php'</script>";
            }else{
                $err = mysqli_error($con);
                echo "<script>alert('Erro ao cadastrar!');window.location.href='../index.php'</script>";
            }
        }

        mysqli_close($con);
    ?>
        
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
            integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
            crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>