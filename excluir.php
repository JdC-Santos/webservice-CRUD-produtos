<?php 
	require_once 'functions.php';

	$cd = isset($_POST['cd_usuario']) ? $_POST['cd_usuario'] : 0;
	$hash = isset($_POST['cd_hash_login']) ? $_POST['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_GET['excluir']) && $_GET['excluir'] == "adm" && isset($_GET['cd'])){
	
		if(removerAdmin($_GET['cd'])){
			$json['status'] = 1;
			$json['msg'] = 'Administrador excluido com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel excluir o administrador';
		}
		echo json_encode($json);
	}

	if(isset($_GET['excluir']) && $_GET['excluir'] == "prod" && isset($_GET['cd'])){
		
		if(removerProduto($_GET['cd'])){
			$json['status'] = 1;
			$json['msg'] = 'Produto excluido com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel excluir o produto';
		}
		echo json_encode($json);
	}