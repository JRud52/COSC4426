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
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <div class="mdl-layout-spacer"></div>
                    <div class="mdl-textfield mdl-js-textfield mdl-textfield--expandable
                  mdl-textfield--floating-label mdl-textfield--align-right">
                        <label class="mdl-button mdl-js-button mdl-button--icon" for="fixed-header-drawer-exp">
                            <i class="material-icons">search</i>
                        </label>
                        <div class="mdl-textfield__expandable-holder">
                            <input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp"> </div>
                    </div>
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
                        <div class='mdl-card__actions'> </div>
                        <form action='<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>' method='POST'>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="mdl-textfield__input" type="text" name="email-input">
                                <label class="mdl-textfield__label" for="email-input">Email:</label>
                                <span class="mdl-textfield__error">This is required.</span>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="pass-input mdl-textfield__input" type="text" name="user-input">
                                <label class="mdl-textfield__label" for="user-input">Username:</label>
                                <span class="mdl-textfield__error">This is required.</span>
                            </div>
                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="pass-input mdl-textfield__input" type="password" name="pass-input">
                                <label class="mdl-textfield__label" for="pass-input">Password:</label>
                                <span class="mdl-textfield__error">This is required.</span>
                            </div>

                            <select name="security-question" required>
                                <option value='1' selected>Mother's maiden name?</option>
                                <option value='2'>Father's middle name?</option>
                                <option value='3'>Favourite colour?</option>
                                <option value='4'>Favourite movie?</option>
                            </select>

                            <div class="mdl-textfield mdl-js-textfield mdl-textfield--floating-label">
                                <input class="pass-input mdl-textfield__input" type="text" name="answer-input">
                                <label class="mdl-textfield__label" for="answer-input">Answer:</label>
                                <span class="mdl-textfield__error">This is required.</span>
                            </div>
                            <button class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' type="submit">Register</button>
                        </form>
                    </div>
                    <?php 
                $sq = $email = $username = $password = $answer = "" ; 
                if ($_SERVER[ "REQUEST_METHOD"]=="POST" ) { 
                    $continue=true; 
                    if (empty($_POST[ "email-input"])) { 
                        $continue=false; 
                    } 
                    else { 
                        $email=fix_input($_POST[ "email-input"]); 
                    }
                    if (empty($_POST[ "user-input"])) { 
                        $continue=false; 
                    } 
                    else { 
                        $username=fix_input($_POST[ "user-input"]); 
                    } 
                    if (empty($_POST[ "pass-input"])) { 
                        $continue=false; 
                    } 
                    else { 
                        $password=fix_input($_POST[ "pass-input"]); 
                    } 
                    if (empty($_POST[ "security-question"])) { 
                        $continue=false; 
                    } 
                    else { 
                        $sq=fix_input($_POST[ "security-question"]); 
                    }
                    if (empty($_POST[ "answer-input"])) { 
                        $continue=false; 
                    } 
                    else { 
                        $answer=fix_input($_POST[ "answer-input"]); 
                    }
                    
                    if ($continue==true) { 
                        connect_db($email, $username, $password, $sq, $answer); 
                    }
                    else {
                        echo "Please fill in all the fields.";
                    }
                    
                } 
                function fix_input($data) {
                    $data=trim($data); 
                    $data=stripslashes($data); 
                    $data=htmlspecialchars($data); 
                    return $data; 
                } 
                function connect_db($email, $user, $pass, $sq, $ans) { 
                    $servername="db.justinrhude.com";
                    $db_username="jr_db_access";
                    $db_password="helloworld3";
                    $db_name="jr_logins";
                    $pass_hash= password_hash($pass, PASSWORD_DEFAULT);
                    $ans_hash= password_hash($ans, PASSWORD_DEFAULT);
                    
                    try { 
                        $conn=new PDO( "mysql:host=$servername;dbname=$db_name", $db_username, $db_password); 
                        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
                        $sql = "INSERT INTO users (email, username, password, question, answer, privilages) VALUES ('$email', '$user', '$pass_hash', '$sq', '$ans_hash', '1')"; 
                        // use exec() because no results are returned 
                        $conn->exec($sql); 
                        $_SESSION["user"] = $user;
                        echo "<script>window.location = 'https://justinrhude.com/main.php'</script>"; 
                    } 
                    catch(PDOException $e) { 
                        echo "That username is already taken..."; 
                    } 
                    $conn = null; 
                } 
                ?>
                </div>
            </main>
        </div>
    </body>

    </html>
