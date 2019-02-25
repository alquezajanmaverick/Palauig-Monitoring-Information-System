<?php
require_once('../access.php');
require_once(ROOT_DIR.'/connector.php');
require_once(ROOT_DIR.'/encryption.php');
if(isset($_POST['fname']) && isset($_FILES["file"])){
    
    $db = new DatabaseConnect();
    $db->query("INSERT INTO `tblmember` (`fname`, `mname`, `lname`, `dob`,`pob`, `age`, `sex`, `civil_status`, `edu_attainment`, `occupation`, `income`, `skills`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)");
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
    if($db->execute()){
        $db->query("SELECT DISTINCT(LAST_INSERT_ID()) as `ID` FROM tblmember");
        $id = $db->single();

        $encryption = new Encryption();
        $db->query("INSERT INTO tblmembercredentials(ID,userID,password)VALUES(?,?,?)");
        $db->bind(1,$id['ID']);
        $db->bind(2,str_replace(' ', '', $_POST['fname'].$_POST['lname']));
        $db->bind(3,$encryption->generatePassword(8));
        $db->execute();

        $db->query("INSERT INTO tblmemberstatus(ID,`status`)VALUES(?,?)");
        $db->bind(1,$id['ID']);
        $db->bind(2,'ACTIVE');
        $db->execute();

        //upload  image file
        $target_dir = ROOT_DIR."/profile/photo";
        $target_file = $target_dir . basename($_FILES["file"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        // Check if image file is a actual image or fake image
        // print_r($_FILES["file"]);
        $check = getimagesize($_FILES["file"]["tmp_name"]);
        if($check) {
            if (file_exists($target_file)) {
                $uploadOk = 0;
            }else{
                $uploadOk = 1;
            }
            if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) { 
                $uploadOk = 0;
            }
        }
        if($uploadOk){
            $temp = explode(".", $_FILES["file"]["name"]);
            $newfilename = $id['ID'] . '.' . end($temp);
            // upload success
            if(move_uploaded_file($_FILES["file"]["tmp_name"], ROOT_DIR . '/profile/photo/' . $newfilename)){
                
                $db->query("INSERT into tblmemberimg(ID,imgurl)VALUES(?,?)");
                $db->bind(1,$id['ID']);
                $db->bind(2,ROOT_URL . '/profile/photo/' . $newfilename);
                $db->execute();
            };


            
            // die();
            header("Location:".ROOT_URL."/profile/member-add-2.php?ID=".$id['ID']);
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

            bulmaToast.toast({
                message: "Hello, <?php echo $_SESSION['fullname']; ?>",
                type: "is-primary",
                duration: 5000,
                dismissible: false,
                position: "bottom-right",
                animate: { in: "fadeInRight", out: "fadeOutRight" }
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
                    Add New Member
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
                        <form method="post" enctype="multipart/form-data">
                        <div class="field">
                            <div class="file is-centered is-boxed is-primary has-name">
                                <label class="file-label">
                                <input class="file-input" type="file" name="file" required>
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
                        <div class="columns">
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">First Name:</label>
                                    <input name="fname" class="input is-primary is-small" type="text" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">Middle Name:</label>
                                    <input name="mname" class="input is-primary is-small" type="text" placeholder="Middle Name" required>
                                </div>
                            </div>
                            <div class="field column is-4">
                                <div class="control">
                                    <label for="">Last Name:</label>
                                    <input name="lname" class="input is-primary is-small" type="text" placeholder="Last Name" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-6">
                                <div class="control">
                                    <label for="">Date of Birth:</label>
                                    <input name="dob" class="input is-primary dtp is-small" id="dob" type="date" placeholder="Date of Birth:" required>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Age:</label>
                                    <input name="age" class="input is-primary is-small" is-small type="number" id="age" min="0" max="150" placeholder="Age" readonly>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Sex:</label>
                                    <div class="select is-primary is-fullwidth is-small" required>
                                        <select name="sex">
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
                                    <input class="input is-primary is-small" name="pob" id="pob" type="text" placeholder="Place of Birth:" required>
                                </div>
                            </div>
                            <div class="field column is-3">
                                <div class="control">
                                    <label for="">Civil Status:</label>
                                    <div class="select is-primary is-fullwidth is-small" required>
                                        <select name="status">
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
                                        <select name="educattain" required>
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
                                    <input class="input is-primary dtp" name="occupation" id="occupation" type="text" placeholder="Occupation">
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12 is-small">
                                <div class="control">
                                    <label for="">Income:</label>
                                    <input class="input is-primary dtp" name="income" id="income" type="number" min="0" placeholder="Income" required>
                                </div>
                            </div>
                        </div>

                        <div class="columns">
                            <div class="field column is-12">
                                <div class="control">
                                    <label for="">Other Skills:</label>
                                    <input class="input is-primary dtp is-small" name="skills" id="pob" type="text" placeholder="Other Skills" required>
                                </div>
                            </div>
                        </div>
                        <br>
                        <div class="columns">
                            <div class="column is-12 has-text-centered">
                                <button class="button is-primary">Submit</button>
                            </div>
                        </div>

                        </form>
                        
                    </div>

            </div>
            <div class="tile is-3"></div>
        </div>
        
    </div>

</body>
</html>