<?php

require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
if(!isset($_GET['ID'])){
    header("Location:". ROOT_URL ."/profile/member-add.php");
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
            $.ajax({
                type: "get",
                url: "<?php echo ROOT_URL; ?>/profile/get-credentials.php?ID=<?php echo $_GET['ID']; ?>",
                success: function (response) {
                    var credential = JSON.parse(response)[0];
                    $('p#usernameprint').text(credential.userID)
                    $('p#passwordprint').text(credential.password)
                }
            });

            $('a[data-type="insert-member"]').on('click',function(){
                $('<tr data-toggle="member">\
                    <td data-value="ID" get-value="<?php echo $_GET['ID']; ?>"></td>\
                    <td data-value="name" get-value="'+$('input[data-toggle="name"]').val()+'">'+ $('input[data-toggle="name"]').val() +'</td>\
                    <td data-value="relationship" get-value="'+ $('input[data-toggle="relationship"]').val() +'">'+ $('input[data-toggle="relationship"]').val() +'</td>\
                    <td data-value="age" get-value="'+ $('input[data-toggle="age"]').val() +'">'+ $('input[data-toggle="age"]').val() +'</td>\
                    <td data-value="civil_status" get-value="'+ $('input[data-toggle="civil_status"]').val() +'">'+ $('input[data-toggle="civil_status"]').val() +'</td>\
                    <td data-value="occupation" get-value="'+ $('input[data-toggle="occupation"]').val() +'">'+ $('input[data-toggle="occupation"]').val() +'</td>\
                    <td data-value="income" get-value="'+ $('input[data-toggle="income"]').val() +'">'+ $('input[data-toggle="income"]').val() +'</td>\
                </tr>').insertBefore('tr[data-type="member-adder"]');
                $('tr[data-type="member-adder"] input').each(function(){
                    $(this).val("")
                })
                $('input').first().focus()
            })
            
            $('button[data-toggle="submit"]').on('click',function(){
                var fdata=[];
                $('tr[data-toggle="member"]').each(function(i,v){
                    var data = {};
                    var member = $(this).find('td');
                    member.each(function(){
                        if($(this).attr("data-value") != undefined){
                            data[$(this).attr("data-value")] = $(this).attr("get-value");
                        }
                    });
                    fdata.push(data);
                })
                console.log(fdata)
                $.ajax({
                    type: "post",
                    url: "<?php echo ROOT_URL; ?>/profile/status.php",
                    data: JSON.stringify(fdata),
                    success: function (response) {
                        if(response!=""){
                            window.print();
                            window.location = "<?php echo ROOT_URL; ?>/profile/success.php?ID="+response;
                        }
                    }
                });
            })

        })
    </script>
</head>
<body>
    <?php include(ROOT_DIR."/header.php"); ?>


    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                Palauig Monitoring and Information Management System
                </h1>
                <h2 class="subtitle">
                    Update Relationship Composition
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
                    <div class="step-item">
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
            <div class="tile is-2"></div>
            <div class="tile is-8 is-vertical">

                <div class="box addnew">
                        <h1 class="title has-text-centered">Family Composition</h1>
                        <table class="table table-bordered table-hovered is-fullwidth">
                            <thead>
                                <th></th>
                                <th class="has-text-centered">Name</th>
                                <th class="has-text-centered">Relationship</th>
                                <th class="has-text-centered">Age</th>
                                <th class="has-text-centered">Civil Status</th>
                                <th class="has-text-centered">Occupation</th>
                                <th class="has-text-centered">Income</th>
                            </thead>
                            <tbody>
                                    <tr data-type="member-adder">
                                        <td>
                                            <a data-type="insert-member">
                                                <span class="icon has-text-info">
                                                    <i class="fa fa-plus-circle is-large"></i>
                                                </span>
                                            </a>
                                        </td>
                                        <td>
                                            <input data-toggle="name" class="control input is-small" type="text">
                                        </td>
                                        <td>
                                            <input data-toggle="relationship" class="control input is-small" type="text">
                                        </td>
                                        <td>
                                            <input data-toggle="age" class="control input is-small" type="number" min="0" max="59">
                                        </td>
                                        <td>
                                            <input data-toggle="civil_status" class="control input is-small" type="text">
                                        </td>
                                        <td>
                                            <input data-toggle="occupation" class="control input is-small" type="text">
                                        </td>
                                        <td>
                                            <input data-toggle="income" class="control input is-small" type="number">
                                        </td>
                                    </tr>
                            </tbody>
                        </table>

                        
                        
                        <br>
                        <div class="columns">
                            <div class="column is-12 has-text-centered">
                                <button data-toggle="submit" class="button is-primary">Submit</button>
                                <a href="<?php echo ROOT_URL; ?>/profile/success.php" type="button" class="button is-link">Skip >></a>
                            </div>
                        </div>

                        
                    </div>

            </div>
            <div class="tile is-2"></div>
        </div>
        
    </div>

</body>
</html>