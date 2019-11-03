<?php 
	require_once 'functions.php';

	$cd = isset($_POST['cd_usuario']) ? $_POST['cd_usuario'] : 0;
	$hash = isset($_POST['cd_hash_login']) ? $_POST['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_POST['listar']) && $_POST['listar'] == "adm"){

		$cd = isset($_POST['cd']) ? $_POST['cd']: null;
		$nome = isset($_POST['nome']) ? $_POST['nome']: null;
		$email = isset($_POST['email']) ? $_POST['email']: null;

		$usuarios = listarAdmin(null,null, $cd, $nome, $email);
		echo json_encode($usuarios);
	}

	if(isset($_POST['listar']) && $_POST['listar'] == "prod"){

		$cd = isset($_POST['cd']) ? $_POST['cd']: null;
		$nome = isset($_POST['nome']) ? $_POST['nome']: null;
		$status = isset($_POST['status']) ? $_POST['status']: null;
		$cod_barras = isset($_POST['cod_barras']) ? $_POST['cod_barras']: null;

		$produtos = listarProdutos($cd, $nome, $status, $cod_barras);
		echo json_encode($produtos);
	}

	//?cd_usuario=1&cd_hash_login=fada1071eb309cb3b778487f71a41ac1.77525f8f342567b5582927cc5512ac49&listar=adm