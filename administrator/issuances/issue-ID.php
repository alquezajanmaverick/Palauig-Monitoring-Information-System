<?php
require_once('../access.php');
require_once('../connector.php');
if(isset($_GET['ID'])){
    $db = new DatabaseConnect();
    $db->query("SELECT * FROM memberview WHERE ID = ? LIMIT 1");
    $db->bind(1,$_GET['ID']);
    $data = $db->single();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ROOT_IMPORT; ?>/node_modules/font-awesome/css/font-awesome.css">
    <script src="<?php echo ROOT_IMPORT; ?>/node_modules/jquery/dist/jquery.min.js"></script>
    <title>Print ID</title>
    <style>
        *{
            font-family: 'Roboto', sans-serif;
        }
        table, .back-card{
            border:2px dashed #464545;
            padding:15px;
            width: 5in;
            height: 3.5in;
            box-sizing: border-box;
        }
        img{
            width: 70px;
        }
        th p {
            font-size:12px;
            margin: 0 auto;
        }
        .field{
            margin: 0 auto;
            text-align:right;
        }
        .underline{
            margin: 0 auto;
        }
        img.photo {
            border: 1px dashed #232323;
            width: 1in;
            height: 1in;
        }
        tr,td{
            /* border:1px solid black; */
        }
        .left{
            width: 50%;
            float: left;
        }
        .right{
            width: 50%;
            float: left;
        }
        .left p{
            margin: 0 auto;
            text-align:center;
        }
        .right p{
            margin: 0 auto;
            text-align:center;
        }
        p.note {
            font-size: 10px;
            color: red;
        }
        .signunderline {
            height: 30px;
            width: 80%;
            border-bottom: 2px solid #232323;
        }

    </style>
    <script>
        $(document).ready(function(){
            window.print();
            window.close();
        })
    </script>
</head>
<body>
    <table>
        <thead>
            <th>
                <img src="<?php echo ROOT_IMPORT; ?>/assets/dswd.png" alt="">
            </th>
            <th>
                <p>Republic of the Philippines</p>
                <p>OFFICE OF THE SENIOR CITIZENS AFFAIRS</p>
                <p>Palauig, Zambales</p>
            </th>
        </thead>
        <tbody>
            <tr>
                <td valign="top"><p class="field"><strong>Name:</strong></p></td>
                <td valign="top"><p class="underline"><?php echo $data['fname'].' '.$data['mname'].' '.$data['lname'] ?></p></td>
                <td rowspan="3">
                    <img class="photo" src="<?php echo $data['imgurl']; ?>" alt="">
                </td>
            </tr>
            <tr>
                <td valign="top"><p class="field"><strong>Address:</strong></p></td>
                <td valign="top"><p class="underline"><?php echo 'Barangay '.$data['brgy']; ?></p></td>
            </tr>
            <tr>
                <td align="right" valign="top" colspan="2" style="text-align: left;padding-left: 80px;"><p class="underline">Palauig, Zambales</p></td>
            </tr>
            <tr>
                <td colspan="3" valign="top">
                    <div class="left">
                        <p>
                            <?php echo $data['dob']; ?><br>
                            <strong>Date of Birth</strong>
                        </p>
                    </div>
                    <div class="right">
                        <p>
                            <?php echo $data['dob']; ?><br>
                            <strong>Date Issued</strong>
                        </p>
                    </div>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <p class="note">
                        THIS CARD IS NON-TRANSFERABLE AND<br>
                        VALID ANYWHERE IN THE COUNTRY
                    </p>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center">
                    <div class="signunderline"></div>
                </td>
            </tr>
            <tr>
                <td colspan="3" align="center" valign="top" style="font-size: 14px;">Printed Name and Signatured/Thumb Mark</td>
            </tr>
        </tbody>
    </table>
    <br>
    <br>
    <div class="back-card">
        <strong>
            <p style="font-size:13px;">
                BENEFITS under Republi Act No. 9257<br>
                Senior Citizens Act (Amending R.A. 7432)<br>
            </p>
            <p style="font-size:12px;">
                *Free medical/dental diagnostic & laboratory fees in all government facilities.<br>
                *20% discount in purchase of medicine.<br>
                *20% discount on theaters, cinema house and concert hall, etc.<br>
                *20% discount on medical & dental services, diagnostic & laboratory fees in private facilities.<br>
                *20% discount in fare for domestic air, sea travel and public land transportation.<br>
                *20% discount on funeral parlors and similars establishments.<br>
                *5% discount on basic necessities and prime commodities from groceries and supermarkets, but not more than P650/week.<br>
            </p>
            <p style="font-size:10px;text-align:center;">
                Only for the exclusive use of Senior Citizens:<br>
                abuse of privileges is punishable by law.
            </p>
            <p style="font-size:10px;text-align:center;">
                Person & Corporation violating RA9257 shall be penalized.
            </p>
        <br>
            <div style="display: inline-block;width: 100%;height: 50px;">
                <div class="left">
                    <p>LEONARDO A. APOYAN</p>
                    <p>OSCA HEAD</p>
                </div>
                <div class="right">
                    <p>HON. BILLY M. ACERON</p>
                    <p>MUNICIPAL MAYOR</p>
                </div>
            </div>
        </strong>
    </div>
</body>
</html>