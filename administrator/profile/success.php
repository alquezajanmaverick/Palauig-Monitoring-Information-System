<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');

$x = array(
    'fname'=>'',
    'lname'=>'',
);
if(isset($_GET['ID'])){
    $db = new DatabaseConnect();
    $db->query("SELECT fname,lname from tblmember WHERE ID = ?");
    $db->bind(1,$_GET['ID']);
    $x = $db->single();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include(ROOT_DIR."/imports.php"); ?>

    <script>
        $(document).ready(function(){

        })
    </script>
</head>
<body>
    <?php include(ROOT_DIR."/header.php"); ?>
    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                    Municipal Monitoring Information Management System
                </h1>
                <h2 class="subtitle">
                    Add New Member
                </h2>

                <div class="steps" id="stepsDemo">
                    <div class="step-item is-active is-success">
                        <div class="step-marker">1</div>
                        <div class="step-details">
                            <p class="step-title">Member Details</p>
                        </div>
                    </div>
                    <div class="step-item is-active is-success">
                        <div class="step-marker">2</div>
                        <div class="step-details">
                            <p class="step-title">Relationship Composition</p>
                        </div>
                    </div>
                    <div class="step-item is-active is-success">
                        <div class="step-marker">
                            <span class="icon">
                                <i class="fa fa-flag"></i>
                            </span>
                        </div>
                        <div class="step-details">
                            <p class="step-title">Finish</p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>


    <div id="addform" class="container">
        <div class="tile is-ancestor">
            <div class="tile is-3"></div>
            <div class="tile is-6 is-vertical">

                <div class="box addnew">
                        <h1 class="title has-text-centered">Membership Form</h1>
                        <h2 class="subtitle has-text-centered has-text-success"><?php echo $x['fname']; ?> <?php echo $x['lname']; ?> successfully added.</h2>
                        <div class="columns">
                            <div class="column is-12 has-text-centered">
                                <a href="<?php echo ROOT_URL; ?>/profile/member-add.php" class="button is-primary">Add Another Member</a>
                                <a href="<?php echo ROOT_URL; ?>/profile/" class="button is-link">Go to Profiles Page</a>
                            </div>
                        </div>

                        
                    </div>

            </div>
            <div class="tile is-6"></div>
        </div>
        
    </div>

</body>
</html>