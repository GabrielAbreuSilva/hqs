<?php
//verificar se esta logado
if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
}
//iniciar as variaveis
$nome = $site = "";


//se n existe o id
if (!isset($id)) $id = ""; 


//verificar se existe um id
if (!empty($id)) {
    //selecionar os dados do banco
    $sql = "select * from editora where id = ? limit 1";
    $consulta = $pdo->prepare($sql);
    $consulta->bindParam(1, $id);
    //$id - linha 255 do index.php
    $consulta->execute();
    $dados = $consulta->fetch(PDO::FETCH_OBJ);

    //separar os dados
    $id     = $dados->id;
    $nome   = $dados->nome;
    $site   = $dados->site;

}

?>
<div class="container">
    <h1 class="float-left">Cadastro da Editora</h1>
        <div class="float-right">
        <a href="cadastro/editora" class="btn btn-success">Novos Registros</a>
        <a href="listar/editora" class="btn btn-info">Lista Registros</a>
        </div> 

        <div class="clearfix"></div>

    <form class="formCadastro" method = "post" action="salvar/editora" 
    data-parsley-validate>
        <label for="id">ID</label>
        <input type="text" name="id" id="id" class="form-control" readonly value="<?=$id;?>">

        <label for="nome">Nome da editora</label>
        <input type="text" name="nome" id="nome" class="form-control" required data-parsley-required-message="Preencha este campo, por favor" value="<?=$nome;?>">

        <label for="nome">Site da editora</label>
        <input type="text" name="site" id="site" class="form-control" required data-parsley-required-message="Preencha este campo, por favor" value="<?=$site;?>">

        </br>

        <button type="submit" class="btn btn-success">
            <i class="fas fa-check"></i> Gravar Dados
        </button> 
          
        </form>
</div> <!-- container -->