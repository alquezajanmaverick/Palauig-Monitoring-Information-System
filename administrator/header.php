<script>
    $(document).ready(function(){
        $('[data-modal="credential"]').on('click',function(){
            $('#tblcredential').hide();
            $('[data-modal="viewcredential"]').addClass('is-active')

            $('[credential-toggle="name"]').easyAutocomplete({
                url: "<?php echo ROOT_URL; ?>/profile/view-credential.php",
                getValue: "name",
                list: {	
                    match: {
                    enabled: true
                    },
                    onClickEvent : function(){
                        var value = $('[credential-toggle="name"]').getSelectedItemData();
                        // console.log(value);
                        $('[credential-field="username"]').text(value.userID);
                        $('[credential-field="password"]').text(value.password);
                        $('#tblcredential').show();
                    }
                },
                template: {
                    type: "iconRight",
                    fields: {
                        iconSrc: "url"
                    }
                }
            });
        });



        $('[data-trigger="issuances"]').on('click',function(){
            var issue = $(this);
            $('.hideable').hide();
            $('[member-toggle="name"]').val('');
            $('[data-modal="issuances"]').addClass('is-active');
            $('[member-toggle="name"]').easyAutocomplete({
                url: "<?php echo ROOT_URL; ?>/profile/get-name.php",
                getValue: "name",
                list: {	
                    match: {
                    enabled: true
                    },
                    onClickEvent : function(){
                        var value = $('[member-toggle="name"]').getSelectedItemData();
                        console.log(value);
                        $('[member-field="name"]').text("Issue "+value.name+" a new "+issue.attr('data-string')+"?");
                        $('[data-command="confirmPrint"]').attr('href','<?php echo ROOT_URL; ?>/issuances/issue-credential.php?ID='+value.ID+"&type="+issue.attr('data-trigger'));
                        $('.hideable').show();
                        // $('[credential-field="password"]').text(value.password);
                        $('[data-command="negatePrint"]').on('click',function(){
                            $('[member-toggle="name"]').val('');
                            $('.hideable').hide();
                        });

                        $('[data-command="confirmPrint"]').on('click',function(){
                            $('[data-modal="issuances"]').removeClass('is-active');
                        })

                    }
                }
            });
        });
    })
</script>


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
                Home
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link  has-text-white " href="<?php echo ROOT_URL.'/profile'; ?>">
                Members
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item " href="<?php echo ROOT_URL.'/profile/member-add.php'; ?>">
                        Add New
                    </a>
                    <a class="navbar-item " data-modal="credential" href="#">
                        Credential Retrieval
                    </a>
                </div>
            </div>
            <a class="navbar-item  has-text-white " href="<?php echo ROOT_URL.'/organization'; ?>">
                Organization
            </a>
            <a class="navbar-item  has-text-white " href="<?php echo ROOT_URL.'/barangays'; ?>">
                Barangays
            </a>
            <div class="navbar-item has-dropdown is-hoverable">
                <a class="navbar-link  has-text-white " href="#">
                Issuances
                </a>
                <div class="navbar-dropdown is-boxed">
                    <a class="navbar-item " data-trigger="issuances" data-string="ID" data-type="id" href="#">
                        ID
                    </a>
                    <a class="navbar-item " data-trigger="issuances" data-string="Purchase Slip" data-type="slip" href="#">
                        Purchase Slip
                    </a>
                    <a class="navbar-item " data-trigger="issuances" data-string="Booklet" data-type="booklet" href="#">
                        Booklet
                    </a>
                </div>
            </div>
        </div>
        
        <div class="navbar-end">
            <div class="navbar-item">
                <div class="field is-grouped">
                <p class="control is-vertical-center has-text-white">
                    Hello,&nbsp;
                    <a class="has-text-white" href="<?php echo ROOT_URL.'/user/bio.php'; ?>">
                        <strong><span><?php echo $_SESSION['fullname']; ?></span></strong>
                    </a>
                </p>
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

    <div class="modal" data-modal="viewcredential">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
            <p class="modal-card-title" modal-toggle="name"></p>
            <button class="delete" aria-label="close" onclick="$('[data-modal=\'viewcredential\']').removeClass('is-active')"></button>
            </header>
            <section class="modal-card-body">
            <!-- Content ... -->
                
                <div class="content" >
                    <h2 class="has-text-centered"><strong>Credential Search</strong></h2>
                    
                    <div class="field">
                        <div class="control">
                            <label for="">Name:</label>
                            <input credential-toggle="name" type="text" class="input">
                        </div>
                    </div>
                    <br><br>
                    
                </div>
            </section>
            <footer class="modal-card-foot has-text-right">
                <!-- <button class="button is-dark">
                    <span class="icon is-small">
                        <i class="fa fa-print"></i>
                    </span>
                    <span>Print</span>
                </button> -->
                <!-- <button class="button">Close</button> -->
            </footer>
        </div>
    </div>

    <div class="modal" data-modal="issuances">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
            <p class="modal-card-title" modal-toggle="name"></p>
            <button class="delete" aria-label="close" onclick="$('[data-modal=\'issuances\']').removeClass('is-active')"></button>
            </header>
            <section class="modal-card-body">
            <!-- Content ... -->
                
                <div class="content" >
                    <h2 class="has-text-centered"><strong>Member Search:</strong></h2>
                    
                    <div class="field">
                        <div class="control">
                           <label for="">Name:</label>
                            <input member-toggle="name" type="text" class="input">
                        </div>
                    </div>
                    <div class="field has-text-centered hideable">
                        <h1 member-field="name"></h1>
                        <div class="control">
                            <div class="buttons">
                                <a href="#" target="_blank" class="button is-primary" data-command="confirmPrint">Yes</a>
                                <a href="#" class="button is-danger" data-command="negatePrint">No</a>
                            </div>
                        </div>
                    </div>
                </div>
                <br><br>
            </section>
        </div>
    </div>