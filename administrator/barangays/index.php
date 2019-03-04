<?php
require_once('../access.php');
require_once('../connector.php');

$db = new DatabaseConnect();
$db->query("SELECT * FROM tblbrgy ORDER BY brgy ASC");
$b = $db->resultset();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <?php include(ROOT_DIR."/imports.php"); ?>
    
</head>
<body>
<?php include(ROOT_DIR."/header.php"); ?>
<section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container">
            <h1 class="title">
                Palauig Monitoring and Information System for Senior Citizen
            </h1>
            <h2 class="subtitle">
                List of Barangays
            </h2>
            </div>
        </div>
    </section>

    <section style="transform: translateY(-100px);">
        <div class="columns">
            <div class="column is-1"></div>
            <div class="column is-10">
                <div class="box">
                    <table class="table is-fullwidth">
                        <thead>
                            <th>Barangays</th>
                        </thead>
                        <tbody>
                            <?php foreach($b as $brgy) { ?>
                                <tr>
                                    <td><?php echo $brgy['brgy']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                
                </div>
            </div>
            <div class="column is-1"></div>
        </div>
    </section>
</body>
</html>