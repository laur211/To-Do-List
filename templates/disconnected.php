<nav>
    <a href="index.php">Login</a>
    <a href = "index.php?page=1">Register</a>
</nav>
<?php
    if (isset($_GET["page"])){
        $page = $_GET["page"];
        if ($page == 1){
            require_once 'pages/disconnected/register.php';
        }else{
            require_once 'pages/error.php';
        }
    }else{
        require_once 'pages/disconnected/login.php';
    }
?>
