<?php

	# Getting some useful variables passed through "index.html".
	$matricula = $_POST["matricula"];
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$slide = $_POST["slide"];
	$code = $_POST["code"];

	# Used for field validation purposes. 
	# Assumes that all fields aren't empty.
	$granted = 1;

	# If some field is not filled, then deny the submission.
	if (strlen($matricula) == 0 ||
		strlen($nome) == 0 || 
		strlen($email) == 0 ||
		strlen($slide) == 0 || 
		strlen($code) == 0) { 
		$granted = 0; 
	} 

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
	if ($granted == 1 && $result) {
		$query = "INSERT INTO ALUNOS (matricula, nome, email) VALUES ('$matricula', '$nome', '$email')";
		mysql_query($query);
	}

	# Adding student's work on the DB.
    $query = "INSERT INTO TRABALHOS (id, slide, scode, sstatus) VALUES ('$matricula', '$slide', '$code', '')";
	
	if ($granted == 1 && mysql_query($query)) {
		echo "Trabalho enviado com sucesso" . "<br />";
	} else {
		echo "Trabalho não enviado" . "<br />";
	}

?>