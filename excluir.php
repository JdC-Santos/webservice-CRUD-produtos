<?php 
	require_once 'functions.php';

	$cd = isset($_POST['cd_usuario']) ? $_POST['cd_usuario'] : 0;
	$hash = isset($_POST['cd_hash_login']) ? $_POST['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_POST['excluir']) && $_POST['excluir'] == "adm" && isset($_POST['cd'])){
	
		if(removerAdmin($_POST['cd'])){
			$json['status'] = 1;
			$json['msg'] = 'Administrador excluido com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel excluir o administrador';
		}
		echo json_encode($json);
	}

	if(isset($_POST['excluir']) && $_POST['excluir'] == "prod" && isset($_POST['cd'])){
		
		if(removerProduto($_POST['cd'])){
			$json['status'] = 1;
			$json['msg'] = 'Produto excluido com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel excluir o produto';
		}
		echo json_encode($json);
	}