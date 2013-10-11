<?php

function strToHex($string)
{
    $hex='';
    for ($i=0; $i < strlen($string); $i++)
    {
        $hex .= dechex(ord($string[$i]));
    }
    return $hex;
}

function hexToStr($hex)
{
    $string='';
    for ($i=0; $i < strlen($hex)-1; $i+=2)
    {
        $string .= chr(hexdec($hex[$i].$hex[$i+1]));
    }
    return $string;
}

function computeUnsignedCRC32($str){
   sscanf(crc32($str), "%u", $var);
   $var = dechex($var + 0);
   return $var;
}
 
function dec_to_hex($dec)
{
    $sign = ""; // suppress errors
	$h = null;
    if( $dec < 0){ $sign = "-"; $dec = abs($dec); }

    $hex = Array( 0 => 0, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5,
                  6 => 6, 7 => 7, 8 => 8, 9 => 9, 10 => 'a',
                  11 => 'b', 12 => 'c', 13 => 'd', 14 => 'e',   
                  15 => 'f' );
       
    do
    {
        $h = $hex[($dec%16)] . $h;
        $dec /= 16;
    }
    while( $dec >= 1 );
   
    return $sign . $h;
} 

function get_checksum($cs)
{
    $var = computeUnsignedCRC32($cs);
	//echo "crchex: ".$var."<br/>";
	$x = ('0x');
	$a = substr($var, 0, 2);
	$a = $x.$a;
	$b = substr($var, 2, 2);
	$b = $x.$b;
	$c = substr($var, 4, 2);
	$c = $x.$c;
	$d = substr($var, 6, 2);
	$d = $x.$d;
	return chr($d).chr($c).chr($b).chr($a);
} 

function rcon($serverip,$serverport,$rconpassword,$cmd){
	$passhead = chr(0xFF).chr(0x00);
	$head = chr(0x42).chr(0x45);
	$pass = $passhead.$rconpassword;
	$answer = "";
	$checksum = get_checksum($pass);

	$loginmsg = $head.$checksum.$pass;

	$rcon = fsockopen("udp://".$serverip, $serverport, $errno, $errstr, 1);
	stream_set_timeout($rcon, 5);

	if (!$rcon) {
		echo "ERROR: $errno - $errstr<br />\n";
	} else {
		fwrite($rcon, $loginmsg);
		$res = fread($rcon, 16);
		
		$cmdhead = chr(0xFF).chr(0x01).chr(0x00);
		//$cmd = "Players";
		$cmd = $cmdhead.$cmd;
		$checksum = get_checksum($cmd);
		$cmdmsg = $head.$checksum.$cmd;
		$hlen = strlen($head.$checksum.chr(0xFF).chr(0x01));
		
		fwrite($rcon, $cmdmsg);
		$answer = fread($rcon, 102400);
		
		if ( strToHex(substr($answer, 9, 1)) == "0"){
			$count = strToHex(substr($answer, 10, 1));
			//echo $count."<br/>";
			for ($i = 0; $i < $count-1; $i++){
				$answer .= fread($rcon, 102400);
			}
		}
		//echo strToHex(substr($answer, 0, 16))."<br/>";
		//echo strToHex($answer)."<br/>";
		//echo $answer."<br/>";
		$cmd = "Exit";
		$cmd = $cmdhead.$cmd;
		$checksum = get_checksum($cmd);
		$cmdmsg = $head.$checksum.$cmd;
		fwrite($rcon, $cmdmsg);
	}

	return $answer;
}
?>
