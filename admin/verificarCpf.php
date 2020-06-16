<?php
	session_start();

	if (!isset ($_SESSION["hqs"]["id"])) {
    exit;
	}

	$cpf = $_GET["cpf"] ?? "";
	$id  = $_get["id"] ?? "";


	if (empty($cpf)) {
		echo "O CPF está vazio";
		exit;
	}

	include "config/conexao.php";
	include "functions.php";

	$msg = validaCPF($cpf);

	if ($msg != 1) {
		echo $msg;
		exit;
	}

	//verifica se existe alguem com este mesmo cpf
	if (($id != 0) or ( empty($id ) )){
		//inserindo - ninguem pode ter esse cpf
		$sql = "select id from cliente where cpf = :cpf limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":cpf", $cpf);
	} else {
		//atualizando - ninguem fora o usuario pode ter esse cpf
		$sql  = "select id from cliente where cpf = :cpf and id <> :id limit 1";
		$consulta = $pdo->prepare($sql);
		$consulta->bindParam(":cpf", $cpf);
		$consulta->bindParam(":ic", $id);
	}

	$consulta->execute();
	$dados = $consulta->fetch(PDO::FETCH_OBJ);

	if (!empty($dados->id)) {
		echo "Já existe um cliente cadastado com este CPF!";
	}