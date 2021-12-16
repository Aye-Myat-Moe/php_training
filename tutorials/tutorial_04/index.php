<?php
session_start();
?>
<html>
    <head>
        <title>User Login</title>
    </head>
    <body>
        <form method="post" action="login.php">
            <h3>Enter Login Details</h3>
            Username:<br>
            <input type="text" name="name">
            <br>
            Password:<br>
            <input type="password" name="password">
            <br><br>
            <input type="submit" name="submit" value="Submit">
            <input type="reset">
        </form>
    </body>
</html>