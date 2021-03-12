<?php 

session_start();

	//receber dados do formulario

$arquivo = $_FILES['arquivo']['tmp_name'];

$servidor = filter_input(INPUT_POST,'servidor', FILTER_SANITIZE_STRING);
$usuario = filter_input(INPUT_POST,'usuario', FILTER_SANITIZE_STRING);
$senha = filter_input(INPUT_POST,'senha', FILTER_SANITIZE_STRING);
$dbname = filter_input(INPUT_POST,'dbname', FILTER_SANITIZE_STRING);

//Criar a conexao com BD

$conn = mysqli_connect($servidor, $usuario, $senha, $dbname);


//Ler os dados do arquivo e transformar em STRING
$dados = file_get_contents($arquivo);

 //echo $dados;

mysqli_multi_query($conn, $dados);


$_SESSION['msg'] = "<span style='color: green'>Exportar BD com sucesso</span>";
	header("Location: importar_bd_mysql.php");
 ?>