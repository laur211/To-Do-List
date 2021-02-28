<h1>Register</h1>
<form method="POST">
    <table>
        <tr>
            <td>
                <label for="username">Username:</label>
                <input type="text" id="username" name="username">
            </td>
        </tr>
        <tr>
            <td>
                <label for="email">Email:</label>
                <input type="email" id="email" name="email">
            </td>
        </tr>
        <tr>
            <td>
                <label for="password">Password:</label>
                <input type="password" id="password" name="password">
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <button type="submit" name="register" value="register">Submit</button>
            </td>
        </tr>
    </table>
</form>

<?PHP
    if(isset($_POST["register"])){
        $username = $_POST["username"];
        $email = $_POST["email"];
        $password = $_POST["password"];
        $register = register($username, $email, $password);
        if($register){
            print "User has been registered with success";
            $_SESSION["username"] = $username;
            header("location: index.php");
        }else {
            print "Error. Please try again";
        }
    }
?>