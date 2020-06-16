<?php
//verificar se esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}
    if (!isset ($id) ) $id = "";
    $nome = $cpf = $datanascimento = $email = $senha = $cep = $endereco = $complemento = $bairro = $cidade_id = $foto = $foto = $telefone = $celular = $nome_cidade = $estado ="";

    if ( !empty ( ( $id ) ) ) {
        //selecionar os dados do cliente
        $sql = "select c.*, date_format(c.datanascimento,'%d/%m/%Y') datanascimento, ci.cidade, ci.estado from cliente c inner join cidade ci on ( ci.id = c.cidade_id ) where c.id = :id limit 1";
        $consulta =$pdo->prepare($sql);
        $consulta->bindParam(":id", $id);
        $consulta->execute();

        $dados = $consulta->fetch(PDO::FETCH_OBJ);

        if ( empty ( $dados->id ) ) {
            echo "<p class='alert alert-danger'> Cliente Não existe </p>";
        }

        $id             = $dados->id;
        $nome           = $dados->nome;
        $datanascimento = $dados->datanascimento;
        $endereco       = $dados->endereco;
        $bairro         = $dados->bairro;
        $cidade         = $dados->cidade;
        $cidade_id      = $dados->cidade_id;
        $estado         = $dados->estado;
        $cpf            = $dados->cpf;
        $foto           = $dados->foto;
        $telefone       = $dados->celular;
        $email          = $dados->email;
        $senha          = $dados->senha;
    }
?>
<div class="container">
    <h1 class="float-left">Cadastro de Clientes</h1>
    <div class="float-right">
    <a href="cadastro/cliente" class="btn btn-success">Novos Registros</a>
    <a href="listar/cliente" class="btn btn-info">Lista Registros</a>
    </div> 

    <div class="clearfix"></div>

    <form name="formCadastro" method="post" action="salvar/cliente" data-parsley-validate enctype="multipart/form-data">
        <div class="row">
            <div class="col-12 col-md-2">
                <label for="id"> ID:</label>
                <input type="text" name="id" id="id" class="form-control" readonly value="<?= $id; ?>">
            </div>
            <div class="col-12 col-md-10">
                <label for="nome"> Nome:</label>
                <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha o nome corretamente!" value="<?= $nome; ?>" placeholder="Digite seu nome completo">
            </div>       
            <div class="col-12 col-md-4">
                <label for="cpf"> CPF: </label>
                <input type="text" name="cpf" id="cpf" class="form-control" required data-parsley-message="Preencha o CPF" value="<?= $cpf; ?>" onblur="verificarCpf(this.value)">
            </div>    
            <div class="col-12 col-md-4">
                <label for="datanascimento">Data de Nascimento:</label>
                <input type="text" name="datanascimento" id="datanascimento" class="form-control" required data-parsley-message="Preencha a Data de Nascimento" value="<?= $datanascimento; ?>" placeholder="Digite a data 08/11/2008">                
            </div>
            <div class="col-12 col-md-4">
                <label for="foto"> Foto (JPG)</label> 
                <input type="file" name="foto" id="foto" class="form-control">
            </div>
            <div class="col-12 col-md-6">
                <label for="telefone">Telefone:</label>
                <input type="text" name="telefone" id="telefone" class="form-control" placeholder="Telefone com DDD" value="<?= $telefone; ?>">
            </div>
            <div class="col-12 col-md-6">
                <label for="celular">Celular:</label>
                <input type="text" name="celular" id="celular" class="form-control" placeholder="Celular com DDD" value="<?= $celular; ?>">
            </div>
            <div class="col-12">
                <label for="email"> E-mail: </label>
                <input type="email" name="email" id="email" class="form-control" required data-parsley-message="Preencha o E-mail" value="<?= $email; ?>" data-parsley-type-message="Digite um E-mail válido">
            </div>
            <div class="col-12 col-md-6">
                <label for="senha">Digite a Senha: </label>
                <input type="password" name="senha" id="senha" class="form-control" >
            </div>
            <div class="col-12 col-md-6">
                <label for="senha2">Redigite a Senha: </label>
                <input type="password" name="senha2" id="senha2" class="form-control" >
            </div>
            <div class="col-12 col-3">
                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" class="form-control" required data-parsley-required-message="Prencha o CEP" value="<?= $cep; ?>">
            </div>
            <div class="col-12 col-md-3">
                <label for="cidade_id"> ID Cidade: </label>
                <input type="text" name="cidade_id" id="cidade_id" class="form-control" readonly data-parsley-required-message="Preencha a Cidade" value="<?= $cidade_id; ?>">
            </div>
            <div class="col-12 col-md-5">
                <label for="nome_cidade">Nome da Cidade:</label>
                <input type="text" name="nome_cidade" id="nome_cidade" class="form-control" value="<?= $nome_cidade; ?>">
            </div>  
            <div class="col-12 col-md-2">
                <label for="estado">Estado:</label>
                <input type="text" name="estado" id="estado" class="form-control" value="<?= $estado; ?>">                
            </div>
            <div class="col-12 col-md-8">
                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" class="form-control" value="<?= $endereco; ?>">                
            </div>
            <div class="col-12 col-md-2">
                <label for="bairro">Bairro:</label>
                <input type="text" name="bairro" id="bairro" class="form-control" value="<?= $bairro; ?>">                
            </div>
        </div>
        <button type="submit" class="btn btn-success margin">
            <i class="fas fa-check"></i>Gravar Dados
        </button>
    </form>
    <?php
        //verificar se o id esta vazio
        if (empty($id)) $id = 0;
    ?>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#datanascimento').inputmask('99/99/9999');
            $('#cpf').inputmask('999.999.999-99');
            $('#telefone').inputmask('(99) 9999-9999');
            $('#celular').inputmask('(99) 99999-9999');
        });
        function verificarCpf(cpf){

            //funcao em ajax para verificar
            $.get("verificarCpf.php",{cpf:cpf,id:<?=$id;?>},function(dados){
                if (dados != "") {
                    //mostrar o erro retornado pelo arquivo
                    alert(dados);
                    //zerar o cpf
                    $("#cpf").val("");
                }
            })
        }

        $("#cep").blur(function(){
            //puxar o cep
            cep = $("#cep").val();
            cep = cep.replace(/\D/g, '');
            //verifica se está em branco
            if (cep == "") {
                alert("Preencha o CEP");
            } else {
                //Consulta o viacep
                $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                    $("#nome_cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                    $("#endereco").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    
                    //buscar o id da cidade
                    $.get("buscarCidade.php",{cidade:dados.localidade,estado:dados.uf},function(dados){
                            if (dados != "Erro" ) 
                                $("#cidade_id").val(dados);
                            else
                                alert(dados);
                    })
                    //focar no campo endereço
                    $("#endereco").focus();
                })
            }
        })
    </script>
</div>