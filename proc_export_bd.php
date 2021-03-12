<?php 
	
	session_start();

	$servidor = filter_input(INPUT_POST, 'servidor', FILTER_SANITIZE_STRING);
	$usuario = filter_input(INPUT_POST,'usuario', FILTER_SANITIZE_STRING);
	$senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
	$dbname = filter_input(INPUT_POST,'dbname',FILTER_SANITIZE_STRING);

	 

	 $conn = mysqli_connect($servidor, $usuario, $senha, $dbname);

	if(!$conn){
		header("Location: export_mysql.php");
$_SESSION['msg'] = "<span style='color: red'>Erro ao exportar o Backup</span>";
		//die("Falha ao tentar se conectar" . mysqli_connect_error());		
	}else{
		echo "Conexao realizada com sucesso! <br><br>";

	//Incluir o arquivo que gera o backup
	 include_once('gerar_bkp_mysql.php');

	 header("Location: export_mysql.php");
		
	}
	 

 ?>