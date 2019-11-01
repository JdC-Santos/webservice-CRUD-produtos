<?php 
	require_once 'functions.php';

	if(isset($_GET['user']) && isset($_GET['pw'])){
		
		$usuarios = listaAdmin($_GET['user'],$_GET['pw']);

		if(is_array($usuarios) && count($usuarios) == 1){
			$res = gerarHashLogin($usuarios[0]);
			echo json_encode($res);
		}else{
			$json['status'] = 0;
			$json['msg'] = "Usuário ou senha incorretos";
			echo json_encode($json);
		}
	}