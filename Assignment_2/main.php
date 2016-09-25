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
                            <input class="mdl-textfield__input" type="text" name="sample" id="fixed-header-drawer-exp">
                        </div>
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
                    <div class='mdl-card mdl-shadow--4dp main-card'>
                        <?php
                        echo "<h3>You are logged in as: ".$_SESSION['user']."</h3>";
                        ?>
                            <a class='login-btn mdl-button mdl-js-button mdl-button--raised mdl-button--colored' id='login-btn' href='?logoff'>Logout</a>

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
