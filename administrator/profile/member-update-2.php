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
            var newData = [];

            $.ajax({
                type: "get",
                url: "<?php echo ROOT_URL; ?>/profile/get-credentials.php?ID=<?php echo $_GET['ID']; ?>",
                success: function (response) {
                    var credential = JSON.parse(response)[0];
                    $('p#usernameprint').text(credential.userID)
                    $('p#passwordprint').text(credential.password)
                }
            });

            refreshUI();
            function refreshUI(){
                $.ajax({
                type: "get",
                url: "get-composition.php?ID=<?php echo $_GET['ID']; ?>",
                dataType: "json",
                success: function (response) {
                    $('tr[data-type="member-adder"]').siblings('tr').remove();
                    $.each(response,function(i,v){
                        $('<tr data="olddata">\
                            <td style="display:flex"><a data-type="delete-member" data-id="'+v.compoID+'">\
                                <span class="icon has-text-danger">\
                                    <i class="fa fa-minus-circle is-large"></i>\
                                </span></a>\
                                <a data-type="update-member" data-id="'+v.compoID+'">\
                                <span class="icon has-text-warning">\
                                    <i class="fa fa-edit is-large"></i>\
                                </span>\
                            </a></td>\
                            <td>'+v.name+'</td>\
                            <td>'+v.relationship+'</td>\
                            <td>'+v.c_age+'</td>\
                            <td>'+v.c_civil_status+'</td>\
                            <td>'+v.c_occupation+'</td>\
                            <td>'+v.c_income+'</td>\
                        </tr>').insertBefore('tr[data-type="member-adder"]');
                    });

                    $('a[data-type="delete-member"]').on('click',function(){
                        var tr = $(this).closest('tr');
                        $.ajax({
                            type: "post",
                            url: "delete-composition.php",
                            data: {
                                compoID:$(this).attr('data-id')
                            },
                            async:false,
                            success: function (response) {
                                if(response=='success'){
                                    tr.remove();
                                }
                                
                            }
                        });
                    });

                    
                    $('[data-type="update-member"]').on('click',function(){
                        var compoID = $(this).attr('data-id')
                        $.ajax({
                            type: "get",
                            url: "get-composition-unique.php?ID="+compoID,
                            dataType: "json",
                            async:false,
                            success: function (response) {
                                $('input[name="compoID"]').val(compoID);
                                console.log($('input[name="compoID"]').val())
                                $('input[name="name"]').val(response[0].name);
                                $('input[name="relationship"]').val(response[0].relationship);
                                $('input[name="c_age"]').val(response[0].c_age);
                                $('input[name="c_civil_status"]').val(response[0].c_civil_status);
                                $('input[name="c_occupation"]').val(response[0].c_occupation);
                                $('input[name="c_income"]').val(response[0].c_income);
                                $('[data-modal="updatedetail"]').addClass('is-active');
                            }
                        });

                    });

                }
                });
            }


            // confirm update
            $('#updatesubmit').on('click',function(){
                $.ajax({
                    type: "post",
                    url: "update-composition.php",
                    data: {
                        compoID: $('input[name="compoID"]').val(),
                        name: $('input[name="name"]').val(),
                        relationship: $('input[name="relationship"]').val(),
                        c_age: $('input[name="c_age"]').val(),
                        c_civil_status: $('input[name="c_civil_status"]').val(),
                        c_occupation: $('input[name="c_occupation"]').val(),
                        c_income: $('input[name="c_income"]').val()
                    },
                    async:false,
                    success: function (response) {
                        refreshUI();
                        $('[data-modal="updatedetail"]').removeClass('is-active');
                    }
                });
            })
            

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
                $('[data-toggle="submit"]').attr('disabled',false);
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
                // console.log(fdata)
                $.ajax({
                    type: "post",
                    url: "<?php echo ROOT_URL; ?>/profile/status.php",
                    data: JSON.stringify(fdata),
                    success: function (response) {
                        if(response!=""){
                            // window.print();
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
                                <button data-toggle="submit" class="button is-primary" disabled>Save New Record/s</button>
                                <a href="<?php echo ROOT_URL; ?>/profile/" type="button" class="button is-link"><< Back to Members List</a>
                            </div>
                        </div>

                        
                    </div>

            </div>
            <div class="tile is-2"></div>
        </div>
        
    </div>


    <div class="modal" data-modal="updatedetail">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
            <p class="modal-card-title" modal-toggle="name"></p>
            <button class="delete" aria-label="close" onclick="$('[data-modal=\'updatedetail\']').removeClass('is-active')"></button>
            </header>
            <section class="modal-card-body" style="overflow-x: hidden;">
            <!-- Content ... -->
                <div class="content">
                    <h2 class="has-text-centered"><strong>Record Information</strong></h2>
                    <form id="frmupdate">
                        <input name="compoID" type="hidden" class="input">
                        <div class="field">
                            <div class="control">
                                <label for="">Name</label>
                                <input name="name" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label for="">Relationship</label>
                                <input name="relationship" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label for="">Age</label>
                                <input type="number" min="0" name="c_age" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label for="">Civil Status</label>
                                <input name="c_civil_status" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label for="">Occupation</label>
                                <input name="c_occupation" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <label for="">Income</label>
                                <input type="number" name="c_income" class="input">
                            </div>
                        </div>
                        <div class="field">
                            <div class="control">
                                <button id="updatesubmit" type="button" class="button is-pulled-right is-link">Update</button>
                            </div>
                        </div>
                    </form>
                    
                </div>
            </section>
        </div>
    </div>




</body>
</html>