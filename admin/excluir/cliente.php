<?php

if (!isset($_SESSION['hqs']['id'])) {
    exit;
}

// Verificar se o id está vazio
if (empty($id)) {
    echo "<script>alert('Não foi possível excluir o registro!');history.back();</script>";
    exit;
}

// Excluir 
$sql = "delete from cliente where id = ? limit 1";

$consulta = $pdo->prepare($sql);
$consulta->bindParam(1, $id);

// Verificar se não executou
if (!$consulta->execute()) {

    echo "<script>alert('Erro ao excluir');history.back();</script>";
    exit;
}

echo "<script>alert('Cliente deletado com sucesso!');history.back();</script>";