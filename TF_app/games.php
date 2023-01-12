<!DOCTYPE html>
<html>
<head>
    <title>TeamFind</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    
    
    <style>

    html {
        -webkit-box-sizing: border-box;
                box-sizing: border-box;
    }

    *,
    *:before,
    *:after { /* Inherit box-sizing to make it easier to change the property for components that leverage other behavior; see http://css-tricks.com/inheriting-box-sizing-probably-slightly-better-best-practice/ */
        -webkit-box-sizing: inherit;
                box-sizing: inherit;
    }
        html,body {

        height: 100%;
        width: 100%;

        }

    body{
        background-color: #7A7A98;
    }


    .rating {
    display: flex;
    flex-direction: row-reverse;
  }
  .rating > input {
    display: none;
  }
  .rating > label {
    position: relative;
    width: 1.25em;
    font-size: 3em;
    color: transparent;
    cursor: pointer;
  }
  .rating > label:before {
    content: "★";
    color: #ddd;
  }
  .rating > label:hover:before,
  .rating > label:hover ~ label:before,
  .rating > input:checked ~ label:before {
    content: "★";
    color: orange;
  }









    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="password"], input[type="text"] {
        width: 100%;
        padding: 5px;
        border: 1px solid #ccc;
        
        border-radius: 30px;
    }
    input[type="submit"] {
        width: 100%;
        padding: 5px;
        background-color: #4CAF50;
        color: white;
        border: none;
       
        cursor: pointer;
        border-radius: 30px;
    }

.button-container {
    width: 60px;
    margin:10px;
    display: inline-block;
    
}

button{
    width: 100%; /* set the width to 100% to fill the container */
    padding: 5px;
    margin: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 30px;
    text-align:center;
    display: block; /* set the display property to block */
}

.tiles {
    display: flex;
    flex-wrap: wrap;
  }
  .tile {
    
    padding: 30px;
    margin: 10px;
    background-color: #4CAF50;
    color: white;
    border: none;
    cursor: pointer;
    border-radius: 30px;
  }
  .tile p {
    margin: 0;
  }
  input[type="checkbox"] {
  display: none;
}

input[type="checkbox"] + label {
  background-color: #dddddd;
  border-radius: 100px;
  cursor: pointer;
  height: 20px;
  width: 40px;
}

input[type="checkbox"]:checked + label {
  background-color: #0080ff;
}

input[type="checkbox"] + label:before {
  content: "OO";
  font-size: 15px;
  color: #ffffff;
  background-color: #ffffff;
  border-radius: 10px;
  height: 20px;
  width: 20px;
  margin-top: -8px;
  transition: all 0.2s ease;
}

input[type="checkbox"]:checked + label:before {
  margin-left: 20px;
}




</style>


</head>
<body onload="getvariables();get_games(0);return false">
    <?php include "menu.html"?>
    <div style="display: flex; justify-content: space-around; ">
        <div  style="width: 20%; margin-right: 15%; margin-left: 5%;"> 
            <div   id="game_det" style= "display: none;">         
                    <div>
                        <h1 id="title" style="margin-top: 16px; font-size: 24px; font-weight: bold;">NAME</h1>
                        <p id="description" style="margin-top: 16px; font-size: 12px; font-weight: bold;">description</p>
                    </div>
                    <div>
                        <form class="rating" id="rating-form" style="width: 100%;justify-content: space-around; ">
                            <input class="star" type="radio" id="star5" name="rating" value="5" />
                            <label for="star5"></label>
                            <input class="star" type="radio" id="star4" name="rating" value="4" />
                            <label for="star4"></label>
                            <input class="star" type="radio" id="star3" name="rating" value="3" />
                            <label for="star3"></label>
                            <input class="star" type="radio" id="star2" name="rating" value="2" />
                            <label for="star2"></label>
                            <input class="star" type="radio" id="star1" name="rating" value="1" />
                            <label for="star1"></label>
                        </form>
                        <p id="average_rating">avg_r</p>
                        <p id="myrating">not yet rated</p>                        
                    </div>
                    <div>
                        <button id="submit_button"onclick="rate();return false;">SUBMIT RATING</button>
                        <button id="subscribe_button" onclick="subscribe();return false;">SUBSCRIBE</button>
                        <p id="Server_response"> </p>
                    </div>            
                <div id="odgovor"></div>
            </div>
        </div>


        <div style="width: 60%;">
        <h3>Games:</h3>
        <p>Show my games? </p>
        <input type="checkbox" id="toggleButton" onclick="toggle()">
        <label for="toggleButton"></label>

            <div class="tiles"  id="game_tiles">
            
            </div>
            
        </div>
    </div>

    <script src="JS/games.js"></script>
</body>
</html>
