<?php
  $input = $_REQUEST["input"];
  $input_tis = iconv("UTF-8", "TIS-620", $input);
  $input_filename = tempnam("/tmp", "rom_in_");
  $output_filename = tempnam("/tmp", "rom_out_");
  $fw = fopen($input_filename, "w");
  fputs($fw, $input_tis);
  fclose($fw);
  system("cd /home/noom/TranscriptAndRomanize; cat $input_filename | ./romanize > $output_filename");
  $fr = fopen($output_filename, "r");
  $ans = Array();
  while ($s = fgets($fr, 1024)) {
    $t = iconv("TIS-620", "UTF-8", chop($s));
    array_push($ans, $t);
  }

  fclose($fr);

  //@unlink($input_filename);
  //@unlink($output_filename);
  echo json_encode($ans);
?>
