<?php
//verificar se nao esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}

//verificar se existem dados no POST
if ($_POST) {

    include "functions.php";
    include "config/conexao.php";

    //recuperar as variaveis
    $id = $nome = $cpf = $datanascimento = $telefone = $celular = $email = $senha = $cep = $foto = $cidade = $estado = $endereco = $bairro = "";

    foreach ($_POST as $key => $value) {
    	$$key = trim($value);
    }

    if ((empty($nome)) || (empty($cpf)) || (empty($datanascimento)) || (empty($email)) || (empty($senha)) || (empty($cep))) {
        echo "<script>alert('Algumas informações estão em branco!');history.back();</script>";
        exit;
    }

    // Verificar informações de endereço
    if ((empty($endereco)) || (empty($bairro)) || (empty($cidade_id)) || (empty($telefone))) {
        echo "<script>alert('Algumas informações estão em branco!');history.back();</script>";
        exit;
    }

     //transação
    $pdo->beginTransaction();

    //arrumar a data
    $data = formatar( $data );

    //hora atual + nome do cliente + id do usuário
    $arquivo = time() . "-" . $_SESSION["hqs"]["id"];

    if (empty($id)) {
    	$sql = "insert into cliente
    			(nome, cpf, datanascimento, telefone, celular, email, senha, cep, foto, cidade_id, endereco, bairro, complemento) 
    			values 
    			(:nome, :cpf, :datanascimento, :telefone, :celular, :email, :senha, :cep, :foto, :cidade_id, :endereco, :bairro, :complemento)";

    	$consulta = $pdo->prepare($sql);
    	$consulta->bindParam(":nome", $nome);
    	$consulta->bindParam(":cpf", $cpf);
    	$consulta->bindParam(":datanascimento", $datanascimento);
    	$consulta->bindParam(":telefone", $telefone);
    	$consulta->bindParam(":celular", $celular);
    	$consulta->bindParam(":email", $email);
    	$consulta->bindParam(":senha", $senha);
    	$consulta->bindParam(":cep", $cep);
    	$consulta->bindParam(":foto", $foto);
    	$consulta->bindParam(":cidade_id", $cidade_id);
    	$consulta->bindParam(":endereco", $endereco);
    	$consulta->bindParam(":bairro", $bairro);
    	$consulta->bindParam(":complemento", $complemento);
    
    } else {
    	//atualizar os dados
    	//se a foto não estiver vazia 
    	if ( !empty ( $_FILES["capa"]["name"] ) ) 
            $capa = $arquivo;

        $sql = "update cliente set 
        		nome = :nome, cpf = :cpf, datanascimento = :datanascimento, telefone = :telefone, celular = :celular,
        		email = :email, senha = :senha, cep = :cep, foto = :foto, cidade_id = :cidade_id, endereco = :endereco,
        		bairro = :bairro, complemento = :complemento
        		where id = :id limit 1";

        $consulta = $pdo->prepare($sql);
    	$consulta->bindParam(":nome", $nome);
    	$consulta->bindParam(":cpf", $cpf);
    	$consulta->bindParam(":datanascimento", $datanascimento);
    	$consulta->bindParam(":telefone", $telefone);
    	$consulta->bindParam(":celular", $celular);
    	$consulta->bindParam(":email", $email);
    	$consulta->bindParam(":senha", $senha);
    	$consulta->bindParam(":cep", $cep);
    	$consulta->bindParam(":foto", $foto);
    	$consulta->bindParam(":cidade_id", $cidade_id);
    	$consulta->bindParam(":endereco", $endereco);
    	$consulta->bindParam(":bairro", $bairro);
    	$consulta->bindParam(":complemento", $complemento);
    }

    //executar o comando do banco de dados
    if ($consulta->execute()) {

        //verifica se o arquivo não está sendo enviado
        //foto deve estar vazia e o id não pode estar vazio - editando
        if ((empty($_FILES["foto"]["type"])) && (!empty($id))) {
            $pdo->commit();
            echo "<script>alert('Registro salvo');location.href='listar/cliente';</script>";
            exit;
        }

        //verifica se a imagem é JPG
        if ($_FILES["foto"]["type"] != "image/jpeg") {
            echo "<script>alert('Selecione uma imagem JPG válida');history.back();</script>";
            exit;
        }

        //baixar a imagem para o servidor
        if (move_uploaded_file($_FILES["foto"]["tmp_name"], "../fotos/" . $_FILES["foto"]["name"])) {
            // Redimensionar imagem
            $pastaFotos = "../fotos/";
            $imagem = $_FILES["foto"]["name"];
            $nome = $arquivo;
            redimensionarImagem($pastaFotos, $imagem, $nome);

            //salvar no banco de dados
            $pdo->commit();
            echo "<script>alert('Registro salvo com sucesso!');location.href='listar/cliente';</script>";
            exit;
        }

        // Erro ao gravar
        echo "<script>alert('Erro ao salvar ou enviar arquivo para o servidor');history.back();</script>";
        exit;
    }
    exit;
}

echo "<p class='alert alert-danger'>Requisição invalida</p>";
?>

    