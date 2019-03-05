<?php 
session_start();
session_destroy();
require_once('connector.php');
$db = new DatabaseConnect();
$error="";
$marker = "is-info";
if(isset($_POST['username'])){
    $db->query("SELECT * FROM tblsuperuser WHERE username = ? AND password = ? LIMIT 1");
    $db->bind(1,$_POST['username']);
    $db->bind(2,$_POST['password']);
    $x = $db->single();
    $r = $db->rowCount();
    if($r>0){
        session_start();
        $_SESSION['ID'] = $x['ID'];
        $_SESSION['fullname'] = $x['fullname'];
        header("Location: dashboard/");
    }
    else{
        $error = "invalid username or password.";
        $marker = "is-danger";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="../node_modules/bulma/css/bulma.min.css">
    <link rel="stylesheet" href="../administrator/styles.css">
    <script src="../node_modules/jquery/dist/jquery.min.js"></script>
    <title>Palauig Monitoring and Information System for Senior Citizen</title>
</head>
<body style="background-image: url('../assets/loginmain.jpg');background-size:cover;height:100vh">
    <div class="login-bg is-desktop">
        <section>
            <div class="columns">
                <div class="column is-10 is-offset-1">
                    <h1 class="title has-text-white has-text-centered">Palauig Monitoring and Information System for Senior Citizens</h1>
                </div>
            </div>
        </section>
        <br>
       <section>
            <div class="columns">
                    <div class="column"></div>
                    <div class="column">
                        <div class="card login-card">
                            <div class="card-content">
                            <h1 class="title has-text-centered">Super Administrator Login</h1>
                            <p class="subtitle is-7 has-text-info has-text-centered">Only privilege users are allowed to enter.</p>
                            <form method="POST">
                                    <div class="field">
                                        <label class="label">Username</label>
                                        <div class="control">
                                            <input class="input <?php echo $marker; ?>" type="text" name="username" placeholder="your username here">
                                        </div>
                                    </div>
                                    <div class="field">
                                        <label class="label">Password</label>
                                        <div class="control">
                                            <input class="input <?php echo $marker; ?>" type="password" name="password" placeholder="your password here">
                                        </div>
                                    </div>
                                    <br>
                                    <p class="has-text-danger is-size-6"><?php echo $error; ?></p>
                            </div>
                            <footer class="card-footer">
                                <button type="submit" class="has-background-link has-text-white card-footer-item">Sign-in</button>
                            </form>
                            </footer>
                        </div>
                    </div>
                    <div class="column"></div>
                </div>
       </section>
    </div>  
</body>
</html>