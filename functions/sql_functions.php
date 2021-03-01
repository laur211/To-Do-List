<?php

function connectDB($host = "localhost",
                    $user = "root",
                    $password = "",
                    $database = "todolist"
                    )
{
    return mysqli_connect($host, $user, $password, $database);
};


function clearData($input, $link)
{
    $input = trim($input);
    $input = htmlspecialchars($input);
    $input = stripslashes($input);
    $input = mysqli_real_escape_string($link, $input);
    return $input;
}

function register($username, $email, $password)
{
    $link = connectDB();
    $username = clearData($username, $link);
    $email = clearData($email, $link);
    $password = clearData($password, $link);
    $password = md5($password);
    $findUser = getUserByEmailOrUsername($email, $username);
//    print "success";
    if ($findUser){
        print "user is in db";
        return false;
    };
    $query = "INSERT INTO users VALUES (NULL, '$username', '$email', '$password', DEFAULT)";
//    var_dump($query);die();
    return mysqli_query($link, $query);
};


function login($username, $pass)
{
    $link = connectDB();
    $username = clearData($username, $link);
    $pass = clearData($pass, $link);
    $findUser = getUserByEmailOrUsername(null, $username);
    if($findUser){
        return md5($pass) == $findUser['password'];
    }else{
        return false;
    }
};

function getUserByEmailOrUsername ($email, $username)
{
    $link = connectDB();
    $username = clearData($username, $link);
    $query = "SELECT * FROM users WHERE username = '$username' OR email = '$email'";
//    var_dump($query);    die();
    $user = mysqli_query($link, $query);
    return mysqli_fetch_array($user, MYSQLI_ASSOC);
}


function changePhoto ($id, $photo)
{
    $link = connectDB();
    $id = clearData($id, $link);
    $photo = clearData($photo, $link);
    $query = "UPDATE users SET photo = '$photo' WHERE id = '$id'";
    return mysqli_query($link, $query);
}

function createTask($title, $date, $type, $description, $user){
    $link = connectDB();
    $title = clearData($title, $link);
    $date = clearData ($date, $link);
    $type = clearData($type, $link);
    $description = clearData($description, $link);
    $user = clearData($user, $link);
    $query = "INSERT INTO tasks VALUES (NULL, '$title', '$date', '$type','$description', '$user')";
    return mysqli_query($link, $query);
}

function showTasks($user){
    $link = connectDB();
    $user = clearData($user, $link);
    $query = "SELECT * FROM tasks WHERE user='$user'";
    $tasks = mysqli_query($link, $query);
    return mysqli_fetch_all($tasks, MYSQLI_ASSOC);
}

function filterTaskByTitle($title, $user){
    $link = connectDB();
    $title = clearData($title, $link);
    $user = clearData($user, $link);
    $query = "SELECT * FROM tasks WHERE user='$user' AND title LIKE '%$title%'";
    $tasks = mysqli_query($link, $query);
    return mysqli_fetch_all($tasks, MYSQLI_ASSOC);
}

function sortTaksByType($type, $user){
    $link = connectDB();
    $type = clearData($type, $link);
    $user = clearData($user, $link);
    $query = "SELECT * FROM tasks WHERE user='$user' AND type='$type'";
    $tasks = mysqli_query($link, $query);
    return mysqli_fetch_all($tasks, MYSQLI_ASSOC);
}