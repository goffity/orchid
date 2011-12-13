<?php
// +-----------------------------------------------------------------------+
// | Copyright (c) 2002-2005, Richard Heyes, Harald Radi                   |
// | All rights reserved.                                                  |
// |                                                                       |
// | Redistribution and use in source and binary forms, with or without    |
// | modification, are permitted provided that the following conditions    |
// | are met:                                                              |
// |                                                                       |
// | o Redistributions of source code must retain the above copyright      |
// |   notice, this list of conditions and the following disclaimer.       |
// | o Redistributions in binary form must reproduce the above copyright   |
// |   notice, this list of conditions and the following disclaimer in the |
// |   documentation and/or other materials provided with the distribution.| 
// | o The names of the authors may not be used to endorse or promote      |
// |   products derived from this software without specific prior written  |
// |   permission.                                                         |
// |                                                                       |
// | THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS   |
// | "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT     |
// | LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR |
// | A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT  |
// | OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, |
// | SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT      |
// | LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, |
// | DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY |
// | THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT   |
// | (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE |
// | OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.  |
// |                                                                       |
// +-----------------------------------------------------------------------+
// | Author: Richard Heyes <http://www.phpguru.org/>                       |
// |         Harald Radi <harald.radi@nme.at>                              |
// +-----------------------------------------------------------------------+
//
// $Id: example.php,v 1.14 2005/03/02 02:16:51 richard Exp $
//error_reporting(E_ALL | E_STRICT);
    //require_once('HTML/TreeMenu.php');
if($_GET['query1']!="")
    $qterm=$_GET['query1'];
else
    $qterm=$_GET['qterm'];
require_once('TreeMenu.php');
function fehler() {
/* *************************** */
global $HTTP_SERVER_VARS, $db_mailto_error, $qs;

    if (mysql_errno()>0) {
            $error1=mysql_errno();
            $error2=mysql_error();
            echo "<font size=+2 color=red><b>Database Error!</b> $error1: $error2 - $qs<BR>";
            $err_msg = "WARNING: Check log file if suspected recurrent error!\n\n";
            $err_msg .= "PHPTREE\n";
            $err_msg .= "Error Occured @:\n";
            $err_msg .= date ("D M j, Y h:i:s A") . "\n\n";
            $err_msg .= "MySQL ErrNo: $error1\n";
            $err_msg .= "MySQL ErrMsg: $error2\n\n";
            $err_msg .= "Website: ".$HTTP_SERVER_VARS['HTTP_HOST']."\n";
            $err_msg .= "Query-String: ".$HTTP_SERVER_VARS['REQUEST_URI']."\n";
            $err_msg .= "Remote IP Access from: ".$HTTP_SERVER_VARS['REMOTE_ADDR']."\n";

            mail($db_mailto_error,"[mySQL] Error on ".$HTTP_SERVER_VARS['HTTP_HOST']." /phptree ",$err_msg);

            exit; break; stop;
    };

} /* end of function fehler() */



/* ---------------------------------- */
/* Change the following settings !    */
/* ---------------------------------- */
/*
// database-server ...
$db_host = "localhost";

// database username
$db_user = "root";

// Database name
$db = "treemenu";

// password to connect with to the database-server
$db_pwd = "onmodao";
*/
// database table name we are working on ... if you don't have it setup already, doit now!
// definition of the table is shown in the documentation of the php_tree.class itself
//$table = "meshterm";        /* database table working on */
//$table = "php_tree";        /* database table working on */

include"commond.php";

mysql_connect($db_host,$db_user,$db_pwd);
mysql_select_db($db);

    $icon         = 'folder.gif';
    $expandedIcon = 'folder-expanded.gif';
    
$menu  = new HTML_TreeMenu();

function gentree2($node,$branches) {
if ($branches!="")
    $qs="SELECT * FROM    meshterm  WHERE     parent=".$branches." or ident=".$branches." ORDER BY ident";
else
    $qs="SELECT * FROM   meshterm  WHERE     parent='-1' ORDER BY ident";

        $rc=mysql_query($qs);
        $num=mysql_numrows($rc);
         
    $i=0;
    while($ar = mysql_fetch_array($rc)){
    
       if($i==0  ) { 
         //$node1   = new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?query1=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
		 $node1   = new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?advanced=true&query1=".$ar['term']."&term=".$ar['term']."&Query1=".$ar['term']."&fulltext=".$ar['term']."&SearchString=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
        }else{
             if ( $ar['haschild']=="1" ) {
                $node1->addItem(gentree2("node",$ar['ident']));
             }else{
                //$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?query1=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
				$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?advanced=true&query1=".$ar['term']."&term=".$ar['term']."&Query1=".$ar['term']."&fulltext=".$ar['term']."&SearchString=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
             }
        }
         
        
         $i++;
    }
return $node1;
}
function gentree($node,$branches,$termmesh) {
if ($branches!=""){
    if($termmesh!="")
        $qs="SELECT * FROM    meshterm  WHERE     parent=".$branches." and term like '%".$termmesh."%' ORDER BY ident";
     else
        $qs="SELECT * FROM    meshterm  WHERE     parent=".$branches." ORDER BY ident";
}else{
    if($termmesh!="")
        $qs="SELECT * FROM   meshterm  WHERE   lower(term) like '%".strtolower($termmesh)."%'  ORDER BY ident";
    else
        $qs="SELECT * FROM   meshterm  WHERE     parent='-1' ORDER BY ident";
}
//echo "<br>".$qs."<br>";
        $rc=mysql_query($qs);
        $num=mysql_numrows($rc);
    $i=0;
    //$node1   = new HTML_TreeNode(array('text' => "vasuthep", 'link' => "menu.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
    $node1   = new HTML_TreeNode(array('text' => "Mesh Term", 'link' => "menu.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), "");
    while($ar = mysql_fetch_array($rc)){
    //for ($i=0;$i<1;$i++) {
    
       /*if($i==0 ) { 
         //$node1   = new HTML_TreeNode(array('text' => $ar['term'], 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon, 'expanded' => true), array('onclick' => "alert('foo'); return false", 'onexpand' => "alert('Expanded')"));
        }else{
                $node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "test.php", 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
        }*/
         
         if ( $ar['haschild']=="1" ) {             
            $node1->addItem(gentree2("node",$ar['ident']));
         }else{
                //$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?query1=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
				$node1->addItem(new HTML_TreeNode(array('text' => $ar['term'], 'link' => "./index.php?advanced=true&query1=".$ar['term']."&term=".$ar['term']."&Query1=".$ar['term']."&fulltext=".$ar['term']."&SearchString=".$ar['term'], 'icon' => $icon, 'expandedIcon' => $expandedIcon)));
        }
         $i++;
    }
return $node1;
}
    //$node1= gentree("node","") ;
    
    //$menu->addItem(gentree("node","") );
    //$menu->addItem(gentree("node","") );
    $menu->addItem(gentree("node","",$qterm) );
    //$menu2->addItem($node1);
    
    // Create the presentation class
   $treeMenu = &new HTML_TreeMenu_DHTML($menu, array('images' => './term/images', 'defaultClass' => 'treeMenuDefault'));
   //$listBox  = &new HTML_TreeMenu_Listbox($menu, array('linkTarget' => '_self'));
    //$treeMenuStatic = &new HTML_TreeMenu_staticHTML($menu, array('images' => '../images', 'defaultClass' => 'treeMenuDefault', 'noTopLevelImages' => true));
?>


<script language="JavaScript" type="text/javascript">
<!--
    a = new Date();
    a = a.getTime();
//-->
</script>
<table border=1 cellspacing="0" cellpadding="0">
<form name="termsearch" action="" method="GET">
<tr>
    <td>key word</td>
    <td><input type="text" name="qterm" value="<?echo $qterm;?>" onblur="sentpara('qterm')"></td>
</tr>
<tr>
    <td>
		<input type="hidden" name="query1" value="<? if ($_GET['query1']=="") echo $_GET['qterm']; else echo $_GET['query1'];?>">	
		<input type="hidden" name="term" value="<? if ($_GET['term']=="") echo $_GET['qterm']; else echo $_GET['term'];?>">
        <input type="hidden" name="Query1" value="<? if ($_GET['Query1']=="") echo $_GET['qterm']; else echo $_GET['Query1'];?>">
        <input type="hidden" name="fulltext" value="<? if ($_GET['fulltext']=="") echo $_GET['qterm']; else echo $_GET['fulltext'];?>">
		<input type="hidden" name="SearchString" value="<? if ($_GET['SearchString']=="") echo $_GET['qterm']; else echo $_GET['SearchString'];?>">
		<input type="submit" value="Search"></td>
    <td><input type="reset" value="cancel"></td>
</tr>
<tr><td><a href='./term/tree.php' target='_blank'>เพิ่มข้อมูล</a></td></tr>   
</form>
</table>
<br>
<font size=2 color=red>
<?$treeMenu->printMenu()?><br /><br />
<?//$listBox->printMenu()?>
</font>

<script language="JavaScript" type="text/javascript">
<!--
    b = new Date();
    b = b.getTime();
   
   // document.write("Time to render tree: " + ((b - a) / 1000) + "s");
//-->
</script>

