<?
session_start();
include "connection.php";
include "function.php";

if ($_POST['action'] == 'ส่งใบสมัคร') {
    function getAge($birthday)
    {
        $then = strtotime($birthday);
        return (floor((time() - $then) / 31556926));
    }

    // ตรวจสอบเลขบัตรซ้ำ
    $sql = "select count(joinnbufc_register_id) as a from joinnbufc_register
    where joinnbufc_register_citizen = :joinnbufc_register_citizen
    and joinnbufc_event_id = :joinnbufc_event_id
    ";
    $sth = $pdo->prepare($sql);
    $sth->execute(array(
        ':joinnbufc_register_citizen' => $_POST["joinnbufc_register_citizen"],
        ':joinnbufc_event_id' => $_POST["joinnbufc_event_id"]
    ));
    foreach ($sth as $checkduplicate);
    if ($checkduplicate['a'] >= 1) {
        echo "<META http-equiv='refresh' content='0;URL=  success.php?action=duplicate'> ";
        exit();
    }

    $datetime = date("Y-m-d H:i:s");

    // จังหวัดของโรงเรียน
    $sql = "select * from school where school_name = :school_name";
    $sth = $pdo->prepare($sql);
    $sth->execute(array(':school_name' => $_POST["joinnbufc_register_school"]));
    foreach ($sth as $school);

    // อัพโหลดไฟล์
    // $targetDir = "uploads/";
    // $originalFileName = basename($_FILES["joinnbufc_fileportfolio"]["name"]);
    // $fileType = strtolower(pathinfo($originalFileName, PATHINFO_EXTENSION));
    // $fileNameWithoutExt = pathinfo($originalFileName, PATHINFO_FILENAME);
    // $date = new DateTime();
    // $timestamp = $date->format('YmdHis');
    // $newFileName = $timestamp . '_' . $fileNameWithoutExt . '.' . $fileType;
    // $targetFilePath = $targetDir . $newFileName;
    // $allowedTypes = array('doc', 'docx', 'pdf');
    // if (in_array($fileType, $allowedTypes)) {
    //     if ($_FILES["joinnbufc_fileportfolio"]["error"] == 0) {
    //         if (move_uploaded_file($_FILES["joinnbufc_fileportfolio"]["tmp_name"], $targetFilePath)) {
    //         } else {
    //             echo "Sorry, there was an error uploading your file.";
    //             exit();
    //         }
    //     } else {
    //         echo "Sorry, there was an error uploading your file.";
    //         exit();
    //     }
    // } else {
    //     echo "Sorry, only DOC, DOCX, and PDF files are allowed.";
    //     exit();
    // }

    $sql = "insert into joinnbufc_register set
            joinnbufc_register_name = :joinnbufc_register_name,
            joinnbufc_register_surname = :joinnbufc_register_surname,
            joinnbufc_register_nickname = :joinnbufc_register_nickname,
            joinnbufc_register_birthday = :joinnbufc_register_birthday,
            joinnbufc_register_age = :joinnbufc_register_age,
            joinnbufc_register_height = :joinnbufc_register_height,
            joinnbufc_register_weight = :joinnbufc_register_weight,
            joinnbufc_register_address = :joinnbufc_register_address,
            joinnbufc_register_village = :joinnbufc_register_village,
            joinnbufc_register_soi = :joinnbufc_register_soi,
            joinnbufc_register_street = :joinnbufc_register_street,
            joinnbufc_register_tambol = :joinnbufc_register_tambol,
            joinnbufc_register_ampher = :joinnbufc_register_ampher,
            joinnbufc_register_province = :joinnbufc_register_province,
            joinnbufc_register_zipcode = :joinnbufc_register_zipcode,
            joinnbufc_register_tel = :joinnbufc_register_tel,
            joinnbufc_register_email = :joinnbufc_register_email,
            joinnbufc_register_line = :joinnbufc_register_line,
            joinnbufc_register_facebook = :joinnbufc_register_facebook,
            joinnbufc_register_school = :joinnbufc_register_school,
            joinnbufc_register_schoolprovince = :joinnbufc_register_schoolprovince,
            joinnbufc_register_gpa = :joinnbufc_register_gpa,
            joinnbufc_register_degree = :joinnbufc_register_degree,
            joinnbufc_register_parent_prename = :joinnbufc_register_parent_prename,
            joinnbufc_register_parent_name = :joinnbufc_register_parent_name,
            joinnbufc_register_parent_surname = :joinnbufc_register_parent_surname,
            joinnbufc_register_parent_relationship = :joinnbufc_register_parent_relationship,
            joinnbufc_register_parent_tel = :joinnbufc_register_parent_tel,
            joinnbufc_register_position1 = :joinnbufc_register_position1,
            joinnbufc_register_position2 = :joinnbufc_register_position2,
            joinnbufc_register_position3 = :joinnbufc_register_position3,
            joinnbufc_register_position4 = :joinnbufc_register_position4,
            joinnbufc_register_nationalteam = :joinnbufc_register_nationalteam,
            joinnbufc_register_thailandcup = :joinnbufc_register_thailandcup,
            joinnbufc_register_othercup = :joinnbufc_register_othercup,
            joinnbufc_register_entrance = :joinnbufc_register_entrance,
            joinnbufc_register_entrancewith = :joinnbufc_register_entrancewith,
            joinnbufc_register_datetime = :joinnbufc_register_datetime,
            joinnbufc_register_citizen = :joinnbufc_register_citizen,
            joinnbufc_event_id = :joinnbufc_event_id,
            joinnbufc_register_line_uid = :joinnbufc_register_line_uid,
            joinnbufc_fileportfolio = '$newFileName'
            ";
    $sth = $pdo->prepare($sql);
    $sth->execute(array(
        ':joinnbufc_register_name' => $_POST["joinnbufc_register_name"],
        ':joinnbufc_register_surname' => $_POST["joinnbufc_register_surname"],
        ':joinnbufc_register_nickname' => $_POST["joinnbufc_register_nickname"],
        ':joinnbufc_register_birthday' => $_POST["birthyear"] . "-" . $_POST["birthmonth"] . "-" . $_POST["birthdate"],
        ':joinnbufc_register_age' => getAge($_POST["birthyear"] . "-" . $_POST["birthmonth"] . "-" . $_POST["birthdate"]),
        ':joinnbufc_register_height' => $_POST["joinnbufc_register_height"],
        ':joinnbufc_register_weight' => $_POST["joinnbufc_register_weight"],
        ':joinnbufc_register_address' => $_POST["joinnbufc_register_address"],
        ':joinnbufc_register_village' => $_POST["joinnbufc_register_village"],
        ':joinnbufc_register_soi' => $_POST["joinnbufc_register_soi"],
        ':joinnbufc_register_street' => $_POST["joinnbufc_register_street"],
        ':joinnbufc_register_tambol' => $_POST["joinnbufc_register_tambol"],
        ':joinnbufc_register_ampher' => $_POST["joinnbufc_register_ampher"],
        ':joinnbufc_register_province' => $_POST["joinnbufc_register_province"],
        ':joinnbufc_register_zipcode' => $_POST["joinnbufc_register_zipcode"],
        ':joinnbufc_register_tel' => $_POST["joinnbufc_register_tel"],
        ':joinnbufc_register_email' => $_POST["joinnbufc_register_email"],
        ':joinnbufc_register_line' => $_POST["joinnbufc_register_line"],
        ':joinnbufc_register_facebook' => $_POST["joinnbufc_register_facebook"],
        ':joinnbufc_register_school' => $_POST["joinnbufc_register_school"],
        ':joinnbufc_register_schoolprovince' => $school["school_province"],
        ':joinnbufc_register_gpa' => $_POST["joinnbufc_register_gpa"],
        ':joinnbufc_register_degree' => $_POST["joinnbufc_register_degree"],
        ':joinnbufc_register_parent_prename' => $_POST["joinnbufc_register_parent_prename"],
        ':joinnbufc_register_parent_name' => $_POST["joinnbufc_register_parent_name"],
        ':joinnbufc_register_parent_surname' => $_POST["joinnbufc_register_parent_surname"],
        ':joinnbufc_register_parent_relationship' => $_POST["joinnbufc_register_parent_relationship"],
        ':joinnbufc_register_parent_tel' => $_POST["joinnbufc_register_parent_tel"],
        ':joinnbufc_register_position1' => $_POST["joinnbufc_register_position1"],
        ':joinnbufc_register_position2' => $_POST["joinnbufc_register_position2"],
        ':joinnbufc_register_position3' => $_POST["joinnbufc_register_position3"],
        ':joinnbufc_register_position4' => $_POST["joinnbufc_register_position4"],
        ':joinnbufc_register_nationalteam' => $_POST["joinnbufc_register_nationalteam"],
        ':joinnbufc_register_thailandcup' => $_POST["joinnbufc_register_thailandcup"],
        ':joinnbufc_register_othercup' => $_POST["joinnbufc_register_othercup"],
        ':joinnbufc_register_entrance' => $_POST["joinnbufc_register_entrance"],
        ':joinnbufc_register_entrancewith' => $_POST["joinnbufc_register_entrancewith"],
        ':joinnbufc_register_datetime' => $datetime,
        ':joinnbufc_register_citizen' => $_POST['joinnbufc_register_citizen'],
        ':joinnbufc_event_id' => $_POST['joinnbufc_event_id'],
        ':joinnbufc_register_line_uid' => $_SESSION["line_uid"]
    ));
    echo "<META http-equiv='refresh' content='0;URL=  success.php?action=register&id=$_POST[joinnbufc_event_id]'> ";
    exit();
}
