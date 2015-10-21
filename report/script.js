$.post('report.php', {}, function(data){

	var students = [];

	var students_array = JSON.parse(data);
	for(var i = 0; i < students_array.length; i++){
		students.push(JSON.parse(students_array[i]));
	}

	students.sort(sortByProperty('grade'));
	
	console.log(students);

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
	//console.log(students);
});