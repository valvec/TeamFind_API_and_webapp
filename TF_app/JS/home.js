
game_times=0;

function getvariables(){
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");
};

document.addEventListener('click', function(event) {
   
    if (event.target.matches('.button')) {
        var time=event.target.innerHTML;
        if (time.length ==3){
            hour=parseInt(time.slice(0,2));
            console.log(hour)
        }
        if (time.length ==2){
            hour=parseInt(time.slice(0,1));
            console.log(hour)
        }
        var game_hour_coded= Math.round(Math.pow(2,hour));
        game_times = game_times | game_hour_coded;
        console.log(game_times);
        event.target.style.color="blue"
		event.target.style.backgroundColor = "white";
    }
})


const formToJSON = elements => [].reduce.call(elements, (data, element) => 
{
	if(element.name!=""&&element.value!="")
	{
		data[element.name] = element.value;
	}
  return data;
}, {});
game_times

function Update()
{
	const data = formToJSON(document.getElementById("Upd_form").elements);	
    if (game_times){
        data["game_times"] = game_times;
        data["game_days"] = 127;
    }
    
    data["password"] = password;
	var JSONdata = JSON.stringify(data, null, "  ");						
	
	var xmlhttp = new XMLHttpRequest();										
	 
	xmlhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 204)						
		{
			document.getElementById("odgovor").innerHTML="Update sucessful!";
			matchmake();
		}
		if(this.readyState == 4 && this.status != 204)						
		{
			document.getElementById("odgovor").innerHTML="Error: "+this.status;
		}
	};
	
	xmlhttp.open("PUT", "/TF/user.php?username="+username, true);							
	xmlhttp.send(JSONdata);
	
	
}



function matchmake(){
	document.getElementById("user_tiles").innerHTML="";
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			try{
				var odgovorJSON = JSON.parse(this.responseText);
			}
			catch(e){
				console.log("Napaka pri razčlenjevanju podatkov");
				return;
			}
			prikazi(odgovorJSON);
		}
	};
	 
	httpRequest.open("GET", "/TF/user.php?username="+username, true);
	httpRequest.send();
}





function get_langs(){
		
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			try{
				var odgovorJSON = JSON.parse(this.responseText);
			}
			catch(e){
				console.log("Napaka pri razčlenjevanju podatkov");
				return;
			}
			var select = document.getElementById("lang");

			for (var i = 0; i < odgovorJSON.length; i++) {
				// Create a new option element
				var option = document.createElement("option");
		  
				// Set the value and text of the option
				option.value = odgovorJSON[i].lang_eng;
				option.text = odgovorJSON[i].lang_local;
		  
				// Add the option to the select element
				select.add(option);
			  }
		}
	};
	 
	httpRequest.open("GET", "/TF/lang.php", true);
	httpRequest.send();
}










function prikazi(odgovorJSON){
	var fragment = document.createDocumentFragment();		
	
	for (var i=0; i<odgovorJSON.length; i++) {
		var tile = document.createElement("tile");
		
		for(var stolpec in odgovorJSON[i]){
			var p = document.createElement("p");
				
            if (stolpec=="game_times"){
                var game_times=parseInt(odgovorJSON[i][stolpec])
                console.log(game_times)
                game_times_str=""; 
                for (var j=0; j<24; j++){                  
                    

                    if ((game_times & Math.pow(2,j))!=0) {
                        game_times_str+=j+"h ";
                    }
                }
                p.innerHTML=stolpec.replace("_"," ").charAt(0).toUpperCase() + stolpec.replace("_"," ").slice(1) + ': '+game_times_str;
            }
            else if (stolpec=="name") {
                p.innerHTML="Game: " +odgovorJSON[i][stolpec];
            }
            else if (stolpec=="game_id"){}
            else{
                p.innerHTML=stolpec.replace("_"," ").charAt(0).toUpperCase() + stolpec.replace("_"," ").slice(1) + ': '+odgovorJSON[i][stolpec];
            }

            






			tile.appendChild(p);
            tile.className = "tile"
            tile.classList.add("tile");

		}
		fragment.appendChild(tile);					
	}
	document.getElementById("user_tiles").appendChild(fragment);
}