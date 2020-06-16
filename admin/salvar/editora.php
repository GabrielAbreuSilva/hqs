<?php
//verificar se nao esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}


//verificar se existem dados no POST
if ($_POST) {
    //recuperar as variaveis
    $id = $nome = $site = "";

    foreach ($_POST as $key =>$value){
        //guardar as variaveis
        $$key = trim ($value);
        //id
    }

    //validar os campos
    if (empty($nome)){
        echo '<script>alert("Preencha o campo nome");history.back();</script>';
    exit;    
}
//validar se é uma URL valida
elseif(!filter_var($site, FILTER_VALIDATE_URL)){
    echo '<script>alert("Preencha uma URL válida");history.back;</script>';
    exit;
}
//verificar se existe um cadastro com este nome
$sql = "select id from editora where nome = ? and id <> ? limit 1";
//usar o pdo / prepare para executar o sql
$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $nome);
$consulta->bindParam(2, $id);
//executar o sql
$consulta->execute();
//puxar os dados (id)
$dados = $consulta->fetch(PDO::FETCH_OBJ);

//verificar se esta vazio, setem algo é pq existe um reistro com o nome registrada
if(!empty($dados->id)){
    echo '<script>alert("Ja existe uma editora com este nome registrada");history.back();</script>';
    exit;
}
//se o id estiver em branco - insert
//se o id estiver preenchido - update
if (empty($id)) {
    //inserir os dados no banco
    $sql = "insert into editora (nome, site)values(? , ?)";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $nome);
    $consulta->bindParam(2, $site);
    
}else{
    //atualizar dados 
    $sql = "update editora set nome = ?, site = ? where id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $nome);
    $consulta->bindParam(2, $site);
    $consulta->bindParam(3, $id);

}
//executar e verificar se deu certo
if($consulta->execute() ){
    echo '<script>alert("Registro Salvo");location.href="listar/editora";</script>';
}else{
    echo '<script>alert("Erro ao salvar");history.back();</script>';
    exit;
}


}else{
    //mensagem de erro
    //javascript - mensagem alert
    //retornar hostory.back
    echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
}
?>