<?
session_start();
include "connection.php";
include "function.php";
savelog('');
if ($_GET['liff_state']) {
    parse_str($_GET['liff_state'], $arr);
    // print_r($arr); 
    $id = $arr['?id'];
    $action = $arr['action'];
  } else {
    $id = $_GET['id'];
    $action = $_GET['action'];
  
  }
if ($id) {
    $_SESSION['parametors'] = "id=$id&action=$action";

}

$id = decode($_GET['id'], $encodekey);
$sql = "select * from joinnbufc_event where joinnbufc_event_id = :id";
$sth = $pdo->prepare($sql);
$sth->execute(array(':id' => $id));
foreach ($sth as $joinnbufc_event);
?>

<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ลงทะเบียน</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .swal2-popup {
            font-size: 20px;
        }
    </style>
</head>

<body>
    <script src="https://static.line-scdn.net/liff/edge/versions/2.15.0/sdk.js"></script>
    <script>
        function runApp() {
            liff.getProfile().then(profile => {
                accesstoken = liff.getAccessToken();
                window.location.replace("liff_data.php?<?= $_SESSION['parametors']; ?>&accesstoken=" + accesstoken);
            }).catch(err => console.error(err));
        }
        liff.init({
            liffId: "<?= $liffid; ?>"
        }, () => {
            if (liff.isLoggedIn()) {
                //runApp()
                liff.getFriendship().then(data => {
                    if (data.friendFlag) {
                        runApp()
                    } else {
                        <?
                        if ($joinnbufc_event['joinnbufc_event_force_add_friends'] == 'y') {
                        ?>
                            Swal.fire({
                                text: 'กรุณาเพิ่มเพื่อน และทำรายการใหม่อีกครั้ง',
                                icon: 'info',
                                confirmButtonText: 'OK',
                                allowOutsideClick: false
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    window.location.href = 'https://lin.ee/OIXGx2B';
                                }
                            });
                        <?
                        } else {
                            echo "runApp()";
                        }
                        ?>
                    }
                })
            } else {
                liff.login({
                    redirectUri: window.location.href
                });
            }
        }, err => console.error(err.code, error.message));
    </script>
</body>

</html>