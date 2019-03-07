<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
require_once(ROOT_DIR.'/encryption.php');

$member = array();
if(isset($_GET['ID'])){
    $db = new DatabaseConnect();
    $db->query("SELECT m.*,i.imgurl as 'img' FROM tblmember m LEFT JOIN tblmemberimg i ON i.ID = m.ID  WHERE m.ID = ? LIMIT 1");
    $db->bind(1,$_GET['ID']);
    $member = $db->single();

    $db->query("SELECT * FROM tblbrgy");
    $brgy = $db->resultset();
}


if(isset($_POST['ID']) ){
    $db = new DatabaseConnect();
    $db->query("UPDATE `tblmember` SET `fname` = ?, `mname` = ?, `lname` = ?, `dob` = ?,`pob` = ?, `age` = ?, `sex` = ?, `civil_status` = ?, `edu_attainment` = ?, `occupation` = ?, `income` = ?, `skills` = ? , `brgyID` = ? WHERE ID = ? LIMIT 1");
    $db->bind(1,$_POST['fname']);
    $db->bind(2,$_POST['mname']);
    $db->bind(3,$_POST['lname']);
    $db->bind(4,$_POST['dob']);
    $db->bind(5,$_POST['pob']);
    $db->bind(6,$_POST['age']);
    $db->bind(7,$_POST['sex']);
    $db->bind(8,$_POST['status']);
    $db->bind(9,$_POST['educattain']);
    $db->bind(10,$_POST['occupation']);
    $db->bind(11,$_POST['income']);
    $db->bind(12,$_POST['skills']);
    $db->bind(13,$_POST['brgy']);
    $db->bind(14,$_POST['ID']);
    if($db->execute()){
        $id = $_POST['ID'];
        if(isset($_POST["blob"])){
            //upload  image file
            $target_dir = ROOT_DIR."/profile/photo/";
            $base_to_php = explode(',', $_POST['blob']);
            // the 2nd item in the base_to_php array contains the content of the image
            $data = base64_decode($base_to_php[1]);
            $filepath = ROOT_DIR."/profile/photo/".$_POST['ID'].".png"; // or image.jpg
        
            // Save the image in a defined path
            file_put_contents($filepath,$data);
           
            
            // die();
            header("Location:".ROOT_URL."/profile/member-update-2.php?ID=".$id);
            
        }
        else{
            header("Location:".ROOT_URL."/profile/member-update-2.php?ID=".$id);
        }
    }

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

            var calendar = bulmaCalendar.attach('[type="date"]', {
                startDate: moment().subtract(60,'years').format("YYYY-MM-DD"),
                showHeader:true,
                showFooter:false,
                overlay:true,
            });
            $('#dob').val(moment().subtract(60,'years').format("YYYY-MM-DD"));
            calendar.on('select',function(cal){
                console.log(cal.data.date.start)
                $('#dob').val(moment(cal.data.date.start).format("YYYY-MM-DD"));
                $('#age').attr('value',moment().diff(moment(cal.data.date.start).format("YYYY-MM-DD"), 'years'));
            })

            $('#age').attr('value',moment().diff($('#dob').val(), 'years'));

            $('#dob').on('change',function(){
                $('#age').attr('value',moment().diff($(this).val(), 'years'));
            })

            $('[name="file"]').on('change',function(){
                console.log($(this)[0].files[0])
                var reader = new FileReader();
                reader.readAsDataURL($(this)[0].files[0]);
                
                reader.onload = function(rEvent){
                    document.getElementById('preview').src = rEvent.target.result;
                }
            });

            $('.file').on('click',function(e){
                e.preventDefault();
                $('#savePhoto').hide();
                $('[data-modal="photo"]').addClass('is-active')

                var canvas = document.getElementById('canvas');
                var context = canvas.getContext('2d');
                var video = document.getElementById('video');
                context.clearRect(0, 0, 300, 325);

                // Get access to the camera!
                if(navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
                    // Not adding `{ audio: true }` since we only want video now
                    navigator.mediaDevices.getUserMedia({ video: true }).then(function(stream) {
                        //video.src = window.URL.createObjectURL(stream);
                        video.srcObject = stream;
                        video.play();

                        $('#snap').on('click',function(){
                            var canvas = document.getElementById('canvas');
                            var context = canvas.getContext('2d');
                            var video = document.getElementById('video');
                            context.drawImage(video, 0, 0, 300, 225);
                            var imgUrl = canvas.toDataURL("image/png");
                            $('#savePhoto').show();

                            $('#savePhoto').on('click',function(){
                                $('[data-entry="file"]').val(imgUrl);
                                stream.getTracks().forEach(track => track.stop())
                                $('[data-field="image"]').attr('src',imgUrl);
                                $('[data-modal="photo"]').removeClass('is-active')
                            });

                            
                        });
                        
                        $('[data-close="photo"]').on('click',function(){
                            stream.getTracks().forEach(track => track.stop())
                            
                        })

                    });
                }

                
                
            });
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
                    Update Member
                </h2>
                <div class="steps" id="stepsDemo">
                    <div class="step-item is-active is-success">
                        <div class="step-marker">1</div>
                        <div class="step-details">
                            <p class="step-title">Member Details</p>
                        </div>
                    </div>
                    <div class="step-item">
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
            <div class="tile is-3"></div>
            <div class="tile is-6 is-vertical">

                <div class="box addnew">
                        <h1 class="title has-text-centered">Membership Form</h1>
                        <form method="post" name="updateForm" enctype="multipart/form-data">
                        <input type="hidden" name="ID" value="<?php echo $_GET['ID']; ?>">
                        <div class="field">
                            <div class="level">
                                <div class="level-item">
                                    <figure class="image is-256x256 has-text-centered">
                                        <img data-field="image" id="preview" style="height: 128px;width: 128px;" src="<?php echo $member['img']; ?>">
                                    </figure>
                                </div>
                                <div class="level-item">
                                    <div class="file is-centered is-boxed is-primary has-name">
                                        <label class="file-label">
                                        <input type="hidden" name="blob" data-entry="file" >
                                        <input class="file-input" type="file" name="file">
                                            <span class="file-cta">
                                                <span class="file-icon">
                                                <i class="fa fa-user-circle"></i>
                                                </span>
                                                <span class="file-label">
                                                    Upload Member Image
                                                </span>
                                            </span>
                                        </label>
                                    </div>
                                </div>
                                <!-- <div class="level-item">
                                </div> -->
                            </div>
                            
                        </div>
                        <div class="columns">
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">First Name:</label>
                                    <input name="fname" class="input is-primary is-small" type="text" placeholder="First Name" value="<?php echo $member['fname']; ?>" required>
                                </div>
                            </div>
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">Middle Name:</label>
                                    <input name="mname" class="input is-primary is-small" type="text" placeholder="Middle Name" value="<?php echo $member['mname']; ?>" required>
                                </div>
                            </div>
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">Last Name:</label>
                                    <input name="lname" class="input is-primary is-small" type="text" placeholder="Last Name" value="<?php echo $member['lname']; ?>" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-6">
                                <div class="control">
                                    <label for="">Date of Birth:</label>
                                    <input name="dob" class="input is-primary dtp is-small" id="dob" type="date" placeholder="Date of Birth:" value="<?php echo $member['dob']; ?>" required>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Age:</label>
                                    <input name="age" class="input is-primary is-small" is-small type="number" id="age" min="0" max="150" placeholder="Age" value="<?php echo $member['age']; ?>" readonly>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Sex:</label>
                                    <div class="select is-primary is-fullwidth is-small" required>
                                        <select name="sex" value="<?php echo $member['sex']; ?>">
                                            <option value="Male">Male</option>
                                            <option value="Female">Female</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-9">
                                <div class="control">
                                    <label for="">Place of Birth:</label>
                                    <input class="input is-primary is-small" name="pob" id="pob" type="text" placeholder="Place of Birth:" value="<?php echo $member['pob']; ?>" required>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Civil Status:</label>
                                    <div class="select is-primary is-fullwidth is-small"  required>
                                        <select name="status" value="<?php echo $member['civil_status']; ?>">
                                            <option value="Single">Single</option>
                                            <option value="Married">Married</option>
                                            <option value="Married">Divorced</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12">
                                <div class="control">
                                    <label for="">Educational Attainment:</label>
                                    <div class="select is-primary is-fullwidth is-small">
                                        <select name="educattain" required value="<?php echo $member['edu_attainment']; ?>">
                                            <option value="Elementary Graduate">Elementary Graduate</option>
                                            <option value="High School Graduate">High School Graduate</option>
                                            <option value="College Graduate">College Graduate</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12 is-small">
                                <div class="control">
                                    <label for="">Occupation:</label>
                                    <input class="input is-primary dtp" name="occupation" id="occupation" value="<?php echo $member['occupation']; ?>" type="text" placeholder="Occupation">
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12 is-small">
                                <div class="control">
                                    <label for="">Income:</label>
                                    <input class="input is-primary dtp" name="income" id="income" type="number" min="0" value="<?php echo $member['income']; ?>" placeholder="Income" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12">
                                <div class="control">
                                    <label for="">Other Skills:</label>
                                    <input class="input is-primary is-small" name="skills" id="skills" type="text" placeholder="Other Skills" value="<?php echo $member['skills']; ?>" required>
                                </div>
                            </div>
                        </div>
                        <div class="columns">
                            <div class="field column is-12">
                                <div class="control">
                                    <label for="">Barangay:</label>
                                    <div class="select is-primary is-fullwidth is-small">
                                        <select name="brgy" required>
                                            <?php foreach($brgy as $b){ ?>
                                                <option value="<?php echo $b['brgyID']; ?>" <?php echo ($member['brgyID']==$b['brgyID'] ? 'selected="selected"' : 'ss') ?> > <?php echo $b['brgy']; ?></option>
                                            <?php } ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="columns">
                            <div class="column is-12 has-text-centered">
                                <button class="button is-primary">Submit</button>
                                <a href="<?php echo ROOT_URL; ?>/profile/member-update-2.php?ID=<?php echo $_GET['ID']; ?>" type="button" class="button is-link">Skip to Relationship Composition</a>
                            </div>
                        </div>

                        </form>
                        
                    </div>

            </div>
            <div class="tile is-3"></div>
        </div>
        
    </div>


    <div class="modal" data-modal="photo">
        <div class="modal-background"></div>
        <div class="modal-card is-6">
            <header class="modal-card-head">
            <p class="modal-card-title" modal-toggle="name"></p>
            <button data-close="photo" class="delete" aria-label="close" onclick="$('[data-modal=\'photo\']').removeClass('is-active')"></button>
            </header>
            <section class="modal-card-body">
            <!-- Content ... -->
                
                <div class="content" >
                    <h2 class="has-text-centered"><strong>Member Photo:</strong></h2>
                    <div class="columns">
                        <div class="column is-6 has-text-centered">
                            <p><video id="video" class="is-fullwidth video" id="video" autoplay width="300" height="300"></video></p>
                            <p><button id="snap" class="button is-primary">Capture</button></p></div>
                        <div class="column is-6 has-text-centered">
                            <canvas class="is-fullwidth" id="canvas" width="300" height="225"></canvas>
                            <button id="savePhoto" class="button is-link">Save</button>
                        </div>
                    </div>
                    
                </div> 
            </section>
        </div>
    </div>


</body>
</html>