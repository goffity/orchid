<?php

function decode_unicode_url($str)
{
  $res = '';

  $i = 0;
  $max = strlen($str) - 6;
  while ($i <= $max)
  {
    $character = $str[$i];
    if ($character == '%' && $str[$i + 1] == 'u')
    {
      $value = hexdec(substr($str, $i + 2, 4));
      $i += 6;

      if ($value < 0x0080) // 1 byte: 0xxxxxxx
        $character = chr($value);
      else if ($value < 0x0800) // 2 bytes: 110xxxxx 10xxxxxx
        $character =
            chr((($value & 0x07c0) >> 6) | 0xc0)
          . chr(($value & 0x3f) | 0x80);
      else // 3 bytes: 1110xxxx 10xxxxxx 10xxxxxx
        $character =
            chr((($value & 0xf000) >> 12) | 0xe0)
          . chr((($value & 0x0fc0) >> 6) | 0x80)
          . chr(($value & 0x3f) | 0x80);
    }
    else
      $i++;

    $res .= $character;
  }

  return $res . substr($str, $i);
}

	# generating soundex configuration file
	$SOUNDEX_CONFIG = array( "soundex_type" => "1", 	// default 1
							 "default" 		=> "10",	// default 10
							 "trill_lateral" => "0",
							 "short_long"    => "0",
							 "kill_sound"	 => "0",
							 "tone_mark"	 => "0",
							 "insert_ar"	 => "0",
							 "delete_ar"	 => "0",
							 "prunning"		 => "1"
						   );

	# updating configuration

	# generating configuration file
	$conf = "";
	foreach ($SOUNDEX_CONFIG as $key => $value) {
		$conf .= $key . " " . $value . "\n";
	}
	$confp = fopen("/home/noom/usr/share/soundex/option.conf","w");
	fwrite($confp,$conf);
	fclose($confp);

	# calling soundex

	$word = iconv("utf-8","cp874",decode_unicode_url($_REQUEST['word']));
if($word=="") $word=$_GET['word'];
//echo "<br>xxx".$word;
	$result = array();
	$list = preg_split('/[\r\n\t ]+/',$word);
	foreach ($list as $w) {
		putenv("LD_LIBRARY_PATH=/home/noom/usr/lib:/usr/lib:/usr/local/lib");
		$command = "echo $w | /home/noom/usr/bin/soundex";
		$rlist   = preg_split('/\|/',`$command`);
		foreach ($rlist as $w2) {
			$result[$w2] = True;
		}
	}

	$res = "";
	foreach ($result as $w => $key) {
		$res .= $w . " ";
	}
	$res = trim($res);
	//echo $res;
	echo iconv("tis-620","utf-8",$res);

?>
