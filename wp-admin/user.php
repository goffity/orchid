<?php
/**
#
# How to Check Username Availability using jQuery + PHP
# Author  hairul azami a.k.a dr.emi <webmaster@dremi.info>
# Web development and design service => info@dremi.net
# Website http://dremi.info http://dremi.net
# License: GPL
# File: form.php
#
**/

define("_HOST", 	"localhost:3307");
define("_USER", 	"root");
define("_PASS", 	"root");
//define("_PASS", 	"123456");
define("_DB", 		"wordpress2");

$nameTH	= $_REQUEST['nameTH'];
$msg		= $_REQUEST['msg'];

$nameEN	= $_REQUEST['nameEN'];
$msg2		= $_REQUEST['msg2'];


//connect to database
function connect($host, $user, $pass, $dbase)
{
	$con = mysql_connect($host, $user, $pass);
	if($con)
	{
		mysql_select_db($dbase) or die("could'nt select database");
	}
	else
	{
		die("couldn't connect to host. ".mysql_error()."");
	}
}

function close()
{
	return mysql_close();
}

//query
function query($sql)
{
	$qry = mysql_query($sql);
	return $qry;
}

//counter rows
function numrows($qry)
{
	$num = mysql_num_rows($qry);
	return $num;
}
	
//rows data
function fetch($qry)
{
	if($row = mysql_fetch_array($qry))
	{
		return $row;
	}
	else 
	{
		echo mysql_error();
	}
}

function clearString($value)
{
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	if (!is_numeric($value))
	{
		$value = mysql_real_escape_string($value);
	}
	$value = trim(strip_tags($value));
	return $value;
}

function validStr($str, $num_chars, $behave) //alpha numeric only for entire of string width
{
	if($behave=="min")
	{
		$pattern="^[0-9a-zA-Z]{".$num_chars.",}$";
	}
	elseif($behave=="max")
	{
		$pattern="^[0-9a-zA-Z]{0,".$num_chars."}$";
	}
	elseif($behave=="exactly")
	{
		$pattern="^[0-9a-zA-Z]{".$num_chars.",".$num_chars."}$";
	}
	
	if(ereg($pattern,$str))
	{
		return true;
	}
	else
	{
		return false;
	}
}

function validEmail($email)
{
	$pattern = "^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$";
	if(@eregi($pattern, $email)) return true;
	else  return false;
}	



if(isset($nameTH) && $nameTH != '')
{
	//if(validStr($nameTH, 4, 'min') == false)
	//{
	//}
	//else 
	//{
		connect(_HOST, _USER, _PASS, _DB);
		$jCekMember = numrows(query("SELECT * FROM orchid_varity WHERE orchid_name_th = '".clearString($nameTH)."'"));
		
		if($jCekMember > 0)
		{
			?>
			<span style="color:red"><?php echo $nameTH; ?> ไม่สามารถใช้ชื่อนี้ได้เนืองจากมีในระบบแล้ว.</span>
			<?php
		}
		else 
		{
			?>
			<span style="color:green"><?php echo $nameTH; ?> สามารถใช้ชื่อนี้ได้.</span>
			<?php
		}
		close();
	//}
}

else if($msg == 'whitespace')
{
	?>
	<span style="color:red">name cannot contain of white space</span>
    <?php
}
else if($nameTH =="")
{
	$msg = "กรุณาพิมพ์ชื่อภาษาไทย";
	?>
	<span style="color:red"><?php echo $msg;?></span>
    <?php
}

else if(isset($nameEN) && $nameEN != '')
{
	//if(validStr($nameTH, 4, 'min') == false)
	//{
	//}
	//else 
	//{
		//echo "SELECT * FROM orchid_varity WHERE orchid_name_en LIKE '".clearString($nameEN)."'";
		
		connect(_HOST, _USER, _PASS, _DB);
		$jCekMember = numrows(query("SELECT * FROM orchid_varity WHERE ochid_name_eng = '".clearString($nameEN)."'"));
		if($jCekMember != 0)
		{
			?>
			<span style="color:red"><?php echo $nameEN; ?> ไม่สามารถใช้ชื่อนี้ได้เนืองจากมีในระบบแล้ว.</span>
			<?php
		}
		else 
		{
			?>
			<span style="color:green"><?php echo $nameEN; ?> สามารถใช้ชื่อนี้ได้.</span>
			<?php
		}
		close();
	//}
}


?>