<?php 
	require_once 'conexao.php';

	if(isset($_POST['listarAdmin'])){

		$cd = isset($_POST['cd']) ? $_POST['cd']: null;
		$nome = isset($_POST['nome']) ? $_POST['nome']: null;
		$email = isset($_POST['email']) ? $_POST['email']: null;

		$usuarios = listarAdmin(null,null, $cd, $nome $email);
		echo json_encode($usuarios);
	}

	if(isset($_POST['listarProduto'])){

		$cd = isset($_POST['cd']) ? $_POST['cd']: null;
		$nome = isset($_POST['nome']) ? $_POST['nome']: null;
		$status = isset($_POST['status']) ? $_POST['status']: null;
		$cod_barras = isset($_POST['cod_barras']) ? $_POST['cod_barras']: null;

		$produtos = listarProdutos($cd, $nome, $status, $cod_barras);
		echo json_encode($produtos);
	}