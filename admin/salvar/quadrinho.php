<?php
//verificar se esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}

    if ( $_POST ){

        include "functions.php";
        include "config/conexao.php";
        
        $id = $titulo = $data = $numero = $valor = $resumo = $tipo_id = $editora_id = "";

        foreach ($_POST as $key => $value) {
        $$key = trim ( $value );
        }

        //print_r ( $_FILES ); print_r ( $_POST );

        if ( empty ( $titulo ) ) {
            echo "<script>alert('Preencha o título!');history.back();</script>";
            exit;
        }elseif ( empty ( $tipo_id ) ) {
            echo "<script>alert('Selecione o tipo de quadrinho!');history.back();</script>";
            exit;
        }

        //iniciar uma transacao
        $pdo->beginTransaction();

        //formatando os valores
        $data = formatar( $data );
        $numero = retirar( $numero );
        $valor = formatarValor( $valor );

        $arquivo = time()."-".$_SESSION["hqs"]["id"];

        if (empty ( $id ) ) {
            //inserir
            $sql = "insert into quadrinho (titulo, numero, data, capa, resumo, valor,
            tipo_id, editora_id) values (:titulo, :numero, :data, :capa, :resumo, :valor, :tipo_id, :editora_id)";
        
            $consulta = $pdo->prepare($sql);
            $consulta->bindParam(":titulo", $titulo);
            $consulta->bindParam(":numero", $numero);
            $consulta->bindParam(":data", $data);
            $consulta->bindParam(":capa", $arquivo);
            $consulta->bindParam(":resumo", $resumo);
            $consulta->bindParam(":valor", $valor);
            $consulta->bindParam(":tipo_id", $tipo_id);
            $consulta->bindParam(":editora_id", $editora_id);

        }else{
                //editar - update
                //qual arquivo ira ser gravado
            if ( !empty ( $_FILES["capa"]["name"] ) ) 
             $capa = $arquivo;

             $sql = "update quadrinho set titulo = :titulo, numero = :numero, valor = :valor,
             resumo = :resumo, capa = :capa, tipo_id = :tipo_id, editora_id = :editora_id, data = :data where id = :id limit 1";
             
             $consulta = $pdo->prepare($sql);
             $consulta->bindParam(":titulo",$titulo);
             $consulta->bindParam(":numero",$numero);
             $consulta->bindParam(":valor",$valor);
             $consulta->bindParam(":resumo",$resumo);
             $consulta->bindParam(":capa",$capa);
             $consulta->bindParam(":tipo_id",$tipo_id);
             $consulta->bindParam(":editora_id",$editora_id);
             $consulta->bindParam(":data",$data);
             $consulta->bindParam(":id",$id);

        }

        if ($consulta->execute() ) {

            //verificar se o arquivo não esta sendo enviado
            //capa deve estar vazia e o não pode estar vazio - editando
            if ( (empty($_FILES["capa"]["type"] ) ) and ( !empty( $id ) ) ){
                 //gravar no banco
                $pdo->commit();
                echo "<script>alert('registro salvo');location.href='listar/quadrinho';</script>";
                exit;
            }

            //verificar se o tipo de imagem é JPG
            if ($_FILES["capa"]["type"] != "image/jpeg" ){
                echo "<script>alert('Selecione uma imagem JPG válida!');history.back();</script>";
                exit;
            }
            //copiar a imagem para o servidor
            if( move_uploaded_file($_FILES["capa"]["tmp_name"], "../fotos/".$_FILES["capa"]["name"]) ) {

                //redimensionar imagens
                $pastaFotos = "../fotos/";
                $imagem     = $_FILES["capa"]["name"];
                $nome       = $arquivo;
                redimensionarImagem($pastaFotos,$imagem,$nome);

                //gravar no banco
                $pdo->commit();
                echo "<script>alert('registro salvo');location.href='listar/quadrinho';</script>";
                exit;
            }
           //erro ao gravar ou enviar pro servidor
           echo "<script>alert(''Erro ao gravar ou enviar para o servidor!);history.back();</script>"; 
        }
  
        exit;
}

echo "<p class='alert alert-danger'>Requisição invalida</p>";
?>