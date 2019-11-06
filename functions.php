<?php 
	require_once 'conexao.php';
	
	date_default_timezone_set('America/Sao_Paulo');

	if(empty($GLOBALS['conn'])){
		echo "sem conexao com o banco de dados!";
		exit;
	}


	function query($sql){
		$query = $GLOBALS['conn']->prepare($sql);
		if($query->execute()) return true;
	}

	function select($sql){

		$query = $GLOBALS['conn']->prepare($sql);

		if($query->execute()){

			if($query->rowCount() > 0){
				
				while($fetch = $query->fetch(PDO::FETCH_ASSOC)){
					$arr[] = $fetch;
				}
				return $arr;
			}
		}
	}

	function criarAdmin($nome, $login, $email, $senha,int $nivel){
		
		$cols 	= 'cd_usuario, nm_usuario, nm_login, nm_email, cd_senha,cd_nivel_acesso';
		$sql 	= "INSERT INTO usuario ($cols)";

		$vals 	= "null,'$nome', '$login', '$email', '$senha', '$nivel' ";
		$sql   .= " VALUES ($vals)";

		return query($sql);
	}

	function criarProduto($nome, $qtd, $status, $valor, $foto, $cod_barras){

		$cols 	= 'cd_produto, nm_produto, qtd_produto, ic_status, vl_produto,';
		$cols  .= 'ds_foto,cd_barras,created_at';

		$sql 	= "INSERT INTO produto ($cols)";

		if(!empty($foto)){
			$foto = salvarFoto($foto);	
		}		
			
		$created_at = date('Y-m-d H:i:s');
		$vals 	= "null,'$nome','$qtd','$status','$valor','$foto','$cod_barras','$created_at'";
		$sql   .= " VALUES ($vals)";

		return query($sql);	
		
	}
	
	function listarAdmin($user = null, $pw = null, int $cd = null, $nome = null, $email = null){

		$user = addslashes($user);
				$nome = addslashes($nome);
		$email = addslashes($email);

		$sql  = "SELECT cd_usuario, nm_usuario, nm_email,nm_login,cd_nivel_acesso, cd_hash_login ";
		$sql .=	"FROM usuario WHERE cd_usuario > 0";

		if(!empty($user)) $sql .= " AND nm_login = '".$user."' ";
		if(!empty($pw)) $sql .= " AND cd_senha = '".md5($pw)."' ";
		if(!empty($cd))	$sql .= " AND cd_usuario = ".$cd;
		if(!empty($nome)) $sql .= " AND nm_usuario LIKE '%".$nome."%' ";
		if(!empty($email)) $sql .= " AND nm_email = '".$email."' ";

		return select($sql);
	}

	function listarProdutos(int $cd = null, $nome = null,int $status = null,int $cod_barras = null){

		$nome = addslashes($nome);

		$sql = "SELECT * FROM produto WHERE cd_produto > 0";

		if(!empty($cd)) $sql .= " AND cd_produto = ".$cd;
		if(!empty($nome)) $sql .= " AND nm_produto = '".$nome."' ";
		if(!empty($status)) $sql .= " AND ic_status = '".$status."' ";
		if(!empty($cod_barras)) $sql .= " AND cd_barras = '".$cod_barras."' ";

		return select($sql);
	}

	function editarAdmin(int $cd, $nome, $login, $email, $senha, $nivel){
		$sql = "UPDATE usuario SET cd_usuario = $cd ";

		if(!empty($nome))  $sql .= ", nm_usuario = '$nome' ";
		if(!empty($login)) $sql .= ", nm_login = '$login' ";
		if(!empty($email)) $sql .= ", nm_email = '$email' ";
		if(!empty($senha)){
			$senha = md5($senha);
			$sql .= ", cd_senha = '$senha' ";
		}
		if(!empty($nivel)) $sql .= ", cd_nivel_acesso = '$nivel' ";
		$sql .= " WHERE cd_usuario = ".$cd;

		return query($sql);	
	}

	function editarProduto($cd, $nome, $qtd, $status, $valor, $foto, $cod_barras){

		$prod = listarProdutos($cd)[0];

		if(!empty($foto)){
			$foto = salvarFoto($foto, $prod['ds_foto']);
		}

		$sql = "UPDATE produto SET cd_produto = ".$cd;

		if(!empty($nome)) $sql .= ", nm_produto = '$nome'";
		if(!empty($qtd)) $sql .= ", qtd_produto = '$qtd'";
		if(!empty($status)) $sql .= ", ic_status = '$status'";
		if(!empty($valor)) $sql .= ", vl_produto = '$valor'";
		if(!empty($foto)) $sql .= ", ds_foto = '$foto'";
		if(!empty($cod_barras)) $sql .= ", cd_barras = '$cod_barras'";

		$updated_at = date('Y-m-d H:i:s');
		$sql .= ",updated_at = '$updated_at' ";

		$sql .= " WHERE cd_produto = ".$cd;

		return query($sql);
	}

	function removerAdmin(int $cd){
		$sql = "DELETE FROM usuario WHERE cd_usuario = ".$cd;
		return query($sql);
	}

	function removerProduto(int $cd){	
		$prod = listarProdutos($cd)[0];
		deletaFoto($prod['ds_foto']);
		$sql = "DELETE FROM produto WHERE cd_produto = ".$cd;
		return query($sql);
	}

	function gerarHashLogin($usuario){

		$ret = ['status' => 0];
		$hash = md5($usuario['nm_login']);
		$hash .= ".".md5(date('yHmdis'));
		$cd = $usuario['cd_usuario'];

		$sql = "UPDATE usuario SET cd_hash_login = '$hash' WHERE cd_usuario = ".$cd;		

		if(query($sql)){
			$ret['status'] 	= 1;
			$ret['cd']		= $usuario['cd_usuario'];
			$ret['nome'] 	= $usuario['nm_usuario'];
			$ret['hash'] 	= $hash;
		}
		return $ret;
	}

	function verificarPermissao(int $cd, $hash){
		$hash = addslashes($hash);
		$sql  = "SELECT * FROM usuario WHERE cd_usuario = $cd AND cd_hash_login = '$hash' ";
		$sql .= " AND cd_hash_login IS NOT NULL";

		if(!is_array(select($sql))){
			$json['status'] = 2;
			$json['error'] = "denied";
			echo json_encode($json);
			exit;
		}
	}

	function deletaFoto($foto = null){
		if(!empty($foto) && file_exists($foto)) unlink($foto);
	}

	function salvarFoto($foto, $old = null){

		if(!is_dir('fotos/')) mkdir('fotos/',0777);
		deletaFoto($old);

		$tipos_aceitos = array('gif','jpg','jpe','jpeg','png');
		$tipo = explode('/',$foto['type'])[1];
		$file_src = 'fotos/'.date('dmyhis').$foto['name'];

		if(in_array($tipo,$tipos_aceitos))
			if(move_uploaded_file($foto['tmp_name'], $file_src)) return $file_src;
	}