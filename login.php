<?php 
	require_once 'functions.php';

	if(isset($_POST['user']) && isset($_POST['pw'])){
		
		$usuarios = listaAdmin($_POST['user'],$_POST['pw']);

		if(is_array($usuarios) && count($usuarios) == 1){
			$res = gerarHashLogin($usuarios[0]);
			echo json_encode($res);
		}
	}