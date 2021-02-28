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

function createTask($user, title, date, type,)