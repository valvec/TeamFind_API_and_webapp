<!DOCTYPE html>
<html>
<head>
    <title>TeamFind</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <script src="JS/home.js"></script>
    
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
    form {
        width: 400px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 auto;
        align-items: center;¸
        text-align:center;
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

.button-container > a {
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




</style>


</head>
<body onload="getvariables();matchmake(); get_langs();return false">
    <?php include "menu.html"?>
    <div style="display: flex; justify-content: space-around; ">
        <div style="width: 40%vw">
            <h3>Edit preferences</h3>
            <form id="Upd_form" onsubmit="Update(); return false;">
                <label>Contact:</label><br>
                <input type="text" name="contact"><br><br>
                <label>Password:</label><br>
                <input type="password" name="new_password"><br><br>
                <label>Language:</label><br>
                <select name="language" id="lang">
                    <option selected value="">Change language</option>
                </select>

                <label>Select times to play:</label><br>
               
                <div class="button-container">
                    <a class="button">1h</a>
                    <a class="button">2h</a>
                    <a class="button">3h</a>
                    <a class="button">4h</a>
                    <a class="button">5h</a>
                    <a class="button">6h</a>
                </div>
                <div class="button-container">
                    <a class="button">7h</a>
                    <a class="button">8h</a>
                    <a class="button">9h</a>
                    <a class="button">10h</a>
                    <a class="button">11h</a>
                    <a class="button">12h</a>
                </div>
                <div class="button-container">
                    <a class="button">13h</a>
                    <a class="button">14h</a>
                    <a class="button">15h</a>
                    <a class="button">16h</a>
                    <a class="button">17h</a>
                    <a class="button">18h</a>
                </div>  
                <div class="button-container">
                    <a class="button">19h</a>
                    <a class="button">20h</a>
                    <a class="button">21h</a>
                    <a class="button">22h</a>
                    <a class="button">23h</a>
                    <a class="button">0h</a>
                </div>                  


                <input type="submit" value="Update">


            </form>
            <div id="odgovor"></div>
        </div>

        <div>
        <h3>These users match your gaming preferences:</h3>
        <div class="tiles" style="width: 50%vw;" id="user_tiles">
        
        </div>
            
        </div>
    </div>

    
</body>
</html>
