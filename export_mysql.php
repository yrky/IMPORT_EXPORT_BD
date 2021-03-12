<?php

session_start();

?>


<!DOCTYPE html>
<html>
<head>
	<title>Exportar Banco de dados</title>
</head>
<body>
	<h2>Exportar Banco de Dados</h2>

	<?php
		if(isset($_SESSION['msg'])){
			echo "<p>" . $_SESSION['msg'] . "</p>";
			unset($_SESSION['msg']);

		}
	?>
<form method="POST" action="proc_export_bd.php" enctype="multipart/form-data">
	<label>Servidor: </label>			
	<input type="text" name="servidor" placeholder="Nome no Servidor"><br><br>

	<label>Usuario: </label>			
	<input type="text" name="usuario" placeholder="Nome no Usuario"><br><br>

	<label>Senha: </label>			
	<input type="password" name="senha" placeholder="Senha"><br><br>

	<label>Base de Dados: </label>			
	<input type="text" name="dbname" placeholder="Nome da base de dados"><br><br>

	<input type="submit" value="Exportar">

	</form>
</body>
</html>