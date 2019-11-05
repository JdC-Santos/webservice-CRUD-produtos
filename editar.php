<?php 
	require_once 'functions.php';

	$cd = isset($_POST['cd_usuario']) ? $_POST['cd_usuario'] : 0;
	$hash = isset($_POST['cd_hash_login']) ? $_POST['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_POST['editar']) && $_POST['editar'] == "adm" && isset($_POST['cd'])){

		$cd = $_POST['cd'];
		$nome  = isset($_POST['nome'])  ? addslashes($_POST['nome']) : false;
		$login = isset($_POST['login']) ? addslashes($_POST['login']) : false;
		$email = isset($_POST['email']) ? addslashes($_POST['email']) : false;
		$senha = isset($_POST['pw']) ? $_POST['pw'] : false;
		$nivel = isset($_POST['nivel']) ? addslashes($_POST['nivel']) : false;

		if(editarAdmin($cd, $nome, $login, $email, $senha, $nivel)){
			$json['status'] = 1;
			$json['msg'] = 'Administrador editado com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel editar o administrador';
		}
		echo json_encode($json);
	}

	if(isset($_POST['editar']) && $_POST['editar'] == "prod" && isset($_POST['cd'])){

		$cd = $_POST['cd'];
		$nome  = isset($_POST['nome'])  ? addslashes($_POST['nome']) : false;
		$qtd = isset($_POST['qtd']) ? addslashes($_POST['qtd']) : false;
		$status = isset($_POST['status']) ? addslashes($_POST['status']) : false;
		$valor = isset($_POST['valor']) ? $_POST['valor'] : false;
		$cod_barras = isset($_POST['cod_barras']) ? $_POST['cod_barras'] : false;

		if(editarProduto($cd, $nome, $qtd, $status, $valor, $foto, $cod_barras)){
			$json['status'] = 1;
			$json['msg'] = 'Produto editado com sucesso!';
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: não foi possivel editar o produto';
		}
		echo json_encode($json);
	}