<?php
//verificar se nao esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}


//verificar se existem dados no POST
if ($_POST) {
    //recuperar as variaveis
    $id = $tipo = "";

    foreach ($_POST as $key =>$value){
        //guardar as variaveis
        $$key = trim ($value);
        //id
    }

    //validar os campos
    if (empty($tipo)){
        echo '<script>alert("Preencha o campo Tipo de Quadrinho");history.back();</script>';
    exit;    
}

//verificar se existe um cadastro com este nome
$sql = "select id from tipo where tipo = ? and id <> ? limit 1";
//usar o pdo / prepare para executar o sql
$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $tipo);
$consulta->bindParam(2, $id);
//executar o sql
$consulta->execute();
//puxar os dados (id)
$dados = $consulta->fetch(PDO::FETCH_OBJ);

//verificar se esta vazio, se tem algo é pq existe um reistro com o nome registrada
if(!empty($dados->id)){
    echo '<script>alert("Já existe um tipo de quadrinho registrado!");history.back();</script>';
    exit;
}
//se o id estiver em branco - insert
//se o id estiver preenchido - update
if (empty($id)) {
    //inserir os dados no banco
    $sql = "insert into tipo (tipo)values(?)";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $tipo);
   
}else{
    //atualizar dados 
    $sql = "update tipo set tipo = ? where id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $tipo);
    $consulta->bindParam(2, $id);

}
//executar e verificar se deu certo
if($consulta->execute() ){
    echo '<script>alert("Registro Salvo");location.href="listar/tipo";</script>';
}else{
    echo '<script>alert("Erro ao salvar");history.back();</script>';
   
}


}else{
    //mensagem de erro
    //javascript - mensagem alert
    //retornar hostory.back
    echo '<script>alert("Erro ao realizar requisição");history.back();</script>';
}
?>