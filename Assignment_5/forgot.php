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
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <!-- Title -->
                    <span class="mdl-layout-title">Portfolio of Justin Rhude</span>
                </div>
            </header>
            <div class="mdl-layout__drawer"> <span class="mdl-layout-title">Justin Rhude</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="">Link</a>
                    <a class="mdl-navigation__link" href="">Link</a>
                    <a class="mdl-navigation__link" href="">Link</a>
                    <a class="mdl-navigation__link" href="">Link</a>
                </nav>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div class='mdl-card mdl-shadow--4dp login-form'>


                        <?php if (!isset($_POST["username"])) : ?>
                            <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                                <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                    <input class="mdl-textfield__input" type="text" name="username">
                                    <label class="mdl-textfield__label" for="username">Username:</label>
                                    <span class="mdl-textfield__error">Input is not a number!</span>
                                </div>
                                <button class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' type='submit' id='login-btn'>Change Password</button>
                            </form>
                        <?php else : ?>
                                <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="mdl-textfield__input user-input username_place" type="hidden" name="user-input" value="<?php $_POST[' username '] ?>">
                                        <label class="mdl-textfield__label" for="user-input">Username:</label>
                                        <span class="mdl-textfield__error">Input is not a number!</span>
                                    </div>
                                    <p class="security_text">question</p>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class=" mdl-textfield__input" type="password" name="ans-input">
                                        <label class="mdl-textfield__label" for="ans-input">Answer:</label>
                                        <span class="mdl-textfield__error">Input is not a number!</span>
                                    </div>
                                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                        <input class="pass-input mdl-textfield__input" type="password" name="pass-input">
                                        <label class="mdl-textfield__label" for="pass-input">New password:</label>
                                        <span class="mdl-textfield__error">Input is not a number!</span>
                                    </div>
                                    <button class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' type='submit' id='login-btn'>Change Password</button>
                                </form>
                            <?php endif; ?>

                    </div>

                    <?php

                    if (isset($_GET['no_user'])) {
                        echo "Something was not entered correctly...";
                    }



                    $ans = $username = $password = "";
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (isset($_POST["username"])){
                            if (empty($_POST["username"])) {
                                echo "<script>window.location = 'https://justinrhude.com/forgot.php?no_user'</script>";
                            }
                            else {
                                $username = fix_input($_POST["username"]);
                                echo "<script>document.querySelector('.username_place').value = '$username';</script>";
                                $servername = "db.justinrhude.com";
                                $db_username = "jr_db_access";
                                $db_password = "helloworld3";
                                $db_name = "jr_logins";

                                try {
                                   $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                                   $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                                    $sql = $conn->prepare("SELECT question FROM users WHERE username='$username'");
                                    $sql->execute();
                                    $result = $sql->fetch(PDO::FETCH_ASSOC);
                                    if ($result['question']){
                                        switch ($result['question']){
                                            case 1:
                                                echo "<script>document.querySelector('.security_text').innerHTML = 'Mother's maiden name?';</script>";
                                                break;
                                            case 2:
                                                echo "<script>document.querySelector('.security_text').innerHTML = 'Father's middle name?';</script>";
                                                break;
                                            case 3:
                                                echo "<script>document.querySelector('.security_text').innerHTML = 'Favourite colour?';</script>";
                                                break;
                                            case 4:
                                                echo "<script>document.querySelector('.security_text').innerHTML = 'Favourite Movie?';</script>";
                                                break;
                                        }
                                    }
                                    else {
                                        echo "<script>window.location = 'https://justinrhude.com/forgot.php?no_user'</script>";
                                    }
                               }
                               catch(PDOException $e) {
                                   echo "Connection failed: " . $e->getMessage();
                               }
                                $conn = null;
                            }
                        }
                        else {
                            $continue = true;
                            $username = $_POST['user-input'];

                            if (empty($_POST["ans-input"])) {
                                $continue = false;
                                echo "<script>window.location = 'https://justinrhude.com/forgot.php?no_user'</script>";
                            }
                            else {
                                $ans = fix_input($_POST["ans-input"]);
                            }
                            if (empty($_POST["pass-input"])) {
                                $continue = false;
                                echo "<script>window.location = 'https://justinrhude.com/forgot.php?no_user'</script>";
                            }
                            else {
                                $password = fix_input($_POST["pass-input"]);
                            }

                            if ($continue == true) {
                                connect_db($username, $ans, $password);
                            }
                        }




                    }

                    function fix_input($data) {
                        $data = trim($data);
                        $data = stripslashes($data);
                        $data = htmlspecialchars($data);
                        return $data;
                    }

                    function connect_db($user, $ans, $pass) {
                        $servername = "db.justinrhude.com";
                        $db_username = "jr_db_access";
                        $db_password = "helloworld3";
                        $db_name = "jr_logins";
                        $pass_hash= password_hash($pass, PASSWORD_DEFAULT);

                        try {
                           $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                            $sql = $conn->prepare("SELECT username, password, answer FROM users WHERE username='$user'");
                            $sql->execute();
                            $result = $sql->fetch(PDO::FETCH_ASSOC);
                            if ($result['username'] && password_verify($ans, $result["answer"])){
                                $sql = $conn->prepare("UPDATE users SET password='$pass_hash' WHERE users.username='$user'");
                                $sql->execute();
                                $_SESSION["user"] = $user;
                                echo "<script>window.location = 'https://justinrhude.com/main.php'</script>";
                            }
                            else {
                                echo "That is not the right answer.";
                            }
                       }
                       catch(PDOException $e) {
                           echo "Connection failed: " . $e->getMessage();
                       }
                        $conn = null;
                    }



                    ?>
                </div>
            </main>
        </div>
    </body>

    </html>
