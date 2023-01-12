function Login(){

	username=document.getElementById("Login_form")['username'].value;
    password=document.getElementById("Login_form")['password'].value;
	localStorage.setItem("username", username);
	localStorage.setItem("password", password);

	
	const data = formToJSON(document.getElementById("Login_form").elements);	// vsebino obrazca pretvorimo v objekt
	var JSONdata = JSON.stringify(data, null, "  ");						// objekt pretvorimo v znakovni niz v formatu JSON
	
	var xmlhttp = new XMLHttpRequest();										// ustvarimo HTTP zahtevo
	 
	xmlhttp.onreadystatechange = function()									// določimo odziv v primeru različnih razpletov komunikacije
	{
		if (this.readyState == 4 && this.status == 200)						// zahteva je bila uspešno poslana, prišel je odgovor 204
		{
			window.location.assign("home.php")
			//window.location.href="home.php"
			return false;
		}
		if(this.readyState == 4 && this.status != 200)						// zahteva je bila uspešno poslana, prišel je odgovor, ki ni 204
		{
			if (this.status==403){
				document.getElementById("odgovor").innerHTML="Username and password don't match"
			}
			else{
				document.getElementById("odgovor").innerHTML="Login failed, error: "+this.status;
			}
			return true;
		}
	};
	
	xmlhttp.open("POST", "/TF/user.php?intent=login&username="+username, true);							// določimo metodo in URL zahteve, izberemo asinhrono zahtevo (true)
	xmlhttp.send(JSONdata);

}




const formToJSON = elements => [].reduce.call(elements, (data, element) => 
{
	if(element.name!="")
	{
		data[element.name] = element.value;
	}
  return data;
}, {});




function Register()
{
	const data = formToJSON(document.getElementById("Reg_form").elements);	// vsebino obrazca pretvorimo v objekt
	var JSONdata = JSON.stringify(data, null, "  ");						// objekt pretvorimo v znakovni niz v formatu JSON
	
	var xmlhttp = new XMLHttpRequest();										// ustvarimo HTTP zahtevo
	 
	xmlhttp.onreadystatechange = function()									// določimo odziv v primeru različnih razpletov komunikacije
	{
		if (this.readyState == 4 && this.status == 201)						// zahteva je bila uspešno poslana, prišel je odgovor 204
		{
			document.getElementById("odgovor").innerHTML="User created, please login.";
		}
		if(this.readyState == 4 && this.status != 201)						// zahteva je bila uspešno poslana, prišel je odgovor, ki ni 204
		{
			document.getElementById("odgovor").innerHTML="Error: "+this.status;
		}
	};
	
	xmlhttp.open("POST", "/TF/user.php", true);							// določimo metodo in URL zahteve, izberemo asinhrono zahtevo (true)
	xmlhttp.send(JSONdata);
}



