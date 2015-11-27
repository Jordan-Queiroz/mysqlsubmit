<?php

	# Getting some useful variables passed through "index.html".
	$matricula = $_POST["matricula"];
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$slide = $_POST["slide"];
	$assunto = $_POST["assunto"];
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
		$query = "INSERT INTO ALUNOS (matricula, nome, email, media) VALUES ('$matricula', '$nome', '$email',0.0)";
		mysql_query($query);
	}

	$dateTime = new DateTime();
	$timestamp = $dateTime->getTimestamp();
	$date = date('Y/m/d', $timestamp);

	# replacing ' by ". Otherwise, it will break down the $query.
	$code = str_replace("'", "\"", $code);

	# Adding student's work on the DB.
  $query = "INSERT INTO TRABALHOS (data, aluno, slide, assunto, codigo, correto) VALUES ('$date', '$matricula', '$slide', '$assunto', '$code', '')";

	if (mysql_query($query)) {
		$redirect = "pages/success.html";
		header("location:$redirect");
	} else {
		# If a student's homework already exists, then update it.
		$queryUpdate = "UPDATE TRABALHOS
					    SET codigo = '$code',
					    data = '$date',
							correto = -2
					    WHERE aluno = '$matricula' AND slide = '$slide' AND assunto = '$assunto'";

		# Checks if the querry worked and if something was updated.
		if(mysql_query($queryUpdate) && mysql_affected_rows() > 0) {
			$redirect = "pages/updated.html";
			header("location:$redirect");
		} else {
			$redirect = "pages/failed.html";
			header("location:$redirect");
		}
	}

?>
