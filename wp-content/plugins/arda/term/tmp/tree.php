<?php
//example.php

/* ***************************************** */
function getmicrotime(){
/* ***************************************** */
    list($usec, $sec) = explode(" ",microtime());
    return ((float)$usec + (float)$sec);
    }

// record processing time
$start=getmicrotime();

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

// database-server ...
$db_host = "localhost";

// database username
$db_user = "root";

// Database name
$db = "treemenu";

// password to connect with to the database-server
$db_pwd = "1q2w3e4r";

// database table name we are working on ... if you don't have it setup already, doit now!
// definition of the table is shown in the documentation of the php_tree.class itself
$table = "meshterm";        /* database table working on */
//$table = "php_tree";        /* database table working on */

// where to mail errors
$db_mailto_error= "phpclasses@zeitfenster.de";

// display mode: 3=almost everything, 2=less, 1=crutial
$mode = "3";

// show parent, ident, haschild values in tree-views: 1=yes, 0=no
$show_db_identifier="1";

// show sql-statements, 1=true, 0=false
$debug="0";


// define client / mandant
if (!isset($gui)) { $gui = "999"; }

// set starting point to root node, if none given
if (!isset($node)) { $node="-1"; };

/* ********************************** */


/*

    header for html page

*/
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">';
echo '<html><head><title>Mesh Term</title>';
//include("style_win.css");        /* load some style */
?>
<style type="text/css">
<!--
body          {font-family: Verdana, Helvetica, Arial, Geneva, Sans-serif; font-size: 10pt; color: #000000; background-color: #FFFFFF}

table   {
	font-size: 12pt;
	font-weight: bold;
	color: #000020;
	font-color: #0000A0;
	background-color: #FAFAFA;
        margin:1pt;
	width:80%;
	padding-left: 2pt;
	padding:0pt;
	border:1pt solid black;
}

#branch_1 {
	visibility:visible;
    // display:relative;
	position: absolute;
    z-Index: 2;
    }


hr			  { width:80%; }
pre, tt       {font-size: 12pt}
br, p, th            {
				font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; font-size: 10pt;
				font-weight: bold; color: #0000A0; font-color: #0000A0; background-color: #FAFAFA;
			  }
tr, td        {
	font-size: 10pt; font-weight:normal;
}
h1            {font-size: large; font-weight: bold; color: #0F00A0;}
h2            {font-size: medium; font-weight: bold; color: #0000A0;}
A:link        {font-size: 10pt; font-weight: bold; text-decoration: none; color: #0000ff}
A:visited     {font-size: 10pt; text-decoration: none; color: #0000F0}
A:hover       {font-size: 10pt; text-decoration: underline; color: #FF0000}
A:link.nav    {font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; color: #000000}
A:visited.nav {font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; color: #000000}
A:hover.nav   {font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; color: #0000FF}



.icon         {
	border:0pt;
    width:16px;
    height:22px;
    }

.full_tree_table {
	# border:0pt solid red;
    vertical-align:top;
    margin:0pt;
    padding:0pt;
    border-collapse:collapse;
    background-color:#F0F0F0;
    }

.full_tree_td {
	border:0pt solid red;
    border-collapse:collapse;
    margin:0pt;
    padding:0pt;
    padding-right:2pt;
    }

.full_tree_div {
	display: block;
	white-space: nowrap;
	visibility:visible;
    background-color:#FFFFFF;
    border:0pt solid red;
    z-index:0;
    }

.nav          {font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; color: #000000}
.submitkey    {background-color:#AAAAAA; color:#FFFFFF; width:200pt; border:1pt solid #000055; }
.footer	      {font-family: tahoma, verdana, helvetica, arial, geneva, sans-serif; color: #000000;font-size: 8pt; }

.row_leaf     { background-color:#EEEEEE; border:1px solid #000000; padding:0px; margin:0px; }
.row_root     { border-left:1px solid #000000; border-bottom:1px solid #000000; margin:0pt; padding:0pt;}
.table_tree   { width:80%; }
.button       { background-color:#88DDDD; 
                color:#FFFFFF; 
                line-height:12pt; 
                ext-align:top; 
                font-size:9px; 
                height:16pt; 
                width:60pt; 
                border:1pt solid #000055; 
                border-width:1px;
                padding:0px; 
                margin:0px;
            }

.table_with_buttons 
   { 
   width:100%;
   padding:2px;
   }

.table_with_buttons TD
   { 
   background-color:#A0A0A0;
    width:33%;
    text-align:center;
   }

.function_link {
   font-size:10px;
   color:#FFFFFF;
   border:1px solid #00000;
   width:140px;
   padding:1px;

   
   }

//-->
</style>
<?
echo '</head><body>';


/*

    Some information to lead into demo

*/
echo '<table><tr><td>';


if ( isset($node) && $node=="-1" )
{
    echo '<p>You must have a database and store data in a table with ident, parent, haschild rows holding information about your products, your database, your repository, your menuesystem, your ';
    echo '... what ever you can imagine, than php_tree gives you handy, raw-functions to retrieve, inject and safely destroy information without having to bother about anything else than layout ';
    echo 'and your idea itself.</p>';
    echo 'Please be encouraged to drop me a mail (phptree\'at\'zeitfenster.de), in case of any problems or questions or errors or missing functionality.';
    echo 'I would be very happy to answer your e-mail.';
}
echo '</td></tr></table>';


/*

    just to view the source-code
    
*/  
/*if ( ( $db_host=="localhost" && $_SERVER['SERVER_NAME']!="www.zeitfenster.de" ) || $_GET['action']=="showsource")
{
    echo '<h2>Here comes the source-code</h2><br>';
    echo '<br>';
    echo '*******************************************<br><p>';
    echo '<h2>qad (quick and dirty) Examples how to use php_tree ... hope it helps you</h2><br>';
    echo '*******************************************<br>';
    echo ' example.php<br>';
    echo ' tree.php<br>';
    echo '*******************************************<br>';
    //show_source('example.php');
    show_source('tree.php');
    echo '*******************************************<br>';
    echo ' php_tree.class<br>';
    echo '*******************************************<br>';
    show_source('php_tree.class');
    echo '*******************************************<br><p>';
    exit;
}*/


/*

    connect to database

*/

mysql_connect($db_host,$db_user,$db_pwd);
mysql_select_db($db);




/*

    get class ready for working 

*/
require_once("php_tree.class");

// initialize class
$mytree = new php_tree();

// set the parameters from source-code into scope of class
$mytree->set_parameters($gui,$mode,$db,$table,$show_db_identifier,$debug);


/**
* +----------------------------------------------+
* | Demonstration of functions of php_tree.class |
* +----------------------------------------------+
*/

/*

   delete a node

*/

if ($_POST['action']=="delete") {
    $mytree->delete_from_db($_POST['node']);
    $node=$_POST['parent_node'];
}

/*

   evaluate actions coming from form or url
 
*/
if (isset($_GET['action'])) {

    switch ($_GET['action']) {

    case "delete_from_db":
        /*

            example of how to delete a whole tree

        */
        if (isset($_GET['node'])) { $node=$_GET['node']; }
        $mytree->delete_from_db( $node );
        echo 'node #'.$node.' removed and '.$mytree->number_of_nodes.' childs have been moved to parent<br>';
        break;

    case "delete_from_db_wholetree":
        /*

            example of how to delete a whole tree

        */
        if (isset($_GET['node'])) { $node=$_GET['node']; }
        $mytree->delete_from_db_wholetree($node);

        echo "done. ".$mytree->number_of_nodes." nodes removed. Parent node was ".$mytree->father;

        $node=$mytree->father;

        break;

    case "move_up":
        /*

            example of how to delete a whole tree

        */
        if (isset($_GET['node'])) { $node=$_GET['node']; }
        $mytree->move_up($node);
        if ($mytree->father !="") {
            echo "node #".$node." moved to ".$mytree->father.".";
            $node=$mytree->father;
        } else {
            echo 'father object empty ... could not move node-object beyond absolute root<br>';
        }
        break;

    case "fulltree":
        /*

        display the full tree

        */
        $mytree->display_full_tree($node,1);
        break;

    case "displaybranch":
        /*
        
        display a branch
        
        */
        echo '<table><tr><td>';
        //echo "<br><p>display_branch(\$node)</p>";
        $mytree->display_branch($node);
        echo $mytree->number_of_nodes.'</td></tr></table>';
        break;

    case "populatetree1":

        // just delete everything in database 
        $qs="delete from php_tree";
        $rc=mysql($db,$qs); fehler();

        // create a root node
        $mytree->insert_into_db(-1,"1000 nodes below this node", 1 );

        // generate 1000 nodes below root-node #1
        srand ((double)microtime()*1000000);

        for ($i=0;$i<1000;$i++) {
            $father=rand(1,1+$i);
            $mytree->insert_into_db($father,"child_of_".$father." i_".$i, 21 );
        } /* end of for */
        
        echo "<p>".$i." nodes generated</p>";
        
        // create some more examples ... genealogy path
        $temp_gf = $mytree->insert_into_db(-1,"Grand grand father", 42 );
        $temp_gf = $mytree->insert_into_db($temp_gf,"Grand father", 42 );
        $temp_gf = $mytree->insert_into_db($temp_gf ,"Father", 42 );
        $temp_gf = $mytree->insert_into_db($temp_gf ,"Son", 42 );
        $temp_gf = $mytree->insert_into_db($temp_gf ,"has no childs yet", 42 );

        // Create some exmaple websitemenue 
        $temp_root     =     $mytree->insert_into_db(-1,"website_menue", 43 );
                             $mytree->insert_into_db($temp_root,"news", 43 );
        $temp_products =     $mytree->insert_into_db($temp_root,"products", 43 );
        $temp_about    =     $mytree->insert_into_db($temp_root,"about us", 43 );
                             $mytree->insert_into_db($temp_root,"download", 43 );
        $temp_shop =         $mytree->insert_into_db($temp_root,"shop", 43 );
                             $mytree->insert_into_db($temp_shop,"buy product no 1", 43 );
                             $mytree->insert_into_db($temp_shop,"search", 43 );

                             $mytree->insert_into_db($temp_about,"history", 43 );
                             $mytree->insert_into_db($temp_about,"vision", 43 );
                             $mytree->insert_into_db($temp_about,"management", 43 );
                             $mytree->insert_into_db($temp_about,"contact", 43);
                             $mytree->insert_into_db($temp_about,"disclaimer", 43);

                             $mytree->insert_into_db($temp_products,"product no 1", 43);
        $temp_products_no2 = $mytree->insert_into_db($temp_products,"product no 2", 43);
                             $mytree->insert_into_db($temp_products,"product no 3", 43);
                             $mytree->insert_into_db($temp_products,"product no 4", 43);
                             $mytree->insert_into_db($temp_products,"product no 5", 43);

                             $mytree->insert_into_db($temp_products_no2,"red style", 43);
                             $mytree->insert_into_db($temp_products_no2,"silver style", 43);
                             $mytree->insert_into_db($temp_products_no2,"golden style", 43);
                             $mytree->insert_into_db($temp_products_no2,"as seen on tv", 43);

        // set starting point to root-node
        $node="-1"; 
    } /* end of switch */
}

/*

    display some form for assistance of database injection

*/

echo '<table><tr><td>';
echo '<form method="post">';
echo 'Child <input type="text" name="child">';
echo '<input type=hidden name=node value="'.$node.'">';
echo '<input type=submit class="button" name=submit value="save">';
echo '</form>';
echo '</td></tr></table>';


/*

    store a new object

*/
if (isset($_POST['child'])) {
    $mytree->insert_into_db($_POST['node'],$_POST['child'], time() );
    echo "ok";
}


/*

    display a branch of a $node

*/
echo '<table><tr><td>';
//echo "<br><p>display_branch(\$node)</p>";
$mytree->display_branch($node);
        
// check if database is empty ... 
if ( !isset($mytree->number_of_nodes) || $mytree->number_of_nodes=="0" ) {

    // database is empty ... offer help to populate database
    echo '<b>database is empty</b> ... <a href="?action=populatetree">click here to create a root-node and populate the database with dummy entries</a><br><br>';
    echo '</td></tr></table>';

} else {
    
    echo '</td></tr></table>';

    /*
    
        display path to a $node
    
    */
    //echo "<table><tr><td><br><p>display_path ( \$node, \$reverse_path )</p>";
    echo "<table><tr><td><br>";
    $branches=$mytree->display_path($node,$mytree->reverse_path,"1");
    echo '\\<a href="?node=-1">root</a><br>'; echo "branch no. ".$branches." in tree";
    echo '</td>';
    
    /*
    
        display reverse path to a node
    
    */
    echo '<td>';
    //echo "<br><p>display_reverse_path ( \$node )</p> ";
    $mytree->display_reverse_path( $node );
    echo '</td>';
    echo '</tr></table>';


} // end of if 


// just some calculation of execution time
$diff=round(getmicrotime()-$start,3); 
/*echo "<br>[exec ".$diff." sec] ";
echo '[<a href="?action=showsource">view source-code</a>] - ';
echo '[<a href="documentation.pdf">view documentation (PDF)</A>] - ';
echo '[<a href="http://developer.berlios.de/project/showfiles.php?group_id=839&release_id=1062">download everything (ZIP)</A>]';*/


?>
</body>
</html>

