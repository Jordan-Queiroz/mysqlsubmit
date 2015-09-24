var submit = document.getElementById("submit");
submit.onclick = validate();

function validate() {
	
	var matricula = document.getElementById("matricula").value;
	var nome = document.getElementById("nome").value;
	var email = document.getElementById("email").value;
	var slide = document.getElementById("slide").value;
	var code = document.getElementById("code").value;

	if (matricula == "" ||
		nome == "" ||
		email == "" ||
		slide == "" ||
		code == "") {

		window.alert("Não são permitidos campos em branco.");
	} 

}