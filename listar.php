<?php 
	require_once 'functions.php';

	$cd = isset($_GET['cd_usuario']) ? $_GET['cd_usuario'] : 0;
	$hash = isset($_GET['cd_hash_login']) ? $_GET['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_GET['listar']) && $_GET['listar'] == "adm"){

		$cd = isset($_GET['cd']) ? $_GET['cd']: null;
		$nome = isset($_GET['nome']) ? $_GET['nome']: null;
		$email = isset($_GET['email']) ? $_GET['email']: null;

		$usuarios = listarAdmin(null,null, $cd, $nome, $email);
		echo json_encode($usuarios);
	}

	if(isset($_GET['listar']) && $_GET['listar'] == "prod"){

		$cd = isset($_GET['cd']) ? $_GET['cd']: null;
		$nome = isset($_GET['nome']) ? $_GET['nome']: null;
		$status = isset($_GET['status']) ? $_GET['status']: null;
		$cod_barras = isset($_GET['cod_barras']) ? $_GET['cod_barras']: null;

		$produtos = listarProdutos($cd, $nome, $status, $cod_barras);
		echo json_encode($produtos);
	}

	//?cd_usuario=1&cd_hash_login=fada1071eb309cb3b778487f71a41ac1.77525f8f342567b5582927cc5512ac49&listar=adm