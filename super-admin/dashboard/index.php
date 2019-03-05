<?php
require_once("../access.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?php echo ROOT_IMPORT; ?>/node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_IMPORT; ?>/node_modules/bulma/css/bulma.min.css">
    <script src="<?php echo ROOT_IMPORT; ?>/node_modules/jquery/dist/jquery.min.js"></script>
    <title>Palauig Monitoring and Information System for Senior Citizen</title>
</head>
<body>
    <nav class="navbar is-transparent has-background-dark is-fixed-top">
        <div class="navbar-brand ">
            <a class="navbar-item" href="#">
            
            </a>
            <div class="navbar-burger burger" data-target="navbarExampleTransparentExample">
            <span></span>
            <span></span>
            <span></span>
            </div>
        </div>
        
        <div id="navbarExampleTransparentExample" class="navbar-menu">
            <div class="navbar-start">
            <a class="navbar-item  has-text-white " href="<?php echo ROOT_URL.'/dashboard'; ?>">
                Dashboard
            </a>
            
        </div>
        
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                
                <p class="control">
                    <a class="button is-link" href="<?php echo ROOT_URL.'/logout.php'; ?>">
                    <span>Sign-out</span>
                    </a>
                </p>
                </div>
            </div>
        </div>
        </div>
    </nav>

    <br><br><br>
    <div class="container">

    <div class="tile is-ancestor">
        <div class="tile is-vertical is-8">
            <div class="tile">
                <div class="tile is-parent is-vertical">

                    <article class="tile is-child notification is-primary">
                    <p class="title">Currently Logged-in Senior Citizen</p>
                    <!-- <p class="subtitle">Top tile</p> -->
                    </article>

                    <!-- Currently Logged in Administrators -->
                    <article class="tile is-child notification is-warning">
                    <p class="title">Currently Logged-in Administrator</p>
                    <!-- <p class="subtitle">Bottom tile</p> -->
                    </article>
                </div>


                <!-- Admin Log -->
                <div class="tile is-parent">
                    <article class="tile is-child notification is-info">
                    <p class="title">Administrator's Log</p>
                    <!-- <p class="subtitle">With an image</p>
                    <figure class="image is-4by3">
                        <img src="https://bulma.io/images/placeholders/640x480.png">
                    </figure> -->
                    </article>
                </div>
            </div>

            <!-- Notification Area -->
            <div class="tile is-parent">
            <article class="tile is-child notification is-danger">
                <p class="title">Notification Area</p>
                <!-- <p class="subtitle">Aligned with the right tile</p> -->
                <div class="content">
                <!-- Content -->
                </div>
            </article>
            </div>
        </div>

        <!-- List of users -->
        <div class="tile is-parent">
            <article class="tile is-child notification is-success">
            <div class="content">
                <p class="title">List of Administrators</p>
                <!-- <p class="subtitle">With even more content</p> -->
                <div class="content">
                <!-- Content -->
                </div>
            </div>
            </article>
        </div>

        </div>

    </div>
</body>
</html>