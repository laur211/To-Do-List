<h2>Filter the list</h2>
<?php
    $user = getUserByEmailOrUsername(null, $_SESSION["username"]);
?>
<form>
    Search task: <input type="text" id="title" name="title">
    <br>
    <input type="radio" id="task" name="type" value="task">
  <label for="task">Task</label><br>
  <input type="radio" id="event" name="type" value="event">
  <label for="event">Event</label><br>
  <input type="radio" id="type" name="type" value="reminder">
  <label for="reminder">Reminder</label>
  <br>
  <button id="search" name="search" value="search">Search</button>
  <button id="reset" name="reset" value="reset">Reset</button>
</form>
<?php
    if (isset($_GET["search"])){
        $title = isset($_GET["title"])? $_GET["title"]: null;
        $type = isset($_GET["type"])? $_GET["type"]: null;
        $tasks = filterTasks($title, $type, $user["id"]);
        setcookie('title',$title, time()+24*60*60);
        setcookie("type", $type, time()+24*60*60);
    }elseif (isset($_COOKIE["title"]) or isset ($_COOKIE["type"])){
            $title = isset($_COOKIE["title"])? $_COOKIE["title"]: null;
            $type = isset($_COOKIE["type"])? $_COOKIE["type"]:null;
        $tasks = filterTasks($title, $type, $user["id"]);
    }else{
    $tasks = showTasks($user["id"]);
    };
    
    if (isset($_GET["reset"])){
        setcookie("title", "", time()-1);
        setcookie("type","", time()-1);
        header("location:index.php");
    };
?>
<h2>Task list</h2>
<?php
    foreach ($tasks as $task){
        print "<p>".$task["title"]."</p>";
        print "<p>".$task["date"]."</p>";
        print "<p>".$task["type"]."</p>";
        print "<p>".$task["description"]."</p><br>";
    }
?>
<br>
<h2>Add a task</h2>
<form method="POST">
    <table>
        <tr>
            <td>
                <label for="title">Title: </label>
                <input type="title" id="title" name="title">
            </td>
        </tr>
        <tr>
            <td>
                <label for="date">Date: </label>
                <input type="date" id="date" name="date">
            </td>
        </tr>
        <tr>
            <td>
                <label for="type">Type: </label>
                <select id="type" name="type">
                    <option id="task" value="task">Task</option>
                    <option id="event" value="event">Event</option>
                    <option id="reminder" value="reminder">Reminder</option>
                </select>
            </td>
        </tr>
        <tr>
            <td>
                <label for="description">Description: </label>
                <textarea id="description" name="description"></textarea>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" id="submit" name="submit" value="submit">Submit your task</button>
            </td>
        </tr>
    </table>
</form>
<?php
    if(isset($_POST["submit"])){
        $title = $_POST["title"];
        $date = $_POST["date"];
        $type = $_POST["type"];
        $description = $_POST["description"];
        $createTask = createTask($title, $date, $type, $description, $user["id"]);
        if ($createTask){
        header("location:index.php");
        }else{
            print "Error for add task";
        };
    };
?>
