<?php
    session_start();
    if (!isset($_SESSION["user"])){
        echo "<script>window.location = 'https://justinrhude.com'</script>";
    }
?>

    <!doctype html>
    <html lang="en">

    <head>
        <meta charset="utf-8">
        <meta http-equiv="expires" content="0">
        <title>Portfolio of Justin Rhude</title>
        <meta name="description" content="The portfolio of Justin Rhude.">
        <link rel="stylesheet" href="./mdl/material.min.css">
        <script src="./mdl/material.min.js"></script>
        <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div class="mdl-layout mdl-js-layout mdl-layout--fixed-drawer
            mdl-layout--fixed-header">
            <header class="mdl-layout__header">
                <div class="mdl-layout__header-row">
                    <div class="mdl-layout-spacer"></div>
                    <label>Welcome <?php echo $_SESSION['user'] ?>!</label>
                    <a class='logout-btn mdl-button mdl-js-button mdl-button--primary ' href='?logoff'>Logout</a>
                </div>
            </header>
            <div class="mdl-layout__drawer"> <span class="mdl-layout-title">Justin Rhude</span>
                <nav class="mdl-navigation">
                    <a class="mdl-navigation__link" href="">Link1</a>
                    <a class="mdl-navigation__link" href="">Link2</a>
                    <a class="mdl-navigation__link" href="">Link3</a>
                    <a class="mdl-navigation__link" href="">Link4</a>
                </nav>
            </div>
            <main class="mdl-layout__content">
                <div class="page-content">
                    <div class='mdl-card mdl-shadow--4dp main-card'>
                        <?php
                        echo "<h3>You are logged in as: ".$_SESSION['user']."</h3>";
                        ?>
                    </div>
                    <?php if ($_SESSION['access_level'] == 0){
                    echo "<div class='mdl-card mdl-shadow--4dp main-card'>";
                    echo "<h4>Change a user's permissions:</h4>";

                            $servername = "db.justinrhude.com";
                            $db_username = "jr_db_access";
                            $db_password = "helloworld3";
                            $db_name = "jr_logins";

                            try {
                               $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                               if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'])) {
                                   $sql = $conn->prepare("UPDATE users SET privilages=".$_POST['acl_'.$_POST["username"].'']." WHERE username='".$_POST["username"]."'");
                                   $sql->execute();
                               }

                                $sql = $conn->prepare("SELECT username, privilages FROM users");
                                $sql->execute();
                                $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($result as $row => $list_item){
                                    echo '<form action="'.htmlspecialchars($_SERVER["PHP_SELF"]).'" method="POST">';
                                    echo '<label>Username: '.$list_item["username"].'</label>';
                                    if ($list_item['privilages'] == 0){
                                        echo '<div class="float-right">
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="0" checked disabled/>Admin
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="1" disabled/>Moderator
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="2" disabled/>User';
                                    }
                                    elseif ($list_item['privilages'] == 1){
                                        echo '<div class="float-right">
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="0" disabled/>Admin
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="1" checked/>Moderator
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="2" />User';
                                    }
                                    else {
                                        echo '<div class="float-right">
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="0" disabled/>Admin
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="1" />Moderator
                                        <input type="radio" name="acl_'.$list_item['username'].'" value="2" checked/>User';
                                    }
                                    echo '<button type="submit" class="mdl-button mdl-js-button mdl-button--colored logout-btn">Update</button></div>';
                                    echo '<input type="text" name="username" value="'.$list_item['username'].'" hidden/></form>';
                                }
                           }
                           catch(PDOException $e) {
                               echo "Something went wrong...";
                           }
                            $conn = null;

                    echo '</div>';



                    echo "<div class='mdl-card mdl-shadow--4dp main-card'>";
                    echo "<h4>Suspicious login attempts:</h4>";

                            try {
                               $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                               $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

                                $sql = $conn->prepare("SELECT username, time_stamp, flagged FROM login_attempts");
                                $sql->execute();
                                $result = $sql->fetchAll(PDO::FETCH_ASSOC);

                                echo "<table cellpadding=5 cellspacing=5 >
                                        <tr>
                                        <th style='text-align: left'>Username</th>
                                        <th style='text-align: right'>Flagged</th>
                                        </tr>";

                                $count = 0;
                                $current_user;
                                foreach ($result as $row => $list_item){
                                    if ($list_item['flagged'] == 1) {
                                        echo "<tr><td>".$list_item['username']."</td> <td style='text-align: right'>special characters</td></tr>";
                                    }
                                    if ($current_user == null || $current_user != $list_item['username']){
                                        $current_user = $list_item['username'];
                                        $count = 0;
                                    }
                                    else {
                                        $count++;
                                    }
                                    if ($count >= 5){
                                        echo "<tr><td>".$list_item['username']."</td> <td style='text-align: right'> tried logging in ".$count." times</td></tr>";
                                    }

                                }
                                echo "</table>";
                           }
                           catch(PDOException $e) {
                               echo "Something went wrong...";
                           }
                            $conn = null;

                    echo '</div>';





                    }?>





                    <div class='mdl-card mdl-shadow--4dp main-card'>
                        <h4>Add a comment:</h4>
                        <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                            <input type="text" name='comment_input' placeholder="Comment" />
                            <button class='mdl-button mdl-js-button mdl-button--colored' type="submit">Submit</button>
                        </form>
                        <?php
                        $servername = "db.justinrhude.com";
                        $db_username = "jr_db_access";
                        $db_password = "helloworld3";
                        $db_name = "jr_logins";

                        try {
                           $conn = new PDO("mysql:host=$servername;dbname=$db_name", $db_username, $db_password);
                           $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                           if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_input'])){
                               $sql = $conn->prepare("INSERT INTO Comments (username, post_time, comment)
                                                        VALUES ('".$_SESSION['user']."', '".date('Y/m/d H:i:s')."', '".$_POST['comment_input']."')");
                               $sql->execute();
                           }
                           if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment_id'])){
                               $sql = $conn->prepare("DELETE FROM Comments WHERE comment_id='".$_POST['comment_id']."'");
                               $sql->execute();
                           }

                            $sql = $conn->prepare("SELECT comment, username, post_time, comment_id FROM Comments ORDER BY post_time DESC");
                            $sql->execute();
                            $result = $sql->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($result as $row => $list_item){
                                echo $list_item["username"].": ".$list_item['post_time']."-> ".$list_item['comment']."<br/>";
                                if ($_SESSION['access_level'] <= 1){
                                    echo "  <form method='POST' action='".htmlspecialchars($_SERVER['PHP_SELF'])."'>
                                                <input type='text' name='comment_id' value='".$list_item['comment_id']."' hidden/>
                                                <button class='mdl-button mdl-js-button mdl-button--colored' type='submit'>Remove</button>
                                            </form>";
                                }
                            }
                        }
                        catch(PDOException $e) {
                            echo "Something went wrong...".$e;
                        }
                         $conn = null;
                         ?>
                    </div>


                    <?php
                    if (isset($_GET['logoff'])){
                        session_unset();
                        session_destroy();
                        echo "<script>window.location = ' https://justinrhude.com '</script>";
                    }
                    ?>
                </div>
            </main>
        </div>
    </body>

    </html>
