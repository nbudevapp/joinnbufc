<?
// Intranet
$intranet_dbname = 'nbu_intranet';
$intranet_username = 'nbu_mydb';
$intranet_password = 'xkddkfe';
try {
    $pdo = new PDO("mysql:host=localhost;dbname=$intranet_dbname", $intranet_username, $intranet_password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(print_r($e->getMessage()));
}
$pdo->exec('set names utf8mb4');
date_default_timezone_set("Asia/Bangkok");

$liffid = '2001392922-Ry1xZwa3'; // Liff คัดเลือกนักฟุตบอล

$encodekey = 'ewfwerff##gdfIIK666';
