<? session_start();
require_once "connection.php";
require_once "function.php";

$event = $_POST['event'];
$datetime = date("Y-m-d H:i:s");

// ตรวจสอบข้อมูลผู้สมัคร      
$sql = "select joinnbufc_register.*,
        joinnbufc_event.*,
        position1.config_value as position1,
        position1.config_value2 as position1_code,
        position2.config_value as position2,
        position3.config_value as position3,
        position4.config_value as position4,
        position_round1.config_value as position_round1,
        position_round1.config_value2 as position_round1_code
        from joinnbufc_register
        left join joinnbufc_event on joinnbufc_event.joinnbufc_event_id = joinnbufc_register.joinnbufc_event_id
        left join config as position1 on position1.config_id = joinnbufc_register.joinnbufc_register_position1
        left join config as position2 on position2.config_id = joinnbufc_register.joinnbufc_register_position2
        left join config as position3 on position3.config_id = joinnbufc_register.joinnbufc_register_position3
        left join config as position4 on position4.config_id = joinnbufc_register.joinnbufc_register_position4
        left join config as position_round1 on position_round1.config_id = joinnbufc_register.joinnbufc_register_round1_pass_position
        where joinnbufc_register.joinnbufc_event_id = :joinnbufc_event_id
        and joinnbufc_register_citizen = :joinnbufc_register_citizen
        ";
$sth = $pdo->prepare($sql);
$sth->execute(array(
    ':joinnbufc_event_id' => $event,
    ':joinnbufc_register_citizen' => $_POST['citizen']
));
$row = $sth->rowCount();
if ($row > 0) {
    //ถ้าเคยลงทะเบียน
    foreach ($sth as $result);
} else {
    // ถ้าไม่เคยลงทะเบียน
    echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notallow'> ";
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

    // รายงานตัว
    if ($result['joinnbufc_register_round1'] == 'y') {
        // ถ้าเคยรายงานตัว
        header("location: checkin_confirm.php?id=".$result['joinnbufc_register_id']."&round=1");
        exit();
    } else {
        // ถ้าไม่เคยรายงานตัว

        // รหัสล่าสุด
        $sql = "select max(joinnbufc_register_round1_sequence) as joinnbufc_register_round1_sequence
                from joinnbufc_register
                where joinnbufc_event_id = :joinnbufc_event_id
                and joinnbufc_register_position1 = '$result[joinnbufc_register_position1]'
                ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(':joinnbufc_event_id' => $event));
        foreach ($sth as $lastsequence);
        // อัพเดทสถานะการรายงานตัว
        $sql = "update joinnbufc_register set joinnbufc_register_round1 = 'y',
                joinnbufc_register_round1_datetime = :joinnbufc_register_round1_datetime,
                joinnbufc_register_round1_sequence = :joinnbufc_register_round1_sequence,
                joinnbufc_register_round1_code = :joinnbufc_register_round1_code
                where joinnbufc_register_id = '$result[joinnbufc_register_id]'
            ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(
            ':joinnbufc_register_round1_datetime' => date("Y-m-d H:i:s"),
            ':joinnbufc_register_round1_sequence' => $lastsequence['joinnbufc_register_round1_sequence'] + 1,
            ':joinnbufc_register_round1_code' => $result['position1_code'] . '1' . str_pad($lastsequence['joinnbufc_register_round1_sequence'] + 1, 3, '0', STR_PAD_LEFT)
        ));

        header("location: checkin_confirm.php?&id=".$result['joinnbufc_register_id']."&round=2");
        exit();
    }
}


// รอบที่ 2
if ($_POST['action'] == 'register_round2') {

    // ตรวจสอบวันรายงานตัว
    if ($datetime < $result['joinnbufc_event_round2_ondate'] or $result['joinnbufc_event_round2_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
        exit();
    } else if ($datetime > $result['joinnbufc_event_round2_offdate']  or $result['joinnbufc_event_round2_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
        exit();
    }

    // ตรวจสอบว่าผ่านรอบ 1 หรือไม่
    if ($result['joinnbufc_register_round1_pass'] == '') {
        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notallow'> ";
        exit();
    }

    // รายงานตัว
    if ($result['joinnbufc_register_round2'] == 'y') {
        // ถ้าเคยรายงานตัว
        header("location: checkin_confirm.php?&id=".$result['joinnbufc_register_id']);
        exit();
    } else {
        // ถ้าไม่เคยรายงานตัว

        // รหัสล่าสุด
        $sql = "select max(joinnbufc_register_round2_sequence) as joinnbufc_register_round2_sequence
                from joinnbufc_register
                where joinnbufc_event_id = :joinnbufc_event_id
                and joinnbufc_register_position1 = '$result[joinnbufc_register_position1]'
                ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(':joinnbufc_event_id' => $event));
        foreach ($sth as $lastsequence);
        // อัพเดทสถานะการรายงานตัว
        $sql = "update joinnbufc_register set joinnbufc_register_round2 = 'y',
                joinnbufc_register_round2_datetime = :joinnbufc_register_round2_datetime,
                joinnbufc_register_round2_sequence = :joinnbufc_register_round2_sequence,
                joinnbufc_register_round2_code = :joinnbufc_register_round2_code
                where joinnbufc_register_id = '$result[joinnbufc_register_id]'
            ";
        $sth = $pdo->prepare($sql);
        $sth->execute(array(
            ':joinnbufc_register_round2_datetime' => date("Y-m-d H:i:s"),
            ':joinnbufc_register_round2_sequence' => $lastsequence['joinnbufc_register_round2_sequence'] + 1,
            ':joinnbufc_register_round2_code' => $result['position_round1_code'] . '2' . str_pad($lastsequence['joinnbufc_register_round2_sequence'] + 1, 3, '0', STR_PAD_LEFT)
        ));

        header("location: checkin_confirm.php?&id=".$result['joinnbufc_register_id']);
        exit();
    }
}
