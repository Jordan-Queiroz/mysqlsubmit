var submit = document.getElementById("submit");
submit.onclick = validate;

function validate() {

	var matricula = document.getElementById("matricula").value;
	var nome = document.getElementById("nome").value;
	var email = document.getElementById("email").value;
	var codigo = document.getElementById("codigo").value;
	var slide = document.getElementById("slide").value;

	var fieldsAreFilled = 1;

	if (matricula == null || matricula == "") {
		mandatoryFieldWarning("matricula");
		fieldsAreFilled = 0;
	}

	if (nome == null || nome == "") {
		mandatoryFieldWarning("nome");
		fieldsAreFilled = 0;
	}

	if (email == null || email == "") {
		mandatoryFieldWarning("email");
		fieldsAreFilled = 0;
	}

	if (codigo == null || codigo == "") {
		mandatoryFieldWarning("codigo");
		fieldsAreFilled = 0;
	}

	if (fieldsAreFilled == 1) {
		$.post('upload.php',
			{
			 "matricula":matricula,
			 "nome":nome,
			 "email":email,
			 "slide":slide,
			 "codigo":codigo
			}, function(data){
				if (data == 1) {
					window.location = "pages/success.html";
				} else {
					window.location = "pages/failed.html";
				}
			});
	}
}

function mandatoryFieldWarning(id) {

	document.getElementById(id).style.border = "1px solid red";
	document.getElementById(id + "_warning").innerHTML = "O campo " + id + " é obrigatório";
	document.getElementById(id + "_warning").style.color = "#FF0000";
}