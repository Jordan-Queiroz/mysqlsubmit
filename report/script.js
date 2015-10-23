// Making request to PHP, so that php will calculate all the student's grade.
$.post('report.php', {}, function(data){
	// When php finish to calculate the grade, these lines below will be executed.
	var students = [];

	// Decoding PHP's JSON response.
	var students_array = JSON.parse(data);
	for(var i = 0; i < students_array.length; i++){
		// Getting JSON objects and putting them in an array.
		students.push(JSON.parse(students_array[i]));
	}

	// Sorting array (from highest grade to lowest one)
	students.sort(sortByProperty('grade'));
	
	// Getting table for dinamically insert new rows.
	var grade_table = document.getElementById("grade_table");

	for(var i = 0; i < students.length; i++) {
		// +1 because the table's header is already set, so we don't want to override it.
		var row = grade_table.insertRow(i + 1);
		
		// Inserting cell on the first and second position, respectively, on the new row.
		var number = row.insertCell(0);
		var grade = row.insertCell(1);

		grade.innerHTML = students[i]["grade"];
		number.innerHTML = students[i]["number"];
	}

	function sortByProperty(property) {
    	'use strict';
    	return function (a, b) {
        	var sortStatus = 0;
        	if (a[property] < b[property]) {
            	sortStatus = 1;
        	} else if (a[property] > b[property]) {
            	sortStatus = -1;
        	}
 
        	return sortStatus;
    	};
	}

});