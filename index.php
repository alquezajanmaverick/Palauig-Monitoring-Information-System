<?php
    session_start();
    session_destroy();
    require_once("connector.php");
    if(isset($_POST['username'])){
        $db = new DatabaseConnect();
        $db->query("SELECT m.* FROM tblmembercredentials as c LEFT JOIN tblmember as m ON m.ID = c.ID WHERE c.userID = BINARY(?) AND c.password = BINARY(?)");
        $db->bind(1,$_POST['username']);
        $db->bind(2,$_POST['password']);
        $x = $db->single();
        $r = $db->rowCount();
        
        if($r>0){
            session_start();
            $_SESSION['ID'] = $x['ID'];
            $_SESSION['name'] = $x['fname'].' '.$x['lname'];
            header('Location:member-page.php');
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="styles.css">
    <script src="node_modules/jquery/dist/jquery.min.js"></script>
    <script src="scripts/login.js"></script>
    <title>Palauig Monitoring and Information System for Senior Citizen</title>
</head>
<body class="has-background-dark" style="height:100vh">
    <br>
    <section>
        <div class="columns">
            <div class="column is-10 is-offset-1">
                <h1 class="title has-text-white has-text-centered">Palauig Monitoring and Information System for Senior Citizens</h1>
            </div>
        </div>
    </section>
    <br><br>
    <section>
        <div class="columns">
            <div class="column is-4 is-offset-4">
                <div class="box">
                    <h1 class="title has-text-centered">
                        Login
                    </h1>
                    <form method="POST">
                        <div class="field">
                            <label for="">Username</label>
                            <div class="control">
                                <input type="text" name="username" class="input">
                            </div>
                        </div>
                        <div class="field">
                        <label for="">Password</label>
                            <div class="control">
                                <input type="password" name="password" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button class="button is-link is-pulled-right">Sign-in</button>
                                <br>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br>
        
</body>
</html>