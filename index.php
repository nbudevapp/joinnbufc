<?
include "connection.php";
include "function.php";
$datetime = date("Y-m-d H:i:s");
if ($_GET['id'] == '24e4') {
    $id = 18;
} else {
    $id = $_GET['id'];
}

savelog('');


// ข้อมูลการรับสมัคร
$sql = "select * from joinnbufc_event where joinnbufc_event_id = :joinnbufc_event_id";
$sth = $pdo->prepare($sql);
$sth->bindParam(':joinnbufc_event_id', $id, PDO::PARAM_INT);
$sth->execute();
$row = $sth->rowCount();
if ($row == 0) {
    echo "<META http-equiv='refresh' content='0;URL=  error.php?action=notevent&id=$id'> ";
    exit();
}
foreach ($sth as $event);
if ($datetime < $event['joinnbufc_event_ondate'] or $event['joinnbufc_event_ondate'] == '0000-00-00 00:00:00') {   // ยังไม่เปิด
    echo "<META http-equiv='refresh' content='0;URL=  error.php?action=beforstart'> ";
    exit();
} else if ($datetime > $event['joinnbufc_event_offdate']  or $event['joinnbufc_event_offdate'] == '0000-00-00 00:00:00') {   // หมดเขตแล้ว
    echo "<META http-equiv='refresh' content='0;URL=  error.php?action=afterstart'> ";
    exit();
}

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


    <script>
        $(document).ready(function() {
            $('#joinnbufc_register_entrance_y').click(function() {
                $("#joinnbufc_register_entrancewith").prop('disabled', false);
            });
            $('#joinnbufc_register_entrance_n').click(function() {
                $("#joinnbufc_register_entrancewith").prop('disabled', true);
                $("#joinnbufc_register_entrancewith").val('');
            });

            // ตั้งค่าตำแหน่งที่ 1
            $('#joinnbufc_register_position1').on('change', function() {
                if (($(this).attr('value') == $('#joinnbufc_register_position2').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position3').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position4').val()) &&
                    $(this).attr('value') != '') {
                    $("#joinnbufc_register_position1").val('');
                    alert("ตำแหน่งที่คุณเลือกซ้ำกับตำแหน่งที่คุณเลือกไว้แล้ว");
                }
            });

            // ตั้งค่าตำแหน่งที่ 2
            $('#joinnbufc_register_position2').on('change', function() {
                if ($('#joinnbufc_register_position1').val() == "") {
                    $("#joinnbufc_register_position2").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 1 ก่อน");
                } else if (($(this).attr('value') == $('#joinnbufc_register_position1').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position3').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position4').val()) &&
                    $(this).attr('value') != "") {
                    $("#joinnbufc_register_position2").val('');
                    alert("ตำแหน่งที่คุณเลือกซ้ำกับตำแหน่งที่คุณเลือกไว้แล้ว");
                }
            });

            // ตั้งค่าตำแหน่งที่ 3
            $('#joinnbufc_register_position3').on('change', function() {
                if ($('#joinnbufc_register_position1').val() == "") {
                    $("#joinnbufc_register_position3").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 1 ก่อน");
                } else if ($('#joinnbufc_register_position2').val() == "") {
                    $("#joinnbufc_register_position3").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 2 ก่อน");
                } else if (($(this).attr('value') == $('#joinnbufc_register_position1').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position2').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position4').val()) &&
                    $(this).attr('value') != "") {
                    $("#joinnbufc_register_position3").val('');
                    alert("ตำแหน่งที่คุณเลือกซ้ำกับตำแหน่งที่คุณเลือกไว้แล้ว");
                }
            });

            // ตั้งค่าตำแหน่งที่ 4
            $('#joinnbufc_register_position4').on('change', function() {
                if ($('#joinnbufc_register_position1').val() == "") {
                    $("#joinnbufc_register_position4").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 1 ก่อน");
                } else if ($('#joinnbufc_register_position2').val() == "") {
                    $("#joinnbufc_register_position4").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 2 ก่อน");
                } else if ($('#joinnbufc_register_position3').val() == "") {
                    $("#joinnbufc_register_position4").val('');
                    alert("กรุณาเลือกตำแหน่งอันดับ 3 ก่อน");
                } else if (($(this).attr('value') == $('#joinnbufc_register_position1').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position2').val() ||
                        $(this).attr('value') == $('#joinnbufc_register_position3').val()) &&
                    $(this).attr('value') != "") {
                    $("#joinnbufc_register_position4").val('');
                    alert("ตำแหน่งที่คุณเลือกซ้ำกับตำแหน่งที่คุณเลือกไว้แล้ว");
                }
            });



        });
    </script>

</head>

<body>

    <div class="container">
        <div class="signup-content">
            <form method="POST" action="manage.php" enctype="multipart/form-data">
                <div style="text-align: center;"><img src="images/logo2.png" width="150"></div>
                <!-- <h2 class="form-title mt-2">ใบสมัครขอคัดเลือกรับทุนนักกีฬาประเภทฟุตบอล</h2> -->
                <h2 class="form-title mt-2">ใบสมัครเพื่อคัดเลือนักกีฬาฟุตบอลมหาวิทยาลัยนอร์ทกรุงเทพ</h2>
                <h3 class="mt-5">ข้อมูลส่วนตัว</h3>

                <div class="row">
                    <div class="col-12 col-md-5 mt-3">
                        <label for="joinnbufc_register_name" class="form-label">ชื่อ <span class="text-danger"> *</span></label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text" id="student_name1">นาย</span>
                            </div>
                            <input type="text" class="form-control" id="joinnbufc_register_name" name="joinnbufc_register_name" required>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 mt-3">
                        <label for="joinnbufc_register_surname" class="form-label">นามสกุล <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_surname" name="joinnbufc_register_surname" required>
                    </div>
                    <div class="col-12 col-md-2 mt-3">
                        <label for="joinnbufc_register_surname" class="form-label">ชื่อเล่น <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_nickname" name="joinnbufc_register_nickname" required>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-2 mt-3">
                        <label for="birthdate" class="form-label">วันเกิด <span class="text-danger"> *</span></label>
                        <select class="form-select" required name="birthdate" name="birthdate">
                            <option value=""></option>
                            <? for ($i = 1; $i <= 31; $i++) { ?>
                                <option value="<?= $i; ?>"><?= $i; ?></option>
                            <? } ?>
                        </select>

                    </div>
                    <div class="col-12 col-md-2 mt-3">
                        <label for="birthmonth" class="form-label">เดือน <span class="text-danger"> *</span></label>
                        <select class="form-select" required name="birthmonth" id="birthmonth">
                            <option value=""></option>
                            <option value="01">มกราคม</option>
                            <option value="02">กุมภาพันธ์</option>
                            <option value="03">มีนาคม</option>
                            <option value="04">เมษายน</option>
                            <option value="05">พฤษภาคม</option>
                            <option value="06">มิถุนายน</option>
                            <option value="07">กรกฎาคม</option>
                            <option value="08">สิงหาคม</option>
                            <option value="09">กันยายน</option>
                            <option value="10">ตุลาคม</option>
                            <option value="11">พฤศจิกายน</option>
                            <option value="12">ธันวาคม</option>
                        </select>

                    </div>
                    <div class="col-12 col-md-2 mt-3">
                        <label for="birthyear" class="form-label">พ.ศ. <span class="text-danger"> *</span></label>
                        <select class="form-select" required name="birthyear" id="birthyear">
                            <option value=""></option>
                            <? for ($i = 2550; $i >= 2539; $i--) { ?>
                                <option value="<?= $i - 543; ?>"><?= $i; ?></option>
                            <? } ?>
                        </select>

                    </div>

                    <!--
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_birthday" class="form-label">วัน / เดือน / ปี เกิด</label>
                        <input type="date" min="1998-01-01" max="2005-12-31" class="form-control" id="joinnbufc_register_birthday" name="joinnbufc_register_birthday" required>

                    </div>
    -->
                    <div class="col-12 col-md-6 mt-3">
                        <label for="joinnbufc_register_citizen" class="form-label">เลขบัตรประชาชน <span class="text-danger"> *</span></label>
                        <input type="text" pattern="[0-9]{13}" class="form-control" id="joinnbufc_register_citizen" name="joinnbufc_register_citizen" required>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label for="joinnbufc_register_height" class="form-label">ส่วนสูง <span class="text-danger"> *</span></label>
                        <input type="number" min="150" max="250" class="form-control" id="joinnbufc_register_height" name="joinnbufc_register_height" required>
                    </div>
                    <div class="col-12 col-md-6 mt-3">
                        <label for="joinnbufc_register_weight" min="50" max="100" class="form-label">น้ำหนัก <span class="text-danger"> *</span></label>
                        <input type="number" class="form-control" id="joinnbufc_register_weight" name="joinnbufc_register_weight" required>
                    </div>
                </div>

                <h3 class="mt-5">ข้อมูลการติดต่อ</h3>

                <div class="row mt">
                    <div class="col-12 col-md-2 mt-3">
                        <label for="joinnbufc_register_address" class="form-label">เลขที่ <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_address" name="joinnbufc_register_address" required>

                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        <label for="joinnbufc_register_village" class="form-label">หมู่บ้าน</label>
                        <input type="text" class="form-control" id="joinnbufc_register_village" name="joinnbufc_register_village">
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_soi" class="form-label">ซอย</label>
                        <input type="text" class="form-control" id="joinnbufc_register_soi" name="joinnbufc_register_soi">
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_street" class="form-label">ถนน</label>
                        <input type="text" class="form-control" id="joinnbufc_register_street" name="joinnbufc_register_street">
                    </div>
                </div>
                <div class="row">

                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_tambol" class="form-label">ตำบล/แขวง <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_tambol" name="joinnbufc_register_tambol" required>
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_ampher" class="form-label">อำเภอ/เขต <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_ampher" name="joinnbufc_register_ampher" required>
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_province" class="form-label">จังหวัด <span class="text-danger"> *</span></label>
                        <select id="joinnbufc_register_province" name="joinnbufc_register_province" class="form-select" required>
                            <option value=""></option>
                            <? $sql = "select * from province order by province_name";
                            $sth = $pdo->prepare($sql);
                            $sth->execute();
                            foreach ($sth as $province) {
                            ?>
                                <option value="<?= $province['province_name']; ?>"><?= $province['province_name']; ?></option>
                            <? } ?>
                        </select>
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_zipcode" class="form-label">รหัสไปรษณีย์ <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_zipcode" name="joinnbufc_register_zipcode" required>
                    </div>
                </div>
                <div class="row">

                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_tel" class="form-label">เบอร์โทรศัพท์ <span class="text-danger"> *</span></label>
                        <input type="tel" class="form-control" id="joinnbufc_register_tel" name="joinnbufc_register_tel" required>
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_email" class="form-label">E-Mail</label>
                        <input type="email" class="form-control" id="joinnbufc_register_email" name="joinnbufc_register_email">

                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_line" class="form-label">ID Line (Option)</label>
                        <input type="text" class="form-control" id="joinnbufc_register_line" name="joinnbufc_register_line">
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_facebook" class="form-label">Facebook (Option)</label>
                        <input type="text" class="form-control" id="joinnbufc_register_facebook" name="joinnbufc_register_facebook">
                    </div>
                </div>

                
                <h3 class="mt-5">ข้อมูลผู้ปกครอง</h3>

                <div class="row">
                    <div class="col-12 col-md-2 mt-3">
                        <label for="joinnbufc_register_parent_prename" class="form-label">คำนำชื่อ <span class="text-danger"> *</span></label>
                        <select class="form-select" id="joinnbufc_register_parent_prename" name="joinnbufc_register_parent_prename" required>
                            <option selected></option>
                            <option value="นาย">นาย</option>
                            <option value="นาง">นาง</option>
                            <option value="นางสาว">นางสาว</option>
                        </select>

                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_parent_name" class="form-label">ชื่อ <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_parent_name" name="joinnbufc_register_parent_name" required>
                    </div>
                    <div class="col-12 col-md-3 mt-3">
                        <label for="joinnbufc_register_parent_surname" class="form-label">นามสกุล <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_parent_surname" name="joinnbufc_register_parent_surname" required>
                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        <label for="joinnbufc_register_parent_relationship" class="form-label">เกี่ยวข้องเป็น <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_parent_relationship" name="joinnbufc_register_parent_relationship" required>
                    </div>
                </div>


                <div class="row">
                    <div class="col-12 col-md-5 mt-3">
                        <label for="joinnbufc_register_parent_tel" class="form-label">เบอร์โทรศัพท์ติดต่อ <span class="text-danger"> *</span></label>
                        <input type="text" class="form-control" id="joinnbufc_register_parent_tel" name="joinnbufc_register_parent_tel" required>
                    </div>
                </div>


                <h3 class="mt-5">ข้อมูลการศึกษา</h3>

                <div class="row">
                    <div class="col-12 col-md-4 mt-3">
                        <label for="joinnbufc_register_degree" class="form-label">ระดับการศึกษา/กำลังศึกษาอยู่ <span class="text-danger"> *</span></label>
                        <select class="form-select" id="joinnbufc_register_degree" name="joinnbufc_register_degree" required>
                            <option selected></option>
                            <option value="ม.6">ม.6</option>
                            <option value="ปวช.3">ปวช.3</option>
                        </select>

                    </div>
                    <div class="col-12 col-md-4 mt-3" id="divschool">
                        <label for="email" class="form-label">โรงเรียน <span class="text-danger"> *</span></label>

                        <select name="joinnbufc_register_school" required class="form-control" id="openhouse_register_school">
                            <option value="">กรุณาเลือกระดับการศึกษาก่อน</option>

                        </select>

                    </div>
                    <div class="col-12 col-md-4 mt-3">
                        <label for="joinnbufc_register_gpa" class="form-label">เกรดเฉลี่ยสะสม <span class="text-danger"> *</span></label>
                        <input type="number" class="form-control" id="joinnbufc_register_gpa" name="joinnbufc_register_gpa" required step="0.01" min="0" max="4">
                    </div>

                </div>



                <h3 class="mt-5">ตำแหน่งที่ขอคัดเลือก เลือกตามลำดับความสนใจอย่างน้อย 1 ตำแหน่ง <span class="text-danger"> *</span></h3>
                <!-- <h3 class="mt-5">ตำแหน่งที่สมัคร</h3> -->

                <div class="row mt-3">
                    <div class="col-1 text-end">
                        <label for="joinnbufc_register_position1" class="form-label">1. </label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="joinnbufc_register_position1" name="joinnbufc_register_position1" required>
                            <option value="">เลือก</option>
                            <?
                            $sql = "select * from config where config_name = 'ตำแหน่งรับสมัครคัดเลือกฟุตบอล'";
                            // $sql = "select * from config where config_id in (70,76,77,78)";
                            $sth = $pdo->prepare($sql);
                            $sth->execute();
                            foreach ($sth as $result) {
                            ?>
                                <option value="<?= $result['config_id']; ?>"><?= $result['config_value']; ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-1 text-end">
                        <label for="joinnbufc_register_position2" class="form-label">2. </label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="joinnbufc_register_position2" name="joinnbufc_register_position2">
                            <option value="">เลือก</option>
                            <? $sql = "select * from config where config_name = 'ตำแหน่งรับสมัครคัดเลือกฟุตบอล'";
                            $sth = $pdo->prepare($sql);
                            $sth->execute();
                            foreach ($sth as $result) {
                            ?>
                                <option value="<?= $result['config_id']; ?>"><?= $result['config_value']; ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-1 text-end">
                        <label for="joinnbufc_register_position3" class="form-label">3. </label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="joinnbufc_register_position3" name="joinnbufc_register_position3">
                            <option value="">เลือก</option>
                            <? $sql = "select * from config where config_name = 'ตำแหน่งรับสมัครคัดเลือกฟุตบอล'";
                            $sth = $pdo->prepare($sql);
                            $sth->execute();
                            foreach ($sth as $result) {
                            ?>
                                <option value="<?= $result['config_id']; ?>"><?= $result['config_value']; ?></option>
                            <? } ?>

                        </select>
                    </div>
                </div>
                <div class="row mt-1">
                    <div class="col-1 text-end">
                        <label for="joinnbufc_register_position4" class="form-label">4. </label>
                    </div>
                    <div class="col-auto">
                        <select class="form-select" id="joinnbufc_register_position4" name="joinnbufc_register_position4">
                            <option value="">เลือก</option>
                            <? $sql = "select * from config where config_name = 'ตำแหน่งรับสมัครคัดเลือกฟุตบอล'";
                            $sth = $pdo->prepare($sql);
                            $sth->execute();
                            foreach ($sth as $result) {
                            ?>
                                <option value="<?= $result['config_id']; ?>"><?= $result['config_value']; ?></option>
                            <? } ?>
                        </select>
                    </div>
                </div>
 
                <!-- <h3 class="mt-5">ผลงาน</h3>

                <div class="row">
                    <div class="col">
                        <label for="joinnbufc_fileportfolio" class="form-label">อัพโหลดไฟล์ผลงาน (.doc, .docx, .pdf) <span class="text-danger"> *</span></label>
                        <input class="form-control" type="file" id="joinnbufc_fileportfolio" name="joinnbufc_fileportfolio" accept=".doc,.docx,.pdf" required>
                    </div>
                </div> -->

             <div class="row">
                    <div class="col mt-3">
                        <label for="joinnbufc_register_nationalteam" class="form-label">1. ทีมชาติไทย / เยาวชนทีมชาติไทย</label>
                        <textarea class="form-control" id="joinnbufc_register_nationalteam" name="joinnbufc_register_nationalteam" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-3">
                        <label for="joinnbufc_register_thailandcup" class="form-label">2. ชิงแชมป์ประเทศไทย</label>
                        <textarea class="form-control" id="joinnbufc_register_thailandcup" name="joinnbufc_register_thailandcup" rows="3"></textarea>
                    </div>
                </div>
                <div class="row">
                    <div class="col mt-3">
                        <label for="joinnbufc_register_othercup" class="form-label">3. รายการอื่นๆ</label>
                        <textarea class="form-control" id="joinnbufc_register_othercup" name="joinnbufc_register_othercup" rows="3"></textarea>
                    </div>
                </div> 

           
                <div class="row">
                    <div class="col-12 col-md-3 mt-3">การสมัครเข้าศึกษา <span class="text-danger"> *</span></div>
                </div>

                <div class="form-check">
                    <input class="form-check-input" type="radio" name="joinnbufc_register_entrance" id="joinnbufc_register_entrance_y" value="y" required>
                    <label class="form-check-label" for="joinnbufc_register_entrance_y">สมัครแล้ว</label>

                    <div class="row">
                        <div class="col">
                            <label for="joinnbufc_register_entrancewith" class="form-label">ชื่ออาจารย์ผู้รับสมัคร</label>
                            <select class="form-select" id="joinnbufc_register_entrancewith" name="joinnbufc_register_entrancewith" disabled="disabled" required>
                                <option selected></option>
                                <? $sql = "select * from joinnbufc_guide order by joinnbufc_guide_name";
                                $sth = $pdo->prepare($sql);
                                $sth->execute();
                                foreach ($sth as $guide) {
                                ?>
                                    <option value="<?= $guide['joinnbufc_guide_name']; ?>"><?= $guide['joinnbufc_guide_name']; ?></option>
                                <? } ?>
                            </select>


                        </div>
                    </div>
                </div>
                <div class="form-check mt-1">
                    <input class="form-check-input" type="radio" name="joinnbufc_register_entrance" id="joinnbufc_register_entrance_n" value="n" required>
                    <label class="form-check-label" for="joinnbufc_register_entrance_n">ยังไม่สมัครเรียน</label>
                </div>
          

                <div class="row mt-4">
                    <div class="col">
                        <input type="submit" name="submit" id="submit" class="form-submit" value="ส่งใบสมัคร" />
                        <input type="hidden" name="action" value="ส่งใบสมัคร">
                        <input type="hidden" name="joinnbufc_event_id" value="<?= $_GET['id']; ?>">
                    </div>
                </div>
            </form>
        </div>
    </div>

</body>

</html>


<script>
    // กดปุ่มระดับการศึกษา
    $("#joinnbufc_register_degree").change(function() {

        $.post("showschool2.php", {
                type: $("#joinnbufc_register_degree").val()
            },
            function(result) {
                $("#divschool").html(result);
            }
        );
    });
</script>