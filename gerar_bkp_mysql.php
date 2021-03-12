<?php 

	session_start();

	//include_once('conexao2.php');

	$result_tabela = "SHOW TABLES";
	$resultado_tabela = mysqli_query($conn, $result_tabela);


	while($row_tabela = mysqli_fetch_row($resultado_tabela)){
		$tabelas[] = $row_tabela[0]; //posicao 0 que esta o nome da tabela
	}

	var_dump($tabelas[0]);

	
	$result = "";

	foreach($tabelas as $tabela){
		//echo $tabela . "<br>";

		//Pesquisar o nome das colunas
		$result_colunas = "SELECT * FROM " . $tabela;
		$resultado_colunas = mysqli_query($conn, $result_colunas);
		$num_colunas = mysqli_num_fields($resultado_colunas);
		//	echo $tabela . " - " . $num_colunas . "<br >"; Exibi numero de colunas de cada tabela


		// Instrucao para deletar tabela se ela existir
		$result.= 'DROP TABLE IF EXISTS '.$tabela.';';
				
		// Pesquisar como a coluna é criada
		$result_cr_col = "SHOW CREATE TABLE " . $tabela;
		$resultado_cr_col = mysqli_query($conn, $result_cr_col);
		$row_cr_col = mysqli_fetch_row($resultado_cr_col);

		//var_dump($row_cr_col);

		$result .="\n\n" . $row_cr_col[1] . ";\n\n";

		for($i = 0; $i < $num_colunas;$i++ ){
			//Ler o valor de cada coluna no banco de dados.

			while($row_tp_col = mysqli_fetch_row($resultado_colunas)){
				//var_dump($row_tp_col);
				//Criar a instrucao da QUERY para inserir os dados
			$result .= 'INSERT INTO '.$tabela.' VALUES(';

				//Ler os dados da Tabela
				for($j = 0; $j < $num_colunas; $j++){
			//addslashes - funcao que adiciona barra invertida a uma string
					$row_tp_col[$j] = addslashes($row_tp_col[$j]);
			//str_replace - substitui todas as ocorrencias da string \n plea \n	
					$row_tp_col[$j] = str_replace("\n", "\\n", $row_tp_col[$j]);

					if(isset($row_tp_col[$j])){
						if(!(empty($row_tp_col[$j]))){
							$result .= '"'.$row_tp_col[$j].'"';
						}else{
							$result .= 'NULL';
						}
					}else{
						$result .= 'NULL';
					}
					if($j < $num_colunas -1){
						$result .= ',';
					}
				}
				$result .= ");\n";
			}
		}
		$result .= "\n\n";

	}

	echo $result;

	//////////////Criar o diretorio do backup //////////////////////////////
	$diretorio = 'backup/';
	if(!is_dir($diretorio)){
		mkdir($diretorio, 0777, true);
		chmod($diretorio, 0777);
	}

	//Criar o nome de backup

	$data = date('Y-m-d-h-i-s');
	$nome_arquivo = $diretorio."db_backup_".$data;

	$handle = fopen($nome_arquivo.'.sql','w+');
	fwrite($handle, $result);
	fclose($handle);

	//Montar o link do arquivo
	$download = $nome_arquivo . ".sql";

	if(file_exists($download)){
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private", false);
		header("Content-Type: application/force-download");
		header("Content-Disposition: attachment; filename=\"" . basename($download) . "\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: " . filesize($download));
		readfile($download);
$_SESSION['msg'] = "<span style='color: green'>Exportar BD com sucesso</span>";
	}else{
$_SESSION['msg'] = "<span style='color: red'>Exportar BD com sucesso</span>";
	}

 ?>