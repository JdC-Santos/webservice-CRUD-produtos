<?php 
	require_once 'functions.php';

	$cd = isset($_POST['cd_usuario']) ? $_POST['cd_usuario'] : 0;
	$hash = isset($_POST['cd_hash_login']) ? $_POST['cd_hash_login'] : null;
	verificarPermissao($cd, $hash);

	if(isset($_POST['criar']) && $_POST['criar'] == "adm"){

		$nome = isset($_POST['nome']) ? addslashes($_POST['nome']) : false;
		$login = isset($_POST['login']) ? addslashes($_POST['login']) : false;
		$email = isset($_POST['email']) ? addslashes($_POST['email']) : false;
		$senha = isset($_POST['pw']) ? $_POST['pw'] : false;
		$nivel = isset($_POST['nivel']) ? addslashes($_POST['nivel']) : false;
		
		if($nome && $login && $email && $senha && $nivel){
			if(criarAdmin( $nome, $login, $email, $senha, $nivel)){
				$json['status'] = 1;
				$json['msg'] = 'Administrador cadastrado com sucesso!';
			}else{
				$json['status'] = 0;
				$json['msg'] = 'Erro: não foi possivel cadastrar o administrador';
			}
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: campos incorretos';
		}
		echo json_encode($json);
	}

	if(isset($_POST['criar']) && $_POST['criar'] == "prod"){

		$nome = isset($_POST['nome']) ? addslashes($_POST['nome']) : false;
		$qtd = isset($_POST['qtd']) ? addslashes($_POST['qtd']) : false;
		$status = isset($_POST['status']) ? addslashes($_POST['status']) : false;
		$valor = isset($_POST['valor']) ? addslashes($_POST['valor']) : false;
		$foto = isset($_FILES['foto']) ? $_FILES['foto'] : false;
		$cod_barras = isset($_POST['cod_barras']) ? addslashes($_POST['cod_barras']) : false;

		if($nome && $qtd && $status && $valor && $cod_barras){
			if(criarProduto($nome, $qtd, $status, $valor, $foto, $cod_barras)){
				$json['status'] = 1;
				$json['msg'] = 'Produto cadastrado com sucesso!';
			}else{
				$json['status'] = 0;
				$json['msg'] = 'Erro: não foi possivel cadastrar o produto';
			}
		}else{
			$json['status'] = 0;
			$json['msg'] = 'Erro: campos incorretos';
		}
		echo json_encode($json);
	}