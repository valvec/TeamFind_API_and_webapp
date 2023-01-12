//HMM
const ratingForm = document.getElementById("rating-form")
const ratingInputs = ratingForm.querySelectorAll('input');
for_user=0;

let selectedRating;

ratingInputs.forEach(input => {
  input.addEventListener('change', () => {
    if (input.checked) {
      selectedRating = input.value;
      console.log("selected:" + selectedRating)
    }
  });
});


function getvariables(){
    username = localStorage.getItem("username");
    password = localStorage.getItem("password");
};



function get_games(for_user){
		
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

    var data = {};

    data["password"] = password;
    data["username"] = username;
	var JSONdata = JSON.stringify(data, null, "  ");

	if (for_user){
        httpRequest.open("POST", "/TF/games.php?username="+username, true);
    }
    else{
        httpRequest.open("GET", "/TF/games.php", true);
    }
	httpRequest.send(JSONdata);
}



function prikazi(odgovorJSON){
    document.getElementById("game_tiles").innerHTML="";
	var fragment = document.createDocumentFragment();		
	all_games_data=odgovorJSON
	
	for (var i=0; i<odgovorJSON.length; i++) {
		var tile = document.createElement("tile");
        
		tile.addEventListener('click', function() {
            game_id = this.id;
            console.log(`Tile ${game_id} was clicked`);
            tile_id = this.dataset.number;
            console.log("here")
            console.log(`Tile ${tile_id} was clicked`);
            get_a_game(game_id,tile_id);

        });

		
		for(var stolpec in odgovorJSON[i]){
			var p = document.createElement("p");
				
            
            
            if (stolpec=="name") {
                p.innerHTML="Game: " +odgovorJSON[i][stolpec];
            }
            else if (stolpec=="description" ){}
            else if (stolpec=="ID"){
                tile.id=odgovorJSON[i][stolpec];
                tile.dataset.number=i;
            }
            else{
                p.innerHTML=stolpec.replace("_"," ").charAt(0).toUpperCase() + stolpec.replace("_"," ").slice(1) + ': '+odgovorJSON[i][stolpec];
            }       




			tile.appendChild(p);
            tile.className = "tile"
            tile.classList.add("tile");

		}
		fragment.appendChild(tile);					
	}
	document.getElementById("game_tiles").appendChild(fragment);	
}




function get_a_game(game_id,tile_id){
	
	var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 200)
		{
			try{
                console.log(this.responseText);
				var odgovorJSON = JSON.parse(this.responseText);
			}
			catch(e){
				console.log("Ni podatkov za uporabnika");
				var odgovorJSON=null;
			}
			prikazi_podrobnosti(odgovorJSON,tile_id);
		}
	};
    
    httpRequest.open("GET", "/TF/games.php?intent=get_game_relation&username="+username + "&game_id="+game_id, true);
    

	httpRequest.send();
}


function prikazi_podrobnosti(odgovorJSON,tile_id){
	selectedRating = null;
    document.getElementById("Server_response").innerHTML=" "
	document.getElementById("game_det").style.display="block"
    document.getElementById("title").innerHTML=all_games_data[tile_id]["name"];
    document.getElementById("description").innerHTML=all_games_data[tile_id]["description"]
    document.getElementById("average_rating").innerHTML="Average rating: " + all_games_data[tile_id]["average_rating"]
    if (odgovorJSON !== null){
    document.getElementById("myrating").innerHTML="My rating: " +odgovorJSON["rating"]
    subscribed=parseInt(odgovorJSON["subscribed"])
    }else{
        subscribed=0
    }

    ratingInputs.forEach(input => {
        if (input.value==Math.round(all_games_data[tile_id]["average_rating"])){
            console.log("v");
            input.checked=true;
        }
      });
    if (!subscribed){
        document.getElementById("subscribe_button").innerHTML="SUBSCRIBE"
    }
    else{
        document.getElementById("subscribe_button").innerHTML="UNSUBSCRIBE"
    }
	
}

function subscribe (){
    subscribed= !subscribed;
    var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 204)
		{
            if (!subscribed){
                document.getElementById("subscribe_button").innerHTML="SUBSCRIBE"
            }
            else{
                document.getElementById("subscribe_button").innerHTML="UNSUBSCRIBE"
            }
            get_games(for_user);
		}
	};
    
    httpRequest.open("PUT", "/TF/games.php?intent=subscribe&username="+username, true);
    
    var data = {};

    data["password"] = password;
    data["game_id"] = game_id;
    data["subscribed"] = subscribed;

	var JSONdata = JSON.stringify(data, null, "  ");


	httpRequest.send(JSONdata);


}

function toggle() {
    const toggleButton = document.getElementById("toggleButton");
    if (toggleButton.checked) {
        for_user=1;
    } else {
        for_user=0;
    }
    get_games(for_user);
  }




function rate (){
    if (selectedRating==null){
        document.getElementById("Server_response").innerHTML="Please select rating first"
        return
    }

    var httpRequest = new XMLHttpRequest();
	httpRequest.onreadystatechange = function()
	{
		if (this.readyState == 4 && this.status == 204)
		{
            get_games(for_user);
            get_a_game(game_id,tile_id)
		}
	};
    
    httpRequest.open("PUT", "/TF/games.php?intent=rate&username="+username, true);
    
    var data = {};

    data["password"] = password;
    data["game_id"] = game_id;
    data["subscribed"] = subscribed;
    data["rating"] = selectedRating;
    

	var JSONdata = JSON.stringify(data, null, "  ");
    

	httpRequest.send(JSONdata);


}