<?php
	
	# Oppening connection with the database.
	$connection = mysql_connect("localhost", "root", "root");
	if (!$connection) {
		die("<p>The database server is not available</p>" .
		"<p>Error code: " . mysql_connect_errno() .
		": " . mysql_connect_error() . "</p>");
	}

	# Selecting a database.
	$database  = mysql_select_db("trabalhos", $connection);
	if (!$database) {
		die("<p>It was not possible to select the database</p>" .
		"<p>Error code: " . mysql_errno($connection) .
		": " . mysql_error($connection) . "<br />");
	}

	$query = "SELECT ALUNOS.matricula FROM ALUNOS";
	$students = mysql_query($query);


	while ($row = mysql_fetch_array($students)) {
    	$queryCountCorret  = "SELECT COUNT(*)
    						  FROM TRABALHOS 
    						  WHERE TRABALHOS.correto = 1 AND row.matricula = TRABALHOS.aluno";

    	$queryCountAll = "SELECT COUNT(*) FROM
    					  TRABALHOS
    					  WHERE row.matricula = TRABALHOS.aluno";

    	$grade = ($queryCountCorrect * 100) / $queryCountAll;

    	//Criar o método de update aqui =)
	}

?>