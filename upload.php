<?php
	# On this is script will be needed to check if a student already exists on the DB.

	include 'library/config.php';
	include 'library/opendb.php';
	include 'library/closedb.php';

	# Getting some attributes.
	$matricula = $_POST['matricula'];
	$nome = $_POST['nome'];
	$email = $_POST['email'];

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

	# Checking if a student alredy exists in the DB, if not, add him or her.
	if ($result) {
		$query = "INSERT INTO ALUNOS (matricula, nome, email) VALUES ('$matricula', '$nome', '$email')";
		mysql_query($query);
	}

	# Checking the updated file and inserting it on the DB.
	if (isset($_POST['upload']) && $_FILES['userfile']['size'] > 0) {
		$fileName = $_FILES['userfile']['name'];
		$tmpName  = $_FILES['userfile']['tmp_name'];
		$fileSize = $_FILES['userfile']['size'];
		$fileType = $_FILES['userfile']['type'];

		$fp = fopen($tmpName, 'r');
		$content = fread($fp, filesize($tmpName));
		$content = addslashes($content);
		fclose($fp);

		if (!get_magic_quotes_gpc()) {
    		$fileName = addslashes($fileName);
		}

		$query = "INSERT INTO TRABALHOS (id, trabalho) VALUES ('$matricula', '$content')";

		mysql_query($query) or die('Error, query failed'); 
		

		echo "<br>File $fileName uploaded<br>";
} 
?>