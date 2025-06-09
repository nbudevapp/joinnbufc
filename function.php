<?
function encode($string, $key)
{
	$j = '';
	$hash = '';
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);
	for ($i = 0; $i < $strLen; $i++) {
		$ordStr = ord(substr($string, $i, 1));
		if ($j == $keyLen) {
			$j = 0;
		}
		$ordKey = ord(substr($key, $j, 1));
		$j++;
		$hash .= strrev(base_convert(dechex($ordStr + $ordKey), 16, 36));
	}
	return $hash;
}

function decode($string, $key)
{
	$j = '';
	$hash = '';
	$key = sha1($key);
	$strLen = strlen($string);
	$keyLen = strlen($key);
	for ($i = 0; $i < $strLen; $i += 2) {
		$ordStr = hexdec(base_convert(strrev(substr($string, $i, 2)), 36, 16));
		if ($j == $keyLen) {
			$j = 0;
		}
		$ordKey = ord(substr($key, $j, 1));
		$j++;
		$hash .= chr($ordStr - $ordKey);
	}
	return $hash;
}
function savelog($detail)
{
	include "connection.php";
	$datetime = date("Y-m-d H:i:s");
	$sql = "insert into log set
			log_url = '$_SERVER[SERVER_NAME]$_SERVER[REQUEST_URI]',
			log_detail = '$detail',
			log_datetime = '$datetime',
			log_ip = '$_SERVER[REMOTE_ADDR]'"
			;
	$sth = $pdo->prepare($sql);
	$sth->execute();
}