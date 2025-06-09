<? session_start();
require_once "connection.php";
require_once "function.php";
savelog('');
$datetime = date("Y-m-d H:i:s");
$id = decode($_GET['id'], $encodekey);
$sql = "select * from joinnbufc_event where joinnbufc_event_id = :id";
$sth = $pdo->prepare($sql);
$sth->execute(array(':id' => $id));
foreach ($sth as $joinnbufc_event);

$accessToken = $_GET['accesstoken'];
$profile = "https://api.line.me/oauth2/v2.1/verify?access_token=" . $accessToken;
$responseData = json_decode($profile, true);
$curl = curl_init($profile);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
$response = curl_exec($curl);
if (curl_error($curl)) {
    $error = curl_error($curl);
    echo "cURL Error: " . $error;
}

curl_close($curl);
if ($response) {
    $responseData = json_decode($response, true);
    if (substr($liffid, 0, 10) == $responseData["client_id"]) {
        $url = "https://api.line.me/v2/profile";
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, [
            "Authorization: Bearer " . $accessToken
        ]);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

        $response = curl_exec($curl);
        if (curl_error($curl)) {
            $error = curl_error($curl);
            echo "cURL Error: " . $error;
        }
        curl_close($curl);
        if ($response) {
            $responseData = json_decode($response, true);
            if (isset($responseData['userId'])) {
                $_SESSION["line_uid"] = $responseData['userId'];
                $_SESSION["line_name"] = $responseData['displayName'];
                $_SESSION["line_photo"] = $responseData['pictureUrl'];

                // ถ้ามาจากลิงค์ลงทะเบียน
                if ($_GET['action'] == 'register') {
                    // ตรวจสอบว่าเคยลงทะเบียนหรือยัง
                    $sql = "select * from joinnbufc_register
                            where joinnbufc_event_id = :joinnbufc_event_id
                            and joinnbufc_register_line_uid = '$responseData[userId]'
                            ";

                    $sth = $pdo->prepare($sql);
                    $sth->execute(array(
                        ':joinnbufc_event_id' => $id
                    ));
                    $row = $sth->rowCount();
                    if ($row >= 1) {
                        header("location: success.php?action=register&id=$_GET[id]");
                        exit();
                    }
                    header("location: index.php?id=$_GET[id]");
                } else if ($_GET['action'] == 'register_round1') {
                    // รายงานตัวรอบที่ 1            
                    $sql = "select * from joinnbufc_register
                            left join config on config.config_id = joinnbufc_register.joinnbufc_register_position1
                            where joinnbufc_register_line_uid = :joinnbufc_register_line_uid
                            and joinnbufc_event_id = :joinnbufc_event_id
                            ";
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array(
                        ':joinnbufc_register_line_uid' => $responseData['userId'],
                        ':joinnbufc_event_id' => $id
                    ));
                    $row = $sth->rowCount();
                    foreach ($sth as $result);
                    if ($row > 0)    //ถ้าเคยลงทะเบียน
                    {
                        if ($result['joinnbufc_register_round1'] == 'y') {
                            // ถ้าเคยรายงานตัว
                            //header("location: success.php?action=register_round1&id=$_GET[id]");
                            header("location: checkin_confirm.php?id=".encode($result['joinnbufc_register_id'],$encodekey));
                            exit();
                        } else {
                            // ถ้าไม่เคยรายงานตัว

                            // ตรวจสอบวันรายงานตัว
                            if ($datetime < $joinnbufc_event['joinnbufc_event_round1_ondate'] or $joinnbufc_event['joinnbufc_event_round1_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
                                echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
                                exit();
                            } else if ($datetime > $joinnbufc_event['joinnbufc_event_round1_offdate']  or $joinnbufc_event['joinnbufc_event_round1_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
                                echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
                                exit();
                            }

                            // รหัสล่าสุด
                            $sql = "select max(joinnbufc_register_round1_sequence) as joinnbufc_register_round1_sequence
                                    from joinnbufc_register
                                    where joinnbufc_event_id = :joinnbufc_event_id
                                    and joinnbufc_register_position1 = '$result[joinnbufc_register_position1]'
                                    ";
                            $sth = $pdo->prepare($sql);
                            $sth->execute(array(':joinnbufc_event_id' => $id));
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
                                ':joinnbufc_register_round1_code' => $result['config_value2'].'1'.str_pad($lastsequence['joinnbufc_register_round1_sequence']+1, 3, '0', STR_PAD_LEFT)
                            ));



                            header("location: checkin_confirm.php?id=".encode($result['joinnbufc_register_id'],$encodekey));
                            //header("location: success.php?action=register_round1&id=$_GET[id]");
                            exit();
                        }
                    }
                } else if ($_GET['action'] == 'register_round2') {
                    // รายงานตัวรอบที่ 2            
                    $sql = "select * from joinnbufc_register
                            left join config on config.config_id = joinnbufc_register.joinnbufc_register_position1
                            where joinnbufc_register_line_uid = :joinnbufc_register_line_uid
                            and joinnbufc_event_id = :joinnbufc_event_id
                            and joinnbufc_register_round1_pass = 'y'
                            ";
                    $sth = $pdo->prepare($sql);
                    $sth->execute(array(
                        ':joinnbufc_register_line_uid' => $responseData['userId'],
                        ':joinnbufc_event_id' => $id
                    ));
                    $row = $sth->rowCount();
                    foreach ($sth as $result);
                    if ($row > 0)    //ถ้าเคยลงทะเบียน
                    {
                        if ($result['joinnbufc_register_round2'] == 'y') {
                            // ถ้าเคยรายงานตัว
                           // header("location: success.php?action=register_round2&id=$_GET[id]");
                           header("location: checkin_confirm.php?id=".encode($result['joinnbufc_register_id'],$encodekey));
                            exit();
                        } else {
                            // ถ้าไม่เคยรายงานตัว

                            // ตรวจสอบวันรายงานตัว
                            if ($datetime < $joinnbufc_event['joinnbufc_event_round2_ondate'] or $joinnbufc_event['joinnbufc_event_round2_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
                                echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
                                exit();
                            } else if ($datetime > $joinnbufc_event['joinnbufc_event_round2_offdate']  or $joinnbufc_event['joinnbufc_event_round2_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
                                echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
                                exit();
                            }

                            // รหัสล่าสุด
                            $sql = "select max(joinnbufc_register_round2_sequence) as joinnbufc_register_round2_sequence
                                    from joinnbufc_register
                                    where joinnbufc_event_id = :joinnbufc_event_id
                                    and joinnbufc_register_position1 = '$result[joinnbufc_register_position1]'
                                    ";
                            $sth = $pdo->prepare($sql);
                            $sth->execute(array(':joinnbufc_event_id' => $id));
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
                                ':joinnbufc_register_round2_code' => $result['config_value2'].'2'.str_pad($lastsequence['joinnbufc_register_round2_sequence']+1, 3, '0', STR_PAD_LEFT)
                            ));



                            header("location: checkin_confirm.php?id=".encode($result['joinnbufc_register_id'],$encodekey));
                           // header("location: success.php?action=register_round2&id=$_GET[id]");
                            exit();
                        }
                    } else {
                        echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notallow'> ";
                        exit();
                    }
                }
            } else {
                echo "Profile data not found.";
            }
        } else {
            echo "Empty response received.";
        }
    }
}
