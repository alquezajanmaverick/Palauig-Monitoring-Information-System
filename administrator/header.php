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
        })
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
                    <table id="tblcredential">
                        <tr>
                            <td><strong>Username:</strong></td>
                            <td credential-field="username"></td>
                        </tr>
                        <tr>
                            <td><strong>Password:</strong></td>
                            <td credential-field="password"></td>
                        </tr>
                    </table>
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