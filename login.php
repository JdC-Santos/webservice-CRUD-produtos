<?php 
	require_once 'functions.php';

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

	if(isset($_POST['validar'])){
		echo $_POST['validar'];
		echo "okokok";
	}