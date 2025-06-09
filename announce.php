<?
include "connection.php";
include "function.php";
$datetime = date("Y-m-d H:i:s");
$id = $_GET['id'];

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
        <div class="signup-content">
            <div style="text-align: center;"><img src="images/logo.png"></div>
            <h2 class="form-title mt-5">ประกาศผลคัดเลือกรับทุนนักกีฬาประเภทฟุตบอลรอบที่ <?= $_GET['round']; ?></h2>
            <div class="my-3 text-center">
                <? if ($_GET['round'] == 1) {
                    echo $event['joinnbufc_event_round1_announcetitle'];
                } else {
                    if ($_GET['round'] == 2) {
                        echo $event['joinnbufc_event_round2_announcetitle'];
                    }
                } ?>
            </div>
     
        <table class="table mt-4">
            <thead>
                <tr class="table-primary">
                    <th scope="col">#</th>
                    <th scope="col">Code</th>
                    <th scope="col">ชื่อ - นามสกุล</th>
                    <th scope="col">ตำแหน่ง</th>
                </tr>
            </thead>
            <tbody>
                <?
                if ($_GET['round'] == 1) {
                    $sql = "select joinnbufc_register_id,
                              joinnbufc_register_name,
                              joinnbufc_register_surname,
                              joinnbufc_register_round1_code as code,
                              position_pass.config_value as position
                              from joinnbufc_register
                              left join config as position_pass on position_pass.config_id = joinnbufc_register.joinnbufc_register_round1_pass_position
                              where joinnbufc_event_id = :joinnbufc_event_id
                              and joinnbufc_register_round1_pass = 'y'
                              order by config_id,code
                              ";
                } else {
                    if ($_GET['round'] == 2)
                        $sql = "select joinnbufc_register_id,
                              joinnbufc_register_name,
                              joinnbufc_register_surname,
                              joinnbufc_register_round2_code as code,
                              position_pass.config_value as position
                              from joinnbufc_register
                              left join config as position_pass on position_pass.config_id = joinnbufc_register.joinnbufc_register_round2_pass_position
                              where joinnbufc_event_id = :joinnbufc_event_id
                              and joinnbufc_register_round2_pass = 'y'
                              order by config_id,code
                              ";
                }
                $sth = $pdo->prepare($sql);
                $sth->bindParam(':joinnbufc_event_id', $id, PDO::PARAM_INT);
                $sth->execute();
                foreach ($sth as $result) {
                ?>
                    <tr>
                        <th scope="row"><?= ++$i; ?></th>
                        <td><?= $result['code']; ?></td>
                        <td><?= "$result[joinnbufc_register_name] $result[joinnbufc_register_surname]"; ?></td>
                        <td><?= $result['position']; ?></td>
                    </tr>
                <? } ?>
            </tbody>
        </table>
    </div>
    </div>

</body>

</html>