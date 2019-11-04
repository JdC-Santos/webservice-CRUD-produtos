<?php 
	require_once 'functions.php';

	if(isset($_POST['params'])){
		print_r($_POST['params']);
		$res = json_decode($_POST['params'])
		print_r($res);
		echo "valor: ".$res->validar;
		echo "2valor: ".$res['validar'];
	}


	if(isset($_POST['user']) && isset($_POST['pw']) ){
		
		$usuarios = listarAdmin($_POST['user'],$_POST['pw']);

		if(is_array($usuarios) && count($usuarios) == 1){
			$res = gerarHashLogin($usuarios[0]);
			echo json_encode($res);
		}else{
			$json['status'] = 0;
			$json['msg'] = "Usuário ou senha incorretos";
			echo json_encode($json);
		}
	}