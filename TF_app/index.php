<!DOCTYPE html>
<html>
<head>
    <title>TeamFind</title>

    <script src="JS/login_register.js"></script>

    <style>

    body{
        background-color: #7A7A98;
    }
    form {
        width: 200px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        margin: 0 auto;
        align-items: center;
    }
    label {
        display: block;
        margin-bottom: 5px;
    }
    input[type="email"], input[type="password"], input[type="text"] {
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
</style>


</head>
<body>
    <?php include "menu.html"?>
    <div style="display: flex; justify-content: space-around; ">
        <div>
            <h3>Register</h3>
            <form id="Reg_form" onsubmit="Register(); return false;">
                <label>Email:</label><br>
                <input type="email" name="email"><br><br>
                <label>Password:</label><br>
                <input type="password" name="password"><br><br>
                <label>Username:</label><br>
                <input type="text" name="username"><br><br>
                <input type="submit" value="Register">
            </form>
            <div id="odgovor"></div>
        </div>

        <div>
            <h3>Login </h3>
            <form id="Login_form" onsubmit="Login(); return false;">
                <label>Username:</label><br>
                <input type="text" name="username"><br><br>
                <label>Password:</label><br>
                <input type="password" name="password"><br><br>
                <input type="submit" value="Login">
            </form>
            
        </div>
    </div>

    
</body>
</html>
