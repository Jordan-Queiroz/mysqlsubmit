<?php

	# Getting some useful variables passed through "index.html".
	$matricula = $_POST["matricula"];
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$slide = $_POST["slide"];
	$code = $_POST["codigo"];

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

	$query = "SELECT ALUNOS.matricula FROM ALUNOS WHERE ALUNOS.matricula = $matricula";
	$result = mysql_query($query);

	# Checking if a student already exists in the DB, if not, add him.
	if ($result) {
		$query = "INSERT INTO ALUNOS (matricula, nome, email) VALUES ('$matricula', '$nome', '$email')";
		mysql_query($query);
	}

	# Adding student's work on the DB.
    $query = "INSERT INTO TRABALHOS (id, aluno, slide, codigo, correto) VALUES ('', '$matricula', '$slide', '$code', '')";
	
	if (mysql_query($query)) {
		echo 1;
	} else {
		echo 0;
	}

?>