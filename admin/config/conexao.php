<?php 
    //arquivo para criar conexao com o banco de dados mysql
    $servidor = "localhost";
	//em 99% dos casos é localhost

	//usuario de acesso ao banco
	$usuario = "root";
	$senha = "";

	//nome do banco de dados
	$banco = "hqs2020";

    try {
		//criar uma conexao com PDO
		$pdo = new PDO("mysql:host=$servidor;
			dbname=$banco;
			charset=utf8",
			$usuario,
			$senha);

	} catch (PDOException $erro) {

		//mensagem de erro
		$msg = $erro->getMessage();

		echo "<p>Erro ao conectar no banco de dados: $msg </p>";

	}