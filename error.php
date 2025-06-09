<?
session_start();
include "function.php";
savelog('');
?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>ใบสมัครขอคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <!-- Main css -->
    <link rel="stylesheet" href="style.css">

</head>

<body>

    <div class="container bg-white mb-4">
        <div class="row ">
            <div class="col p-4">
            <div style="text-align: center;"><img src="images/logo.png"></div>
                    <h2 class="form-title mt-5">ใบสมัครขอคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</h2>
            </div>
        </div>
        <div class="row">
            <div class="col text-center" style="margin-top:200px; margin-bottom:200px;">
                <h4>
                    <? if ($_GET['action'] == 'beforstart') {
                        echo "ขออภัย ขณะนี้ยังไม่เปิดรับลงทะเบียน";
                    } ?>
                    <? if ($_GET['action'] == 'afterstart') {
                        echo "ขออภัย ขณะนี้ปิดรับลงทะเบียนแล้ว";
                    } ?>
                    <? if ($_GET['action'] == 'notevent') {
                        echo "ขออภัย ลิงก์นี้ไม่มีอยู่หรือถูกลบไปแล้ว";
                    } ?>
                    <? if ($_GET['action'] == 'timeout') {
                        echo "Timeout<br>อาจเกิดจากคุณเปิดหน้าจอทิ้งไว้ในเกินไป<br>กรุณากดลิงก์สมัครอีกครั้ง";
                    } ?>
                    <? if ($_GET['action'] == 'notallow') {
                        echo "ขออภัย คุณไม่มีรายชื่อรายงานตั";
                    } ?>
                </h4>
            </div>
        </div>
    </div>



</body>

</html>
