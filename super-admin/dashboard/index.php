<?php
require_once("../access.php");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="../../node_modules/font-awesome/css/font-awesome.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_IMPORT; ?>/node_modules/animate.css/animate.min.css">
    <link rel="stylesheet" href="<?php echo ROOT_IMPORT; ?>/node_modules/bulma/css/bulma.min.css">
    <script src="<?php echo ROOT_IMPORT; ?>/node_modules/bulma-toast/dist/bulma-toast.min.js"></script>
    <script src="<?php echo ROOT_IMPORT; ?>/node_modules/jquery/dist/jquery.min.js"></script>
    <script src="<?php echo ROOT_IMPORT; ?>/node_modules/moment/moment.js"></script>
    <title>Palauig Monitoring and Information System for Senior Citizen</title>
    <script>
    
        var admininterval;
        $(document).ready(function(){
            // fetch admin list
            

            function fetchadmin(){
                $.ajax({
                    type: "get",
                    url: "api/get-users.php",
                    dataType: "json",
                    success: function (response) {
                        $('#tbladminlist>tbody *').remove();
                        $.each(response,function(i,v){
                            $('#tbladminlist>tbody').append('\
                                <tr data-id="'+v.ID+'">\
                                    <td class="has-text-white">'+ v.fullname +'</td>\
                                    <td class="has-text-white has-text-right">\
                                        <button admin-toggle="update" admin-update-id="'+v.ID+'" admin-update-name="'+v.fullname+'" class="button is-small is-warning">\
                                            <span class="icon"><i class="fa fa-pencil"></i></span><span>Update</span>\
                                        </button>\
                                        <button admin-toggle="delete" admin-delete-id="'+v.ID+'" admin-delete-name="'+v.fullname+'" class="isdelete button is-small is-danger">\
                                            <span class="icon"><i class="fa fa-trash"></i></span><span>Remove</span>\
                                        </button>\
                                    </td>\
                                </tr>\
                            ');
                        });

                        
                    }
                });
            }

            function fetchadminloggedin(){
                $.ajax({
                    type: "get",
                    url: "api/get-admin-logged-in.php",
                    dataType: "json",
                    success: function (response) {
                        $('#tbladminloggedin>tbody *').remove();
                        $.each(response,function(i,v){
                            $('#tbladminloggedin>tbody').append('\
                                <tr>\
                                    <td class=" is-size-7">'+ v.User +'</td>\
                                    <td class="has-text-right is-size-7">'+ moment(v.LoggedAt,"YYYY-MM-DD HH:mm:ss").format("MMM Do, YYYY hh:mm A") +'</td>\
                                </tr>\
                            ');
                        });

                        
                    }
                });
            }

            // delete button
            $('#tbladminlist>tbody').on('click','button[admin-toggle="delete"]',function(){
                let id = $(this).attr('admin-delete-id');
                let name = $(this).attr('admin-delete-name');
                if(confirm('Delete '+ name + ' from record list?')){
                    $.ajax({
                        type: "post",
                        url: "api/delete-user.php",
                        data: {
                            'id':id
                        },
                        success: function (response) {
                            fetchadmin();

                            bulmaToast.toast({ 
                                message: name+" delete successfully", 
                                type: "is-success",
                                dismissible:true,
                                animate: { in: "fadeIn", out: "fadeOut" },
                                position: 'bottom-right',
                                duration:3000
                            });
                        }
                    });
                }
            })

            // update button
            $('#tbladminlist>tbody').on('click','button[admin-toggle="update"]',function(){
                let id = $(this).attr('admin-update-id');
                let name = $(this).attr('admin-update-name');
                $('.error').hide();
                $('[data-error="username"]').hide();
                $.ajax({
                    type: "post",
                    url: "api/get-users.php?ID="+id,
                    dataType: 'json',
                    success: function (response) {
                        $('[form-data="updateuser"] [name="fullname"]').val(response[0].fullname);
                        $('[form-data="updateuser"] [name="username"]').val(response[0].username);
                        $('[form-data="updateuser"] [name="password"]').val(response[0].password);
                        $('[form-data="updateuser"] [name="password"]').trigger('keyup')
                        $('[form-data="updateuser"] [name="confirmpassword"]').val(response[0].password);
                        $('[form-data="updateuser"] [name="id"]').val(id);
                        $('[data-modal="updateuser"]').addClass('is-active');
                    }
                });

                $('[form-data="updateuser"] [name="username"]').on('keyup',function(){
                    setTimeout(() => {
                        $.ajax({
                            type: "GET",
                            url: "api/get-users.php?username="+ $(this).val(),
                            dataType: "json",
                            success: function (response) {
                                console.log($('[form-data="updateuser"] [name="username"]').val())
                                if(response.length>0 && $('[form-data="updateuser"] [name="username"]').val() != name){
                                    $('[data-error="username"]').show();
                                    $('#adduserbtnmodal').prop("disabled",true);
                                }else{
                                    $('[data-error="username"]').hide();
                                    $('#adduserbtnmodal').prop("disabled",false);
                                }
                            }
                        });
                    }, 1000);
                });

                $('[form-data="updateuser"] [name="confirmpassword"]').on('keyup',function(){
                    if($('[name="confirmpassword"]').val() === $('[name="password"]').val()){
                        
                        $('[name="confirmpassword"]').removeClass('is-focused');
                        $('[name="confirmpassword"]').removeClass('is-danger');
                        $('#adduserbtnmodal').prop("disabled",false);
                        $('.error').hide();
                    }else{
                        $('[name="confirmpassword"]').toggleClass('is-focused');
                        $('[name="confirmpassword"]').toggleClass('is-danger');
                        $('#adduserbtnmodal').prop("disabled",true);
                        $('.error').show();
                    }
                })

                $('[form-data="updateuser"] [name="password"]').on('keyup',function(){
                    if($('[name="confirmpassword"]').val() != ''){
                        if($('[name="confirmpassword"]').val() === $('[name="password"]').val()){
                            
                            $('[name="confirmpassword"]').removeClass('is-focused');
                            $('[name="confirmpassword"]').removeClass('is-danger');
                            $('#adduserbtnmodal').prop("disabled",false);
                            $('.error').hide();
                        }else{
                            $('[name="confirmpassword"]').toggleClass('is-focused');
                            $('[name="confirmpassword"]').toggleClass('is-danger');
                            $('#adduserbtnmodal').prop("disabled",true);
                            $('.error').show();
                        }
                    }
                });
            })

            $('#adduserbtn').on('click',function(){
                $('[form-data="adduser"] input').val('');
                $('[data-modal="adduser"]').addClass("is-active");
                $('#adduserbtnmodal').prop("disabled",true);
                $('.error').hide();
                $('[data-error="username"]').hide();

                $('[name="username"]').on('keyup',function(){
                    setTimeout(() => {
                        $.ajax({
                            type: "GET",
                            url: "api/get-users.php?username="+ $(this).val(),
                            dataType: "json",
                            success: function (response) {
                                if(response.length>0){
                                    $('[data-error="username"]').show();
                                    $('#adduserbtnmodal').prop("disabled",true);
                                }else{
                                    $('[data-error="username"]').hide();
                                    $('#adduserbtnmodal').prop("disabled",false);
                                }
                            }
                        });
                    }, 1000);
                });

                $('[name="confirmpassword"]').on('keyup',function(){
                    if($('[name="confirmpassword"]').val() === $('[name="password"]').val()){
                        
                        $('[name="confirmpassword"]').removeClass('is-focused');
                        $('[name="confirmpassword"]').removeClass('is-danger');
                        $('#adduserbtnmodal').prop("disabled",false);
                        $('.error').hide();
                    }else{
                        $('[name="confirmpassword"]').toggleClass('is-focused');
                        $('[name="confirmpassword"]').toggleClass('is-danger');
                        $('#adduserbtnmodal').prop("disabled",true);
                        $('.error').show();
                    }
                })

                $('[name="password"]').on('keyup',function(){
                    if($('[name="confirmpassword"]').val() != ''){
                        if($('[name="confirmpassword"]').val() === $('[name="password"]').val()){
                            
                            $('[name="confirmpassword"]').removeClass('is-focused');
                            $('[name="confirmpassword"]').removeClass('is-danger');
                            $('#adduserbtnmodal').prop("disabled",false);
                            $('.error').hide();
                        }else{
                            $('[name="confirmpassword"]').toggleClass('is-focused');
                            $('[name="confirmpassword"]').toggleClass('is-danger');
                            $('#adduserbtnmodal').prop("disabled",true);
                            $('.error').show();
                        }
                    }
                });

            });

            $('[form-data="adduser"]').on('submit',function(e){
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: "api/add-user.php",
                    data: $(this).serializeArray(),
                    success: function (response) {
                        $('[data-close="adduser"]').trigger('click');
                        fetchadmin();
                        
                        bulmaToast.toast({ 
                            message: "new user added", 
                            type: "is-success",
                            dismissible:true,
                            animate: { in: "fadeIn", out: "fadeOut" },
                            position: 'bottom-right',
                            duration:3000
                        });
                    }
                });
                return false;
            });

            $('[form-data="updateuser"]').on('submit',function(e){
                e.preventDefault();

                $.ajax({
                    type: "post",
                    url: "api/update-user.php",
                    data: $(this).serializeArray(),
                    success: function (response) {
                        $('[data-close="updateuser"]').trigger('click');
                        fetchadmin();
                        
                        bulmaToast.toast({ 
                            message: "existing user updated", 
                            type: "is-success",
                            dismissible:true,
                            animate: { in: "fadeIn", out: "fadeOut" },
                            position: 'bottom-right',
                            duration:3000
                        });
                    }
                });
                return false;
            });

            

            fetchadmin();
            fetchadminloggedin();
            
            $('[data-trigger="adminupdate"]').on('click',function(){
                var span = $(this).find('span');
                if(span.hasClass('has-text-danger')){
                    span.removeClass('has-text-danger');
                    admininterval = setInterval(function(){
                        fetchadminloggedin()
                    }, 3000);
                    $(this).attr('title','auto-update is turned on.');
                    span.addClass('has-text-success');
                    $('a[data-trigger="adminforceupdate"]').attr('disabled','disabled');
                }else{
                    span.removeClass('has-text-success');
                    clearInterval(admininterval);
                    fetchadminloggedin();
                    $(this).attr('title','auto-update is turned off.');
                    span.addClass('has-text-danger');
                    $('a[data-trigger="adminforceupdate"]').removeAttr('disabled');
                }
            });
            $('a[data-trigger="adminforceupdate"]').on('click',function(){
                fetchadmin();
            })
        })
    </script>
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

    <div class="tile is-ancestor" style="height: 90vh;">
        <div class="tile is-vertical is-8">
            <div class="tile">
                <div class="tile is-parent is-vertical">

                    <article class="tile is-child notification is-primary">
                    <p class="title">Currently Logged-in</p>
                    <p class="subtitle">Senior Citizen</p>
                    <!-- <p class="subtitle">Top tile</p> -->
                    </article>

                    <!-- Currently Logged in Administrators -->
                    <article class="tile is-child notification is-warning">
                    <p class="title">Currently Logged-in</p>
                    <p class="subtitle">Administrator 
                        <a data-trigger="adminforceupdate" class="is-pulled-right button is-small is-warning" title="Single Refresh.">Force Refresh</a>
                        <a data-trigger="adminupdate" title="auto-update is turned off."><span class="icon has-text-danger is-pulled-right"><i class="fa fa-refresh"></i></span></a>
                    </p>
                    <!-- <p class="subtitle">Bottom tile</p> -->
                        <div class="content" style="overflow-y: auto;height: 30vh;padding-right: 10px; margin-right: -25px;">
                            <table id="tbladminloggedin" class="table is-narrow it-fullwidth" style="background:transparent">
                                <thead class="has-text-white">
                                    <th class="">Administrator</th>
                                    <th class="has-text-right">Date-Time Logged In</th>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
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
            <!-- <div class="tile is-parent">
            <article class="tile is-child notification is-danger">
                <p class="title">Notification Area</p>
                <div class="content">
                </div>
            </article>
            </div> -->
        </div>

        <!-- List of users -->
        <div class="tile is-parent">
            <article class="tile is-child notification is-success">
            <div class="content">
                <p class="title">List of Administrators</p>
                <!-- <p class="subtitle">With even more content</p> -->
                <div class="content" style="overflow-y: auto;height: 70vh;padding-right: 10px; margin-right: -25px;">
                <!-- Content -->
                    <table id="tbladminlist" class="table is-narrow it-fullwidth" style="background:transparent">
                        <thead class="has-text-white">
                            <th class="has-text-white">Users</th>
                            <th class="has-text-white has-text-right"><a id="adduserbtn" href="#" class="button is-link is-small"><span class="icon"><i class="fa fa-plus"></i></span><span>Add new</span></a></th>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
            </article>
        </div>

    </div>

    </div>






    <!-- add user -->
    <div data-modal="adduser" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <!-- Any other Bulma elements you want -->
            <div class="box">
                <h1 class="has-text-centered title">Add User</h1>
                <form method="post" form-data="adduser">
                    <div class="field">
                        <div class="control">
                            <label for="">Full Name:</label>
                            <input type="text" class="input" name="fullname">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Username:</label>
                            <input type="text" class="input" name="username">
                            <p data-error="username" class="is-size-7 has-text-danger">Username already taken.</p>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Password:</label>
                            <input type="password" class="input" name="password">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Confirm Password:</label>
                            <input type="password" class="input" name="confirmpassword">
                            <p class="is-size-7 has-text-danger error">Password doesn't match.</p>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button id="adduserbtnmodal" type="submit" class="button is-link is-pulled-right">Submit</button>
                        </div>
                    </div>
                </form>
                <br><br>
            </div>
        </div>
        <button data-close="adduser" class="modal-close is-large" onclick="$(this).closest('.modal').removeClass('is-active')" aria-label="close"></button>
    </div>


    <!-- update user modal -->
    <div data-modal="updateuser" class="modal">
        <div class="modal-background"></div>
        <div class="modal-content">
            <div class="box">
                <h1 class="title">Update Existing User</h1>
                <form method="post" form-data="updateuser">
                    <input type="hidden" name="id">
                    <div class="field">
                        <div class="control">
                            <label for="">Full Name:</label>
                            <input type="text" class="input" name="fullname">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Username:</label>
                            <input type="text" class="input" name="username">
                            <p data-error="username" class="is-size-7 has-text-danger">Username already taken by others.</p>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Password:</label>
                            <input type="password" class="input" name="password">
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <label for="">Confirm Password:</label>
                            <input type="password" class="input" name="confirmpassword">
                            <p class="is-size-7 has-text-danger error">Password doesn't match.</p>
                        </div>
                    </div>
                    <div class="field">
                        <div class="control">
                            <button id="updateuserbtnmodal" type="submit" class="button is-link is-pulled-right">Submit</button>
                        </div>
                    </div>
                </form>
                <br><br>
            </div>
        </div>
        <button  data-close="updateuser" class="modal-close is-large" onclick="$(this).closest('.modal').removeClass('is-active')" aria-label="close"></button>
    </div>
</body>
</html>