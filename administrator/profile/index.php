<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
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
            $('[data-target="print"]').hide();
            var limit = 10;
            var offset = 0;
            var count =0;

            $.ajax({
                type: "GET",
                url: "<?php echo ROOT_URL; ?>/profile/get-brgy.php",
                success: function (response) {
                    $.each(JSON.parse(response),function(i,v){
                        $('#brgyselect').append('<option value="'+v.brgyID+'">'+v.brgy+'</option>');
                    })
                }
            });

            $('[data-trigger="search"]').on('click',function(){

                count = getCount(offset,limit,$('#namesearch').val(),$('#statusselect').val(),$('#brgyselect').val());
                var offsetcount = Math.round(count / limit);
                // console.log(offsetcount)
                var arrpage = [];
                var interval = 0;
                arrpage.push(0);
                for(var i=0;i<offsetcount-1;i++){
                    arrpage.push(interval+=limit)
                }
                // console.log(arrpage)
                
                getData($(this).attr("page-offset"),limit,$('#namesearch').val(),$('#statusselect').val(),$('#brgyselect').val());

                function getCount(xoffset,xlimit,name='',status,brgy){
                    var urlAppend = "";
                    if(name!=""){
                        urlAppend +="&name="+name;
                    }
                    if(status=='active'){
                        urlAppend +="&status="+status;
                    }else if(status=='notactive'){
                        urlAppend += "&status=notactive";
                    }else{
                        urlAppend += "&status=all";
                    }
                    urlAppend += "&brgy="+brgy;
                    var ctr;
                    $.ajax({
                        type: "GET",
                        url: "<?php echo ROOT_URL; ?>/profile/get-count.php?offset="+xoffset+"&limit="+xlimit+urlAppend,
                        async:false,
                        success: function (response) {
                            ctr=response;
                        }
                    });
                    return ctr;
                }
                function getData(xoffset,xlimit,name='',status,brgy){
                    var urlAppend = "";
                    if(name!=""){
                        urlAppend +="&name="+name;
                    }
                    if(status=='active'){
                        urlAppend +="&status="+status;
                    }else if(status=='notactive'){
                        urlAppend += "&status=notactive";
                    }else{
                        urlAppend += "&status=all";
                    }
                        urlAppend += "&brgy="+brgy;

                    $.ajax({
                    type: "GET",
                    url: "<?php echo ROOT_URL; ?>/profile/get-list.php?offset="+xoffset+"&limit="+xlimit+urlAppend,
                    async:false,
                    success: function (response) {
                        var data = JSON.parse(response);
                        // var data=response;
                        $('tbody#memberlist *').remove();
                        $('nav.pagination a').remove();
                        $('ul.pagination-list li').remove();
                        console.table(data)

                        // display print button
                        if(data.length>0){
                            $('[data-target="print"]').show();
                        }else{
                            $('[data-target="print"]').hide();
                        }

                        bulmaToast.toast({ 
                            message: data.length+" Members Found.", 
                            type: "is-primary",
                            dismissible:true,
                            animate: { in: "fadeIn", out: "fadeOut" },
                            position: 'bottom-right',
                            duration:5000
                        });

                        $(data).each(function(index,value){
                            $('tbody#memberlist').append('\
                            <tr data-status="'+value.status+'">\
                                <td class="is-size-7" data-id="'+value.ID+'">\
                                    <a data-unique="ID" data-infoID="'+value.ID+'"><span class="icon has-text-white">\
                                        <i class="fa fa-eye"></i>\
                                    </span></a>\
                                </td>\
                                <td class="is-size-7" data-name="'+value.fname+' '+value.mname+' '+value.lname+'">'+value.fname+' '+value.mname+' '+value.lname+'</td>\
                                <td class="is-size-7" data-age="'+value.dob+'">'+moment(value.dob).format('MMM Do, YYYY')+'</td>\
                                <td class="is-size-7" data-age="'+value.age+'">'+value.age+'</td>\
                                <td class="is-size-7" data-sex="'+value.sex+'">'+value.sex+'</td>\
                                <td class="is-size-7" data-status="'+value.civil_status+'">'+value.civil_status+'</td>\
                                <td class="is-size-7" data-attainment="'+value.edu_attainment+'">'+value.edu_attainment+'</td>\
                                <td class="is-size-7" data-occupation="'+value.occupation+'">'+value.occupation+'</td>\
                                <td class="is-size-7" data-income="'+value.income+'">'+value.income+'</td>\
                                <td class="is-size-7" data-skills="'+value.skills+'">'+value.skills+'</td>\
                                <td><a href="<?php echo ROOT_URL; ?>/profile/member-update.php?ID='+value.ID+'" class="button is-small is-size-7 is-warning" title="Update Member"><span class="icon has-text-white is-small is-left"><i class="fa fa-edit"></i></span></a></td>\
                                <td>\
                                    <a class="button is-small is-size-7 is-link" data-button="activate" data-id="'+value.ID+'" title="Activate"><span class="icon is-small is-left"><i class="fa fa-check-square"></i></span></a>\
                                    <a class="button is-small is-size-7 is-danger" data-button="deceased" data-id="'+value.ID+'" title="Deceased"><span class="icon is-small is-left"><i class="fa fa-power-off"></i></span></a>\
                                </td>\
                            </tr>\
                            ');
                        })

                        $('nav.pagination').append('\
                            <a class="pagination-previous" page-offset="0">First</a>\
                            <a class="pagination-next">Last</a>\
                        ');

                        $(arrpage).each(function(index,value){
                            $('.pagination-list').append(
                                '<li>\
                                    <a class="pagination-link" page-offset="'+value+'" aria-label="Goto page '+(index+1)+'">'+(index+1)+'</a>\
                                </li>'
                            )
                        })
                        $('.pagination-next').attr("page-offset",arrpage[arrpage.length-1])

                        $('.pagination a[page-offset="'+offset+'"]').addClass("is-current")
                        $('.pagination a[page-offset="'+offset+'"]').attr("disabled",true)
                        $('.pagination a').on('click',function(){                
                            offset = $(this).attr("page-offset");
                            getData($(this).attr("page-offset"),limit,$('#namesearch').val(),$('#statusselect').val(),$('#brgyselect').val());
                        })
                        

                        $('tbody#memberlist tr').each(function(){
                            if($(this).attr("data-status")=='ACTIVE'){
                                $(this).addClass("has-background-primary");
                                $(this).addClass("has-text-white");
                                $(this).find('[data-button="activate"]').hide();
                                $(this).find('[data-button="deceased"]').show();
                            }else
                            {
                                $(this).find('[data-button="activate"]').show();
                                $(this).find('[data-button="deceased"]').hide();
                                $(this).addClass("has-background-danger");
                                $(this).addClass("has-text-white");
                            }
                        });



                        // PRINT button
                        $('[data-target="print"]').on('click',function(){
                            let json = JSON.stringify(data);
                            let jsonbase = window.btoa(json);
                            window.open('print.php?json='+jsonbase+"&brgy="+$('#brgyselect option:selected').text());

                        })
                        
                    }
                });
                }

                $('a[data-button="deceased"]').on('click',function(){
                    var $this = $(this);
                    $.ajax({
                        type: "get",
                        url: "<?php echo ROOT_URL; ?>/profile/set-activation.php?mode=deactivate&ID="+$(this).attr("data-id"),
                        success: function (response) {
                            $($this).closest('td').closest('tr').removeClass("has-background-primary");
                            $($this).closest('td').closest('tr').addClass("has-background-danger");

                            $($this).siblings('a').show();
                            $($this).hide();

                            bulmaToast.toast({
                                message: "Record "+response+".",
                                type: "is-success",
                                duration: 5000,
                                dismissible: false,
                                position: "bottom-right",
                                animate: { in: "fadeInRight", out: "fadeOutRight" }
                            });
                        }
                    });
                });

                $('a[data-button="activate"]').on('click',function(){
                    var $this = $(this);
                    $.ajax({
                        type: "get",
                        url: "<?php echo ROOT_URL; ?>/profile/set-activation.php?mode=activate&ID="+$(this).attr("data-id"),
                        success: function (response) {
                            $($this).closest('td').closest('tr').removeClass("has-background-danger");
                            $($this).closest('td').closest('tr').addClass("has-background-primary");

                            $($this).siblings('a').show();
                            $($this).hide();

                            bulmaToast.toast({
                                message: "Record "+response+".",
                                type: "is-success",
                                duration: 5000,
                                dismissible: false,
                                position: "bottom-right",
                                animate: { in: "fadeInRight", out: "fadeOutRight" }
                            });
                        }
                    });
                });

                // $('[data-trigger="search"]').on('click',function(){
                //     count = getCount(offset,limit,$('#namesearch').val(),$('#statusselect').val());
                //     getData(offset,limit,$('#namesearch').val(),$('#statusselect').val());
                // })
                $('a[data-unique="ID"]').on('click',function(){
                    // console.log($(this).attr("data-infoID"));
                    $.ajax({
                        type: "get",
                        url: "<?php echo ROOT_URL; ?>/profile/get-details.php?ID="+$(this).attr("data-infoID"),
                        success: function (response) {
                            var data = JSON.parse(response)[0];
                            console.clear();
                            console.table(data)
                            // $('[modal-toggle="name"]').text("Detailed Information")
                            $.each( data , function(k,v){
                                if($('[data-field="'+k+'"]').attr("data-field")!='name'){
                                    $('[data-field="'+k+'"]').text(v)
                                }
                            })
                            
                        }
                    });
                    $.ajax({
                        type: "get",
                        url: "<?php echo ROOT_URL; ?>/profile/get-composition.php?ID="+$(this).attr("data-infoID"),
                        success: function (response) {
                            var compo = JSON.parse(response);
                            console.table(compo);
                            $('tbody#membercomposition *').remove();
                            $.each(compo,function(i,v){
                                console.log(v)
                                $('tbody#membercomposition').append('\
                                    <tr>\
                                        <td>'+v.name+'</td>\
                                        <td>'+v.relationship+'</td>\
                                        <td>'+v.c_age+'</td>\
                                        <td>'+v.c_civil_status+'</td>\
                                        <td>'+v.c_occupation+'</td>\
                                        <td>'+v.c_income+'</td>\
                                    </tr>\
                                ');
                            })
                        }
                    });

                    $.ajax({
                        type: "get",
                        url: "<?php echo ROOT_URL; ?>/profile/get-image.php?ID="+$(this).attr("data-infoID"),
                        success: function (response) {
                            var photo = JSON.parse(response)[0];
                            $('[data-field="image"]').attr('src',photo.imgurl)
                        }
                    });

                    
                    $('[data-modal="viewdetail"]').addClass('is-active');
                })

            })
            $('[data-trigger="search"]').trigger('click')
        })
    </script>
</head>
<body>
    <?php include(ROOT_DIR."/header.php"); ?>
    
    <section class="hero is-medium is-primary is-bold">
        <div class="hero-body">
            <div class="container has-text-centered">
                <h1 class="title">
                Palauig Monitoring and Information System for Senior Citizen
                </h1>
                <h2 class="subtitle">
                    Members List
                </h2>
            </div>
        </div>
    </section>

    <div id="addform" class="container">   
    <div class="tile is-ancestor">
            <div class="tile is-1"></div>
            <div class="tile is-10 is-vertical">

                <div class="box addnew">
                        <h1 class="title has-text-centered">Members List</h1>
                        <div class="columns is-centered">
                            <div class="column is-6">
                                <div class="field is-horizontal">
                                    <div class="field-body">
                                        <div class="field">
                                            <label for="">Name:</label>
                                            <p class="control is-expanded has-icons-left">
                                                <input id="namesearch" class="input is-small" type="text" placeholder="Name">
                                                <span class="icon is-small is-left">
                                                <i class="fa fa-user"></i>
                                                </span>
                                            </p>
                                        </div>
                                        <div class="field">
                                            <label for="">Status:</label>
                                            <p class="control is-expanded has-icons-left">
                                                <div class="select is-small is-fullwidth">
                                                    <select id="statusselect">
                                                        <option value="all">ALL</option>
                                                        <option value="active">ACTIVE</option>
                                                        <option value="notactive">NOT ACTIVE</option>
                                                    </select>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="field">
                                            <label for="">Barangay:</label>
                                            <p class="control is-expanded has-icons-left">
                                                <div class="select is-small is-fullwidth">
                                                    <select id="brgyselect">
                                                        <option value="ALL">ALL</option>
                                                    </select>
                                                </div>
                                            </p>
                                        </div>
                                        <div class="field">
                                            <label for="">&nbsp;</label>
                                            <p class="control is-expanded has-icons-left">
                                                <button data-trigger="search" class="button is-small is-link">Search</button>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <table class="table is-hoverable is-fullwidth">
                            <thead>
                                <th></th>
                                <th>FullName</th>
                                <th>Date of Birth</th>
                                <th>Age</th>
                                <th>Gender</th>
                                <th>Civil Status</th>
                                <th>Educt'l Attainment</th>
                                <th>Occupation</th>
                                <th>Income</th>
                                <th>Skills</th>
                                <th><a href="#" data-target="print" class="button is-link"><span class="icon"><i class="fa fa-print"></i></span><span>Print</span></a></th>
                            </thead>
                            <tbody id="memberlist">
                            </tbody>
                        </table>
                        
                        <div class="paginate">
                            <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                                <a class="pagination-previous" page-offset="0">First</a>
                                <a class="pagination-next">Last</a>
                                <ul class="pagination-list">
                                
                                    
                                </ul>
                            </nav>
                        </div>
                </div>

            </div>
            <div class="tile is-1"></div>
        </div>
    </div>

    <div class="modal" data-modal="viewdetail">
        <div class="modal-background"></div>
        <div class="modal-card">
            <header class="modal-card-head">
            <p class="modal-card-title" modal-toggle="name"></p>
            <button class="delete" aria-label="close" onclick="$('[data-modal=\'viewdetail\']').removeClass('is-active')"></button>
            </header>
            <section class="modal-card-body" style="overflow-x: hidden;">
            <!-- Content ... -->
                <!-- Image -->
                <section class="hero is-primary">
                    <div class="hero-body">
                        <div class="container">
                        <h1 class="title">
                            Detailed Information
                        </h1>
                        <h2 class="subtitle">
                        <br><br>
                        </h2>
                        </div>
                    </div>
                </section>
                <div class="level" style="transform: translateY(-70px);">
                    <div class="level-item"></div>
                    <div class="level-item">
                        <figure class="image is-256x256 has-text-centered">
                            <img data-field="image" style="height: 128px;width: 128px;" class="is-rounded" src="https://bulma.io/images/placeholders/128x128.png">
                        </figure>
                    </div>
                    <div class="level-item"></div>
                </div>
                <div class="content" style="transform: translateY(-70px);">
                    <h2 class="has-text-centered"><strong>Primary Information</strong></h2>
                    
                    <table class="table is-fullwidth is-size-7">
                        <tr>
                            <td><strong>Name:</strong></td>
                            <td><span style="display: flex;"><p data-field="fname"></p>&nbsp;<p data-field="mname"></p>&nbsp;<p data-field="lname"></p></span></td>
                        </tr>
                        <tr>
                            <td><strong>Date Of Birth:</strong></td>
                            <td><p data-field="dob"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Age:</strong></td>
                            <td><p data-field="age"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Gender:</strong></td>
                            <td><p data-field="sex"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Civil Status:</strong></td>
                            <td><p data-field="civil_status"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Educational Attainment:</strong></td>
                            <td><p data-field="edu_attainment"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Occupation:</strong></td>
                            <td><p data-field="occupation"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Income:</strong></td>
                            <td><p data-field="income"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Skills:</strong></td>
                            <td><p data-field="skills"></p></td>
                        </tr>
                        <tr>
                            <td><strong>Barangay:</strong></td>
                            <td><p data-field="brgy"></p></td>
                        </tr>
                    </table>

                    <hr>
                    <h2 class="has-text-centered"><strong>Relationship Composition</strong></h2>

                    <table class="table is-fullwidth is-size-7">
                        <thead>
                            <th>Name</th>
                            <th>Relationship</th>
                            <th>Age</th>
                            <th>Civil Status</th>
                            <th>Occupation</th>
                            <th>Income</th>
                        </thead>
                        <tbody id="membercomposition">
                        </tbody>
                    </table>
                </div>
            </section>
            <footer class="modal-card-foot has-text-right">
                <button class="button is-dark">
                    <span class="icon is-small">
                        <i class="fa fa-print"></i>
                    </span>
                    <span>Print</span>
                </button>
                <!-- <button class="button">Close</button> -->
            </footer>
        </div>
    </div>
</body>
</html>