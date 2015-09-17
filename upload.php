<?php

	# Getting some useful variables passed through "index.html".
	$matricula = $_POST["matricula"];
	$nome = $_POST["nome"];
	$email = $_POST["email"];
	$fileName = $_FILES["fileToUpload"]["name"];

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

	# Checking if a student already exists in the DB, if not, add him or her and creates a folder on the server.
	if ($result) {
		$query = "INSERT INTO ALUNOS (matricula, nome, email) VALUES ('$matricula', '$nome', '$email')";
		mysql_query($query);
		mkdir("uploads/" . $matricula, 0775);
	}

	# Directory where the student's file will be saved.
	$target_dir = "uploads/" . $matricula . "/";

	# Student file's complete path.
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

	# Used just to inform that the upload is all right.
	$uploadOk = 1;

	# Getting student file's extension.
	$fileType = pathinfo($target_file,PATHINFO_EXTENSION);

	# Check if the file is valid
	if(isset($_POST["submit"])) {
    	$check = filesize($_FILES["fileToUpload"]["tmp_name"]);
    	if($check > 0) {
        	echo "Your file is valid - " . $check["mime"] . ".";
        	$uploadOk = 1;
    	} else {
        	echo "Your file is not valid.";
        	$uploadOk = 0;
    	}
	}

	# Check if file already exists
	if (file_exists($target_file)) {
    	echo "Sorry, file already exists.";
    	$uploadOk = 0;
	}

	# Check file size
	/*if ($_FILES["fileToUpload"]["size"] > 500000) {
    	echo "Sorry, your file is too large.";
    	$uploadOk = 0;
	}*/

	# Restricts uploads only for SQL files.
	if ($fileType != "sql") {
    	echo "Sorry, only SQL is allowed.";
    	$uploadOk = 0;
	}

	# Check if $uploadOk is set to 0 by an error
	if ($uploadOk == 0) {
    	echo "Sorry, your file was not uploaded.";

	}
	# if everything is ok, try to upload the student's file.
	else {
		# Try to save the file on the server.
    	if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    		# If the upload is successful, then it will be registered on the DB.
    		$query = "INSERT INTO TRABALHOS (id, nome, tpath) VALUES ('$matricula', '$fileName', '$target_dir')";
			mysql_query($query) or die ('Error, query failed');

        	echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
    	} else {
        	echo "Sorry, there was an error uploading your file.";
    	}
}

?>