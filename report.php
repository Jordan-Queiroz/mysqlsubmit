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

	echo "antes do while <br />";
	while ($row = mysql_fetch_array($students)) {
		echo "entrei no while <br />";
		$matricula = (string)$row["matricula"];
		echo "peguei a matricula: ". $matricula . "<br />";

    	$queryCountCorret  = "SELECT COUNT(id)
    						  FROM TRABALHOS 
    						  WHERE TRABALHOS.aluno = $matricula AND TRABALHOS.correto = '1'";

    	$countCorrect = (float)mysql_query($queryCountCorret); 

    	echo "countCorrect: " . $countCorrect . "<br />";
    	$queryCountAll = "SELECT COUNT(*) FROM
    					  TRABALHOS
    					  WHERE TRABALHOS.aluno = $matricula";

    	$countAll = (float)mysql_query($queryCountAll);

    	echo "countAll: " . $countAll . "<br />";
    	$grade = ($countCorrect * 10) / $countAll;
    	echo "grade: " . $grade . "<br />";

    	$queryUpdateGrade = "UPDATE ALUNOS SET media = $grade WHERE matricula = $matricula";
    	if (mysql_query($queryUpdateGrade)) {
    		echo "Success";
    	} else {
    		echo "Error";
    	}

	}

?>