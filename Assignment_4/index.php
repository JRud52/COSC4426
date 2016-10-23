<?php
    session_start();
    if (isset($_SESSION["user"])){
        echo "<script>window.location = 'https://justinrhude.com/main.php'</script>";
    }
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="expires" content="0">
        <title>Portfolio of Justin Rhude</title>
        <meta name="description" content="The portfolio of Justin Rhude.">
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="./mdl/material.min.css">
        <script src="./mdl/material.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
    </head>

    <body>
        <div class="mdl-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <span class="mdl-layout-title">Portfolio of Justin Rhude</span>
                </div>
            </header>

            <main class="mdl-layout__content">
                <div class="page-content">
                    <div class='mdl-card mdl-shadow--4dp login-form'>

                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" name="user-input">
                                <label class="mdl-textfield__label" for="user-input">Username:</label>
                                <span class="mdl-textfield__error">Input is not a number!</span>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="pass-input mdl-textfield__input" type="password" name="pass-input">
                                <label class="mdl-textfield__label" for="pass-input">Password:</label>
                                <span class="mdl-textfield__error">Input is not a number!</span>
                            </div>
                            <button class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' id='login-btn' type='submit' id='login-btn'>Login</button>
                            <a class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' id='reg-btn' href="register.php">Register</a>
                            <div class='mdl-button mdl-js-button mdl-button--raised mdl-button--colored ' id='forgot-btn'>
                                <a href="forgot.php">Forgot Password</a>
                            </div>

                        </form>
                    </div>

                    <?php

                $username = $password = "";
                if ($_SERVER["REQUEST_METHOD"] == "POST") {

                    $flagged = 0;
                    $continue = true;

                    if (empty($_POST["user-input"])) {
                        $continue = false;
                    }
                    else {
                        $username = fix_input($_POST["user-input"]);
                        if ($username != $_POST["user-input"]){
                            $flagged = 1;
                        }
                    }
                    if (empty($_POST["pass-input"])) {
                        $continue = false;
                    }
                    else {
                        $password = fix_input($_POST["pass-input"]);
                        if ($password != $_POST["pass-input"]){
                            $flagged = 1;
                        }
                    }

                    if ($continue == true) {
                        connect_db($username, $password, $flagged);
                    }
                }

                function fix_input($data) {
                    $data = trim($data);
                    $data = stripslashes($data);
                    $data = htmlspecialchars($data);
                    return $data;
                }

                function connect_db($user, $pass, $flag) {
                    $servername = "db.justinrhude.com";
                    $db_username = "jr_db_access";
                    $db_password = "helloworld3";
                    $db_name = "jr_logins";

                    try {
                       $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                       $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                       $sql = $conn->prepare("INSERT INTO login_attempts (username, time_stamp, flagged) VALUES ('".$user."', '".date('Y/m/d H:i:s')."', ".$flag.")");
                       $sql->execute();

                        $sql = $conn->prepare("SELECT username, password, privilages FROM users WHERE username='$user'");
                        $sql->execute();
                        $result = $sql->fetch(PDO::FETCH_ASSOC);
                        if ($result['username'] && password_verify($pass, $result["password"])){
                            $_SESSION["user"] = $user;
                            $_SESSION["access_level"] = $result['privilages'];
                            echo "<script>window.location = 'https://justinrhude.com/main.php'</script>";
                        }
                        else {
                            echo "That is not a valid login.";
                        }
                   }
                   catch(PDOException $e) {
                       echo "That is not valid.";
                   }
                    $conn = null;
                }



                ?>
                </div>
            </main>
        </div>
    </body>

    </html>
