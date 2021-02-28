
<?php
    require_once 'functions/sql_functions.php';
    session_start();
    if(isset($_POST["login"])){
        $username = $_POST["username"];
        $password = $_POST["password"];
        $login = login($username, $password);
        if($login){
            $_SESSION["username"] = $username;
        }else {
            print "Error. Please try again";
        }
    }
?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
        <?php
            if(isset($_SESSION["username"])){
                require_once 'templates/connected.php';
            }else{
                require_once 'templates/disconnected.php';
            }
        ?>
    </body>
</html>
