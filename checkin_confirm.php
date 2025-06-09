<?
session_start();
include "connection.php";
include "function.php";
$event = $_POST['event'];
$datetime = date("Y-m-d H:i:s");
$id = $_GET['id'];
// ตรวจสอบข้อมูลผู้สมัคร      
$sql = "select joinnbufc_register.*,
joinnbufc_event.*,
position1.config_value as position1,
position2.config_value as position2,
position3.config_value as position3,
position4.config_value as position4,
position_round1.config_value as position_round1,
position_round2.config_value as position_round2
from joinnbufc_register
left join joinnbufc_event on joinnbufc_event.joinnbufc_event_id = joinnbufc_register.joinnbufc_event_id
left join config as position1 on position1.config_id = joinnbufc_register.joinnbufc_register_position1
left join config as position2 on position2.config_id = joinnbufc_register.joinnbufc_register_position2
left join config as position3 on position3.config_id = joinnbufc_register.joinnbufc_register_position3
left join config as position4 on position4.config_id = joinnbufc_register.joinnbufc_register_position4
left join config as position_round1 on position_round1.config_id = joinnbufc_register.joinnbufc_register_round1_pass_position
left join config as position_round2 on position_round2.config_id = joinnbufc_register.joinnbufc_register_round1_pass_position
where joinnbufc_register.joinnbufc_register_id = $id";
$sth = $pdo->prepare($sql);
$sth->execute();
$row = $sth->rowCount();
if ($row > 0) {
    //ถ้าเคยลงทะเบียน
    foreach ($sth as $result);
} else {
    // ถ้าไม่เคยลงทะเบียน
  //  echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notallow'> ";
    exit();
}




// รอบที่ 1
if ($_POST['action'] == 'register_round1') {

    // ตรวจสอบวันรายงานตัว
    if ($datetime < $result['joinnbufc_event_round1_ondate'] or $result['joinnbufc_event_round1_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
        exit();
    } else if ($datetime > $result['joinnbufc_event_round1_offdate']  or $result['joinnbufc_event_round1_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
        exit();
    }
}


// รอบที่ 2
if ($_POST['action'] == 'register_round2') {

    // ตรวจสอบวันรายงานตัว
    if ($datetime < $result['joinnbufc_event_round1_ondate'] or $result['joinnbufc_event_round1_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
        exit();
    } else if ($datetime > $result['joinnbufc_event_round1_offdate']  or $result['joinnbufc_event_round1_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
        exit();
    }

    // ตรวจสอบว่าผ่านรอบ 1 หรือไม่
    if ($result['joinnbufc_register_round1_pass'] == '') {
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notallow'> ";
        exit();
    }
}



?>
<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>รายงานตัวคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</title>


    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/jquery.min.js"></script>
    <!-- Main css -->
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <div class="container">
        <div class="signup-content">
            <div style="text-align: center;"><img src="images/logo.png"></div>
            <h2 class="form-title mt-5 mb-5">รายงานตัวคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</h2>

            <h3 class="text-success text-center">คุณรายงานตัวเข้ารับการคัดเลือกเรียบร้อยแล้ว</h3>
            <table class="table table-primary mx-auto mt-5" style="max-width: 500px; border:1px solid #fff;">
                <tr>
                    <td><b>ชื่อ</b></td>
                    <td><?= "$result[joinnbufc_register_name] $result[joinnbufc_register_surname]"; ?></td>
                </tr>
                <tr>
                    <td><b>หมายเลขโทรศัพท์</b></td>
                    <td><?= "$result[joinnbufc_register_tel]"; ?></td>
                </tr>

                <? if($result['joinnbufc_register_round1_code']!=''){?>
                <tr>
                    <td><b>รหัส รอบที่ 1</b></td>
                    <td><?= "$result[joinnbufc_register_round1_code]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['joinnbufc_register_round2_code']!=''){?>
                <tr>
                    <td><b>รหัส รอบที่ 2</b></td>
                    <td><?= "$result[joinnbufc_register_round2_code]"; ?></td>
                </tr>
                <? } ?>

                <? if($result['position1']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่สมัครลำดับที่ 1</b></td>
                    <td><?= "$result[position1]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['position2']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่สมัครลำดับที่ 2</b></td>
                    <td><?= "$result[position2]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['position3']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่สมัครลำดับที่ 3</b></td>
                    <td><?= "$result[position3]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['position4']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่สมัครลำดับที่ 4</b></td>
                    <td><?= "$result[position4]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['position_round1']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่ผ่านคัดเลือกรอบที่ 1</b></td>
                    <td><?= "$result[position_round1]"; ?></td>
                </tr>
                <? } ?>
                <? if($result['position_round1']!=''){?>
                <tr>
                    <td><b>ตำแหน่งที่ผ่านคัดเลือกรอบที่ 2</b></td>
                    <td><?= "$result[position_round2]"; ?></td>
                </tr>
                <? } ?>
            </table>
            <?
            if($_GET['round']==1)
            {
                echo "<div>$result[joinnbufc_event_round1_thankyoupage]</div>";
            } else if($_GET['round']==2)
            {
                echo "<div>$result[joinnbufc_event_round2_thankyoupage]</div>";
            }
            ?>
        </div>
    </div>


</body>

</html>