<?php
	require_once('db.class.php');
	date_default_timezone_set('America/Sao_Paulo');
	$ip = $_SERVER['REMOTE_ADDR'];
    $data_hora = date_default_timezone_get();
	$data_hora=date('Y-m-d h:i:s');
    $email = $_POST['email'];
    
	$objDb = new db();
    $link = $objDb->conecta_mysql();
    
	$email_existe = false;
	
//verificar se o email já foi cadastrado
	$sql = " select * from tb_usuarios where email = '$email' ";
	if($resultado_id = mysqli_query($link, $sql)) {
		$dados_usuario = mysqli_fetch_array($resultado_id);
		if(isset($dados_usuario['email'])){
			$email_existe = true;
		} 
	} else {
		echo 'Erro ao tentar localizar o registro de email';
	}

    if($email_existe){
		$retorno_get = '';
		if($usuario_existe){
			$retorno_get.= "erro_usuario=1&";
		}
		if($email_existe){
			$retorno_get.= "erro_email=1&";
        }
//caso já tenha cadastro, não será alocado novamente e retornará a index.
		header('Location: index.php?'.$retorno_get);
		die();
	}
	
	
	$data_hora= date("Y-m-d H:i:s");
	$ip=$_SERVER["REMOTE_ADDR"];
	$sql = " insert into tb_usuarios( email, ip, data_hora) values ( '$email', '$ip' , '$data_hora') ";
	//executar a query
	if(mysqli_query($link, $sql)){
        echo 'Email cadastrado com sucesso!';
	} else {
		echo 'Erro ao registrar o email!';
    }
?>