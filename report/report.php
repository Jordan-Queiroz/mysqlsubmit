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

	# Getting all students in the database.
	$query = "SELECT ALUNOS.matricula FROM ALUNOS";
	$students = mysql_query($query);

	while ($row = mysql_fetch_array($students)) {
		# Useful for getting a specific student's homework.
		$matricula = $row["matricula"];

		# Getting the number of all correct homework of a specific student.
    	$queryCountCorret  = "SELECT COUNT(*)
    						  FROM TRABALHOS 
    						  WHERE TRABALHOS.aluno = $matricula AND TRABALHOS.correto = 1";

    	$countCorrect = mysql_query($queryCountCorret); 
    	
    	# Getting the numeric result.
    	$countCorrect = mysql_result($countCorrect, 0);

    	# Getting the number of all homework of a specific student.
    	$queryCountAll = "SELECT COUNT(*) FROM
    					  TRABALHOS
    					  WHERE TRABALHOS.aluno = $matricula";

    	$countAll = mysql_query($queryCountAll);

    	# Getting the numeric result.
    	$countAll = mysql_result($countAll, 0);

    	# Calculating the grade of a specific student.
    	$grade = ($countCorrect * 10) / $countAll;

    	$queryUpdateGrade = "UPDATE ALUNOS SET media = $grade WHERE matricula = $matricula";
    	
    	if (mysql_query($queryUpdateGrade)) {
    		echo "Success <br />";
    	} else {
    		echo "Error <br />";
    	}

	}

?>