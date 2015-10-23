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

    # Used to store students and their grades.
    $students_array = array();

    # Used to get the max number of exercices.
    $max = getMaxNumberOfExercises();

    # Used to calculate the grade for each student.
    calculateGrade($max);
	

   function getMaxNumberOfExercises() {
        $max = 0;

        # Getting all students in the database.
        $query = "SELECT ALUNOS.matricula FROM ALUNOS";
        $students = mysql_query($query);

        while ($row = mysql_fetch_array($students)) {
            # Useful for getting a specific student's homework.
            $matricula = $row["matricula"];

            # Getting the number of all correct homework of a specific student.
            $queryCountCorret  = "SELECT COUNT(*)
                                  FROM TRABALHOS 
                                  WHERE TRABALHOS.aluno = $matricula";

            $countCorrect = mysql_query($queryCountCorret); 
        
            # Getting the numeric result.
            $countCorrect = mysql_result($countCorrect, 0);

            if ($countCorrect > $max) {
                $max = $countCorrect;
            }
        }
        return $max;
    }

    function calculateGrade($max) {
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


            # Calculating the grade of a specific student.
            $grade = ($countCorrect * 10) / $max;
            
            # Changing precision to x.xx (e.g 5.98)
            $grade = round($grade,2);

            $queryUpdateGrade = "UPDATE ALUNOS SET media = $grade WHERE matricula = $matricula";
            mysql_query($queryUpdateGrade);
            
            $student = array(
                'number'=>$row["matricula"],
                'grade'=> $grade

            );

            $students_array[] = json_encode($student);
        }

        echo json_encode($students_array);
    }


?>