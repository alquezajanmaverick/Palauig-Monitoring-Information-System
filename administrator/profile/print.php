<?php
require_once("../access.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../node_modules/bulma/css/bulma.min.css">
    <script src="../../node_modules/jquery/dist/jquery.min.js"></script>
    <title>Print</title>
    <script>
        $(document).ready(function(){
            let data = JSON.parse(window.atob('<?php echo $_GET['json']; ?>'));
            let brgy = ('<?php echo $_GET['brgy']; ?>'=='ALL' ? 'All Barangays' : 'Barangay <?php echo $_GET['brgy']; ?>');
            console.log(brgy);
            console.log(data);
            $('ol *').remove();
            $('h1').text("List of Members from " + brgy);
            $.each(data,function(i,v){
                $('ol').append(
                    '<li>'+ v.fname +' '+ v.mname +' '+ v.lname +'</li>'
                );
            });
            window.print();
            window.close();
        })
    </script>
</head>
<body>
    <div class="container">
        <h1 class="title has-text-centered is-size-4"></h1>
        <div class="content">
            <ol type="1" class="is-small"></ol>
        </div>
    </div>
</body>
</html>