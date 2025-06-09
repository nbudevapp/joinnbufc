<?
session_start();
include "connection.php";
include "function.php";
savelog('');
$id = $_GET['id'];

// ข้อมูลการรับสมัคร
$sql = "select * from joinnbufc_event where joinnbufc_event_id = :joinnbufc_event_id";
$sth = $pdo->prepare($sql);
$sth->bindParam(':joinnbufc_event_id', $id, PDO::PARAM_INT);
$sth->execute();
foreach ($sth as $event);



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
    <div class="container">
        <div class="signup-content" style="color: #000;">
            <div style="text-align: center;"><img src="images/logo2.png" width="150"></div>
            <!-- <h2 class="form-title mt-2">ใบสมัครขอคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</h2> -->
            <h2 class="form-title mt-2">ใบสมัครเพื่อคัดเลือนักกีฬาฟุตบอลมหาวิทยาลัยนอร์ทกรุงเทพ</h2>

            <? if ($_GET['action'] == "duplicate") {
                echo "<h5 class='text-center mt-2 mb-5'>คุณเคยลงทะเบียนไปแล้ว<br>หากข้อมูลผิดพลาดหรือมีปัญหาในการลงทะเบียน<br>โปรดติดต่อ โทร. 085-936-5893, 094-617-8484</h5>";
            } else {
                if ($_GET['action'] == 'register') {
                    echo $event['joinnbufc_event_thankyoupage'];
                } else if ($_GET['action'] == 'register_round1') {

                    // ข้อมูลผู้สมัคร
                    $sql = "select * from joinnbufc_register
                            left join config on config.config_id = joinnbufc_register.joinnbufc_register_position1
                            where joinnbufc_register_line_uid = :joinnbufc_register_line_uid
                            and joinnbufc_event_id = :joinnbufc_event_id
                            ";
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array(
                        ':joinnbufc_register_line_uid' => $_SESSION["line_uid"],
                        ':joinnbufc_event_id' => $id
                    ));
                    $row = $sth->rowCount();
                    foreach ($sth as $register);
            ?>
                    <h5 class='text-center mt-4'>ลงทะเบียนคัดเลือกรอบที่ 1 เรียบร้อย</h5>
                    <div class="d-flex justify-content-center mt-3">
                        <table class="table table-primary mx-auto" style="max-width: 400px; border:1px solid #fff;">
                            <tr>
                                <td><b>รหัส</b></td>
                                <td><?= $register['joinnbufc_register_round1_code']; ?></td>
                            </tr>
                            <tr>
                                <td><b>ชื่อ</b></td>
                                <td><?= "$register[joinnbufc_register_name] $register[joinnbufc_register_surname]"; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <?= $event['joinnbufc_event_round1_thankyoupage']; ?>
                    </div>
                <? } else if ($_GET['action'] == 'register_round2') {

                    // ข้อมูลผู้สมัคร
                    $sql = "select * from joinnbufc_register
                            left join config on config.config_id = joinnbufc_register.joinnbufc_register_position1
                            where joinnbufc_register_line_uid = :joinnbufc_register_line_uid
                            and joinnbufc_event_id = :joinnbufc_event_id
                            ";
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array(
                        ':joinnbufc_register_line_uid' => $_SESSION["line_uid"],
                        ':joinnbufc_event_id' => $id
                    ));
                    $row = $sth->rowCount();
                    foreach ($sth as $register);
                ?>
                    <h5 class='text-center mt-4'>ลงทะเบียนคัดเลือกรอบที่ 2 เรียบร้อย</h5>
                    <div class="d-flex justify-content-center mt-3">
                        <table class="table table-primary mx-auto" style="max-width: 400px; border:1px solid #fff;">
                            <tr>
                                <td><b>รหัส</b></td>
                                <td><?= $register['joinnbufc_register_round2_code']; ?></td>
                            </tr>
                            <tr>
                                <td><b>ชื่อ</b></td>
                                <td><?= "$register[joinnbufc_register_name] $register[joinnbufc_register_surname]"; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div>
                        <?= $event['joinnbufc_event_round2_thankyoupage']; ?>
                    </div>
            <? }
            } ?>
        </div>
    </div>


</body>

</html>