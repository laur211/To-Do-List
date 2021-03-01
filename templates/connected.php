<nav>
    <a href="index.php">Tasks</a>
    <a href="index.php?page=1">Profile</a>
    <a href="index.php?page=disconnect">Disconnect</a>
</nav>


<?php
    if(isset($_GET["page"])){
        $page = $_GET["page"];
        switch ($page){
        case 1 :
            require_once 'pages/connected/profile.php';
            break;
        case "disconnect":
            session_destroy();
            header("location: index.php");
        default:
            require_once 'pages/error.php';
        }
    }else{
        require_once 'pages/connected/tasks.php';
    }
?>