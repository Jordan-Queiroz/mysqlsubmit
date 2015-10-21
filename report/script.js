$.post('report.php', {}, function(data){

	var students = []

	var students_array = JSON.parse(data);
	for(var i = 0; i < students_array.length; i++){
		students.push(JSON.parse(students_array[i]));
	}
	//console.log(students);
});