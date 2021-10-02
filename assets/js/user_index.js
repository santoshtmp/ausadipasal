
function addUser(){
	var addUser=document.getElementById('addUser');
	addUser.classList.remove('hide');
}

function cancelAddUser(){
	var addUser=document.getElementById('addUser');
	addUser.classList.add('hide');
}

function showPassword() {
	var x = document.getElementById("passInput");
	if (x.type === "password") {
		x.type = "text";
	} else {
		x.type = "password";
	}
}

function changePass(){
	$('#changePassWordMod').modal('toggle');
}
