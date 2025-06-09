<?
session_start();
include "connection.php";
include "function.php";
$id = $_GET['id'];
$datetime = date("Y-m-d H:i:s");

// ข้อมูลการรับสมัคร
$sql = "select * from joinnbufc_event where joinnbufc_event_id = :joinnbufc_event_id";
$sth = $pdo->prepare($sql);
$sth->bindParam(':joinnbufc_event_id', $id, PDO::PARAM_INT);
$sth->execute();
foreach ($sth as $joinnbufc_event);

if ($_GET['action'] == 'register_round1') { // รอบที่ 1
    if ($datetime < $joinnbufc_event['joinnbufc_event_round1_ondate'] or $joinnbufc_event['joinnbufc_event_round1_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
        exit();
    } else if ($datetime > $joinnbufc_event['joinnbufc_event_round1_offdate']  or $joinnbufc_event['joinnbufc_event_round1_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
        exit();
    }
} else if ($_GET['action'] == 'register_round2') { // รอบที่ 2
    if ($datetime < $joinnbufc_event['joinnbufc_event_round2_ondate'] or $joinnbufc_event['joinnbufc_event_round2_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
        exit();
    } else if ($datetime > $joinnbufc_event['joinnbufc_event_round2_offdate']  or $joinnbufc_event['joinnbufc_event_round2_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
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
            <h2 class="form-title mt-5 mb-3">รายงานตัวคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</h2>
            <form action="checkin_process.php" method="POST" class="py-5">
                <div class="text-center">
                    กรุณากรอกหมายเลขบัตรประชาชน เพื่อรายงานตัว
                    <input type="text" id="citizen" name="citizen" class="form-control mt-3" required minlength="13" maxlength="13">
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-3">ตกลง</button>
                    <input type="hidden" name="event" value="<?= $_GET['id']; ?>">
                    <input type="hidden" name="action" value="<?= $_GET['action']; ?>">
                </div>
            </form>
        </div>
    </div>


</body>

</html>
