<?php 
	require_once 'conexao.php';

	if(isset($_POST['user']) && isset($_POST['pw'])){
		
		$user = addslashes($_POST['user']);
		$pw = md5($_POST['pw']);

		$sql = "SELECT * FROM 
					usuario 
				WHERE 
					nm_login = '$user' 
				AND 
					cd_senha = '$pw' LIMIT 1";
	}