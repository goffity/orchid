<?php
//*******************************************
//php_tree.class
//*******************************************
class php_tree
{

/***
*
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    | php_tree                                                               |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    |   Supplies raw functions to display, inject, retrieve                  |
*    |   and safely delete information from MySQL-database                    |
*    |   holding 'flat' tree information in rows ident, parent,               |
*    |   haschild.                                                            |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    |   Auhor:     Ralf Roeber (phpclasses@zeitfenster.de)                   |
*    |              An der Reling 1                                           |
*    |              D-27721 Ritterhude                                        |
*    |              Germany/Deutschland                                       |
*    |   Version:   0.3 - 2003-06-18                                          |
*    |   License:   LGPL;                                                     |
*    |              Cardware ... sending postcard required if used in         |
*    |                           production environment!                      |
*    |   Comment:   Let me know if you are having any troubles, would like    |
*    |              changes or are just happy                                 |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |   Changelog:                                                           |
*    |   2003-06-19  insert_into_db() now returns ident of created object     |
*    |                                                                        |
*    |               delete_from_db_wholetree() now stores parent-id ... use  |
*    |               $this->father to see parent id of deleted node; now      |        
*    |               number of deleted nodes is returned                      |
*    |                                                                        |
*    |               delete_from_db() now stores parent-id ... use            |
*    |               $this->father to see parent id of deleted node           |        
*    |                                                                        |
*    |   2003-06-18  changed populate_polzin_tree to output root nodes as     |
*    |               root nodes to javascript also ...                        |
*    |               // draws root nodes in branch of given                   |
*    |               // $node as root nodes in javascript                     |
*    |               // parentnode-id for polzin_javascript tree ...          |
*    |               // root nodes get "0"                                    |
*    |               $parent    = ($this->branches<>1) ? $ar['parent'] : 0;   |
*    |                                                                        |
*    |               Oops, objects in root could have been moved_up beyond    |
*    |               absolute root ... move_up($node) fixed - added if-clause |
*    |                                                                        |
*    |               Documentation of set_parameters corrected                |
*    |                                                                        |
*    |   2003-06-09  populate_polzin_tree($node) outputs js to js-tree from   |
*    |                selfhtml.teamone.de js-tree-example                     |
*    |               move_to ($node,$destination_node) introduced             |
*    |               move_up ($node) introduced                               |
*    |               cleaned up redundancy in delete_from_from_db($node)      |
*    |               added pixel-directory with graphics                      |
*    |               added php_tree.js with the java-script functions to      |
*    |                display an interactive expandable tree                  |
*    |                                                                        |
*    |   2003-06-05  cleaned up display_full_tree($node)                      |
*    |                introduced  correct icons to display                    |
*    |                                                                        |
*    |   2003-06-04  synchronized table_name in example.php and php_tree.class|
*    |               Change href in line 99 of example.php to "example.php"   |
*    |               demo.php is actually not needed anymore                  |
*    |                                                                        |
*    |   2003-06-03  changed uid to not unique                                |
*    |               added display_full_tree link in header                   |
*    |               added styles_win.css to package                          |
*    |               synchronized example.php and demo.php                    |
*    |               delete_from_db_wholetree($node) introduced               |
*    |               added function to demo                                   |
*    |               set_parameters() ... $debug added                        |
*    |               changed version from 0.2. to 0.3                         |
*    |               got ranked top-1 downloaded class of the week            |
*    |               @ www.phpclasses.org  ... thanks                         |
*    |                                                                        |
*    |   2003-06-02  added documentation                                      |
*    |               change order in display_full_tree                        |
*    |                                                                        |
*    |   2003-06-01  added display_full_tree,                                 |
*    |               populated database with 11000 entries                    |
*    |               and checked on behavior                                  |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    |   MySQL-table definition (you need to set this up manually!)           |
*    |                                                                        |
*    |   CREATE TABLE php_tree (                                              |
*    |   ident int(12) NOT NULL auto_increment,                               |
*    |   uid int(12) NOT NULL default '0',                                    |
*    |   gui int(12) NOT NULL default '0',                                    |
*    |   parent int(12) NOT NULL default '-1',                                |
*    |   haschild enum('0','1') NOT NULL default '0',                         |
*    |   email varchar(80) default NULL,                                      |
*    |   UNIQUE KEY ident (ident),                                            |
*    |   KEY parent (parent)                                                  |
*    |   ) TYPE=ISAM PACK_KEYS=1;                                             |
*    |                                                                        |
*    |   ident    .... stores number of database_row_entry,                   |
*    |                 will be incremented automatically on new row inserted  |
*    |   uid      .... uid for special purpose (not essentially needed)       |
*    |   gui      .... stores group id's, makes everything system multi-client|
*    |                 -capable (mandantenfähig)                              |
*    |   parent   .... -1=no parent, x=ident of parent object                 |
*    |   haschild .... 0=has no child, 1=has childs                           |
*    |   email    .... stores text-information to display                     |
*    |                                                                        |
*    |   ident    parent    haschild    uid    gui email                      |
*    |   -----------------------------------------------                      |
*    |    1        -1        1          xxx    999 about first node on root   |
*    |                                                   level with child     |
*    |    2         1        0          xxx    999 faq   1st child of node 1  |
*    |    3        -1        0          xxx    999 news  2nd node root level  |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    |   Supplied functions:                                                  |
*    |   ===================                                                  |
*    |                                                                        |
*    |   function set_parameters ($gui,$mode,$db,$table,                      |
*    |                       $show_db_identifier,$debug)                      |
*    |                                                                        |
*    |   * set's parameters of class, see function for details                |
*    |   * no return                                                          |
*    |                                                                        |
*    |                                                                        |
*    |   function display_path($node,$reverse_path)                           |
*    |                                                                        |
*    |   * displays the path to given node                                    |
*    |   * returns number of branches and path in array                       |
*    |    -> 11 branches from root node out of 11000 nodes in database        |
*    |       take around 0.2 seconds to compute                               |
*    |                                                                        |
*    |                                                                        |
*    |   function display_reverse_path ($node)                                |
*    |                                                                        |
*    |   * displays reverse path from array gathered in display_path()        |
*    |   * returns html-output                                                |
*    |    -> 11 branches from root node out of 11000 nodes in database        |
*    |       take around 0.2 seconds to compute                               |
*    |                                                                        |
*    |                                                                        |
*    |   function display_branch($node)                                       |
*    |                                                                        |
*    |   * displays the branch from given node                                |
*    |   * returns html-output                                                |
*    |   -> 39 root nodes from 11000 nodes in database take around 0.3        |
*    |      seconds to compute                                                |
*    |                                                                        |
*    |                                                                        |
*    |   function display_full_tree($node)                                    |
*    |                                                                        |
*    |   * displays the full tree below a given node                          |
*    |   * returns html output                                                |
*    |   -> display 11000 expanded nodes takes 55 seconds to compute          |
*    |                                                                        |
*    |                                                                        |
*    |   function populate_polzin_tree($node)                                 |
*    |                                                                        |
*    |   * outputs java-script to include in polzin tree from selfhtml        |
*    |   * returns html output                                                |
*    |   -> displays 1000 nodes in interactive javascript tree in 1.5 secs    |
*    |                                                                        |
*    |                                                                        |
*    |   function insert_into_db($father,$child, $uid)                        |
*    |                                                                        |
*    |   * insert an object to database                                       |
*    |   * returns ident of inserted object                                   |
*    |                                                                        |
*    |                                                                        |
*    |   function delete_from_db($node)                                       |
*    |                                                                        |
*    |   * delete the object refelected by $node from database                |
*    |   * moves childs up to parent                                          |
*    |   * no return                                                          |
*    |                                                                        |
*    |                                                                        |
*    |   function move_up($node)                                              |
*    |                                                                        |
*    |   * moves given node up one level in tree including subnodes           |
*    |   * returns ident of destination node in $this->father                 |
*    |                                                                        |
*    |                                                                        |
*    |   function move_to($node,$destination_node)                            |
*    |                                                                        |
*    |   * moves given node to destination node including subnodes            |
*    |   * returns number of nodes moved                                      |
*    |                                                                        |
*    |                                                                        |
*    |   function delete_from_db_wholetree($node)                             |
*    |                                                                        |
*    |   * deletes the object refelected by $node from database               |
*    |   * deletes also all objects below given $node                         |
*    |   * sets haschild to 0 if noone is left in tree below parent           |
*    |   * $this->number_of_nodes ... number of nodes deleted by func()       |
*    |   * $this->father ............ parent id of node                       |
*    |   * returns number of nodes deleted                                                          |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*    |                                                                        |
*    |   Dedicated to my wife and our son - who give me the strength to       |
*    |   manage their and my life as things have to be done                   |
*    |                                                                        |
*    +------------------------------------------------------------------------+
*
*/

    var $gui;
    var $uid;
    var $node;
    var $mode;
    var $father;
    var $child;
    var $db;
    var $branches;
    var $reverse_path;
    var $display_db_identifier;
    var $debug;
    var $display_remove_button;
    var $is_last_node;
    var $number_of_nodes;
    var $polzin_res;
    var $polzin_string;

    /* ************************************* */
    function set_parameters ($gui,$mode,$db,$table,$show_db_identifier,$debug) {
    /* ************************************* */
    /***
    *    init class parameter
    */

        $this->gui = $gui;                                   // client-number (mandant)
        $this->mode = $mode;                                 // display mode: 1 ... shows db's values, 3 show's path
        $this->db = $db;                                     // database connection pointer
        $this->table = $table;                               // database table name to work on
        $this->branches = "0";                               // number of branches above node
        $this->reverse_path = array();                       // stores texts and id for reverse path display
        $this->display_db_identifier = $show_db_identifier;  // show db identifier in tree-view
        $this->debug = $debug;                               // 0=don't show debug information, 1=show debug information
        $this->display_remove_button = "1";                  // 1=show delete button in branch_view
        $this->is_last_node = array();                       // $this->is_last_node[$this->branches]
        $this->number_of_nodes = 0;                          // traverseing the tree this is where we store the number of nodes, that have been processed
        $this->polzin_result = array();                      // array resulting from SQl-query for the polzin tree
        $this->polzin_string = "\$i";                  // "$this->polzin_result['email']";

    }

    /* *************************************** */
    function display_path($node,$reverse_path,$print) {
    /* *************************************** */
    /***
    *    displays the path to the node ... root is right most
    *    return's number of branches above actual node
    */

        if ($node!="-1") {
            $qs="SELECT     ident,
                    parent,
                    email
                    FROM     ".$this->table."
                    WHERE     ident='$node'
                    AND     gui='".$this->gui."'";

            if ($this->debug=="1") { echo $qs."<br>"; }

            $rc=mysql($this->db,$qs); fehler();
            $ar=mysql_fetch_array($rc);

            /*

                print out path to html if $print == 1

            */
            if ($print=="1") {
                echo '\\<a href="?node='.$ar['ident'].'">'.$ar['email'].'</a>';
            }

            if ( mysql_num_rows($rc)>0 && $ar['parent']!="-1")
            {
                $this->branches=$this->display_path($ar['parent'],$this->reverse_path,$print);
            };
            array_push( $this->reverse_path, array($this->branches, $ar['ident'], $ar['email']) );
        }

        return ($this->branches+1);

    } /* end of function display path */


    /* ******************************* */
    function display_reverse_path ($node) {
    /* ******************************* */
    /**
    *    display's reverse path
    *
    *
    */


    /*

        Reset everything to 0

    */
    $this->branches=0;
    $this->reverse_path=array();

    /*

        gather path information without printing (mind trailing 0)

    */
    $this->display_path($node,$this->reverse_path,"0");

    /*

        print number of branches above actual node found to display

    */
    echo "branche no. ".($this->branches+1)." in tree<br>";
    echo '\\\\<a href="?node=-1">root</a>\\';

    /*

        display the path from root to actual node

    */
    for ($i=0;$i<($this->branches+1);$i++)
    {
        echo ' <a href="?node='.$this->reverse_path[$i][1].'">'.$this->reverse_path[$i][2].'</a>\\';
    }

    } /* end of function display_reverse_path() */



    /* *************************** */
    function display_branch($node) {
    /* *************************** */
    /**
    *
    *    displays the branch from selected node one level deep
    *
    */


        /*

            SQL-Query to retrieve all node/branches below current node

        */
        $qs="SELECT *
                FROM     ".$this->table."
                WHERE     (parent='$node' or ident='$node')
                AND     gui='".$this->gui."'
                ORDER BY ident, parent";

        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);


        /*

            how many nodes have been found in database

        */

        $this->number_of_nodes=$num;
        echo $num." nodes in tree from node $node ($this->mode, $this->gui)<br>";



        /*

            display branch in html-table style "table_tree"

        */
        echo '<table class="table_tree">';

        /*

            tripple through the SQL-resultset and show branch
            each node/branch is one table row

        */
        for($i=0;$i<$num;$i++) {

            $ar=mysql_fetch_array($rc);
            
            // echo '<td>'.$i.'</td>';

            if ($ar['haschild']=="1") {
                /*
                    yes, has childs
                */
                if ($node==$ar['ident']) {
                    // root of the tree
                    $link_node=$ar['parent'];
                    echo '<tr>';
                    echo '<td class="row_root">&nbsp;</td><td><a href="?node='.$link_node.'">-</a></td><td>'.$ar['email'].'</td>';
                }
                else
                {
                    // leaf with childs
                    $link_node=$ar['ident'];
                    echo '<tr class="row_leaf">';
                    echo '<td class="row_leaf">&nbsp; </td><td><a href="?node='.$link_node.'">+</a></td><td><a href="?node='.$ar['ident'].'">'.$ar['email'].'</a></td>';
                }
            }
            else
            {
                /*
                    no, childs not present
                */
                if ($node!=$ar['ident']) {
                    // root of the tree without childs
                    echo '<tr class="row_leaf">';
                    echo '<td class="row_leaf">&nbsp;</td><td>&nbsp;</td><td><a href="?node='.$ar['ident'].'">'.$ar['email'].'</a></td>';
                }
                else
                {
                    // leaf without childs
                    echo '<tr class="row_leaf">';
                    echo '<td class="row_leaf">&nbsp;</td><td>&nbsp;</td><td>'.$ar['email'].'</td>';
                }
            }

            // echo '<td>'.$ar['uid'].'</td>';

            /*

                show database values ...

            */
            if ($this->display_db_identifier=="1") {
                echo '<td>'.$ar['haschild'].'</td>';
                echo '<td>'.$ar['parent'].'</td>';
                echo '<td>'.$ar['ident'].'</td>';
            }



            /*

                show delete button to ease destroying data

            */
            if ($this->display_remove_button=="1") {
            
                    echo '<td>';
            

                    echo '<table class="table_with_buttons">';
                    echo '<tr>';

                    echo '<td>';
                    echo '<a href="?action=move_up&node='.$ar['ident'].'" ><span class="function_link">move_up('.$ar['ident'].')</span></a>';
                    echo '</td>';

                    echo '<td>';
                    echo '<a href="example_with_lots_of_javascript.php?action=fulltree&node='.$ar['ident'].'" ><span class="function_link">disp. js-tree()</span></a><br>';
                    echo '</td>';

                    echo '<td>';
                    echo '<a href="?action=delete_from_db&node='.$ar['ident'].'" ><span class="function_link">delete_from_db()</span></a>';
                    echo '</td>';

                    echo '</tr>';

                    echo '<tr>';
                    echo '<td>';
                    echo '</td>';

                    echo '<td>';
                    echo '<a href="?action=fulltree&node='.$ar['ident'].'" ><span class="function_link">disp. full_tree()</span></a>';
                    echo '</td>';

                    echo '<td>';
                    echo '<a href="?action=delete_from_db_wholetree&node='.$ar['ident'].'" ><span class="function_link">delete_wholetree</span></a>';
                    echo '</td>';

         
                    echo '</tr>';
                    echo '</table>';

                    echo '</td>';
            }

            echo '</tr>';

        }

        echo "</table>";

    } /* end of function display_branch */




    /* ****************************** */
    function display_full_tree($node,$branches) {
    /* ****************************** */
    /***
    *
    *    displays full tree
    *
    *     .. select current branch from db
    *    .. cycle through branch and display the nodes in branch
    *     .. if there are childs on current node ... recursivly call this function with current working node
    *    .. finishes anywhere and anyhow as database entries must be ending somewhere
    *     B) displaying more than 50.000 expanded (!) nodes most certainly freezes the browser ;-)
    *
    */


        $pix_child_node      ="pixel/ftv2mnode.gif";        // childs and not last node
        $pix_child_lastnode  ="pixel/ftv2mlastnode.gif";    // childs and last node

        $pix_nochild_node    ="pixel/ftv2node.gif";        // no child not last node
        $pix_nochild_lastnode="pixel/ftv2lastnode.gif";        // no child and last node


        $pix_vertline        ="pixel/ftv2vertline.gif";        // vertical line in front of node
        $pix_blank           ="pixel/ftv2blank.gif";        // or blank

        $qs="SELECT *
                FROM     ".$this->table."
                WHERE     parent='$node'
                AND       gui='".$this->gui."'
                ORDER BY parent";

        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);

        // buggy branch-count ... anyone wants to fix this?
        if ($this->branches==0) {$this->branches=1; }


        // cycle through branch from SQL-result-set
        for ($i=0;$i<$num;$i++) {
            $ar        = mysql_fetch_array($rc);        // get data from result-set
            $link_node = $ar['ident'];                // temporarily store it here
            $parent    = $ar['parent'];
            $this->number_of_nodes=$this->number_of_nodes+1;    // count the nodes/leafs/lines displayed

            // string to display as node text
            $disp_string=$ar['email']."...[".$ar['haschild']." ".$ar['ident']." ".$ar['parent']."  ".$this->branches."]";


            // is_last_node = true/false
            $this->is_last_node[$this->branches] = ( $i==$num-1 );

            // uncomment the folling print_r line if you want to see the contents of the array
            // ... should try!
            // it's nice to see how the content of the array changes when recursively
            // calling the same function. i believe this is what objects or subjects could
            // mean, without ever having studied OOP/OOC/OOD/OOA *g*

            // print_r($this->is_last_node);

            // calculate table-width of elements to display in front of the node-text
            $_width=max($this->branches*16,16);

            // calculate the y-Position of the line being displayed
            $_y    =$this->number_of_nodes*22;

            // div around tree from here to everything below -> in order to toggle vis/not visible
            // echo '<div id="'.$link_node.'" style="position:relative; visibility:visible; background-color:#E0E0E0; border:1px solid red; z-index:'.$this->branches.';">';
            echo '<div id="branch_'.$this->number_of_nodes.'" class="full_tree_div">';

            // draw table around node / line
            echo '<table class="full_tree_table"><tr>';
            echo '<td class="full_tree_td" style="width:'.$_width.'px;" >';

            // what to draw in front of actual line? vertical line or blank?
            if ($this->branches>1) {

                // we are in a level below root = show vertical lines according to the level
                for($_i=1;$_i<$this->branches;$_i++)
                {

                    /***
                    * steps from 0 to actual branch-level e.g. 10
                    * each branch has is_last_node = true or false ...
                    * if true -> means that no more vertical lines are required
                    * if false-> means that vertical are required and nodes on higher level are to come
                    * uncomment print_r line above to see array-values
                    */

                    if($this->is_last_node[$_i]==1)
                    {
                        // is_last_node = true ... don't display vertical line
                        echo '<img alt=" " src="'.$pix_blank.'" class="icon">';
                    } else {
                        // is not last node ... display vertical line
                        echo '<img alt="|" src="'.$pix_vertline.'" class="icon">';
                    } /* end of if */
                } /* end of for */


                // what icon is need at last in front of actual line? node, lastnode?
                if ($i<$num-1) {
                    // we are not at the end of the branch = draw pix_child_node
                    if ($ar['haschild']==1) {
                        echo '<img alt="--" src="'.$pix_child_node.'" class="icon">';
                    } else {
                        echo '<img alt="--" src="'.$pix_nochild_node.'" class="icon">';
                    }
                } else {
                    // we are at the end of the branch ... end node image
                    if ($ar['haschild']==1) {
                        echo '<img alt="--" src="'.$pix_child_lastnode.'" class="icon">';
                    } else {
                        echo '<img alt="--" src="'.$pix_nochild_lastnode.'" class="icon">';
                    }
                }

            }
            else {
                // we are on root level ... draw nothing in front of node
                // what icon is need at last in front of actual line? node, lastnode?
                if ($i<$num-1) {
                    // we are not at the end of the branch = draw pix_child_node
                    echo '<img alt="--" src="'.$pix_child_node.'" class="icon">';
                } else {
                    // we are at the end of the branch ... end node image
                    echo '<img alt="--" src="'.$pix_nochild_lastnode.'" class="icon">';
                }
            }

            // this td closes the icons cell in front of the node-text
            echo '</td>';

            // opens cell for the text of the node
            echo '<td>';
            echo '<a href="?node='.$link_node.'">'.$disp_string.'</a>';

            // close the table ... line is finish
            echo '</td></tr></table>';

            // if there are childs on current node ... recursively call display_full_tree
            if ( $ar['haschild']=="1" ) {
                $this->branches=$this->branches+1;
                $branches=$this->display_full_tree($ar['ident'],$this->branches);
                $this->branches=$this->branches-1;
                //echo '</div>';
            } /* end of if */

            // end of the div around the current subtree/node/line/leaf/branch ...
            echo '</div>';

        } /* end of for cycling thru branch */

        // return();        // maybe in the future we will return values here ?!? who knows
        echo '</div>';
    } /* end of function display_full_tree */


    /* ****************************** */
    function populate_polzin_tree( $node, $branches, $string ) {
    /* ****************************** */
    /***
    *
    *    populate_polzin_tree
    *    ... outputs the javascript commands to help drawing the javascript polzin_tree
    *    ... returns nothing
    */

        $qs="SELECT *
                FROM     ".$this->table."
                WHERE     parent='$node'
                AND       gui='".$this->gui."'
                ORDER BY parent";

        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);
        
        
        if ($this->branches==0)
        {
            $this->branches=1;
        }

        // cycle through branch from SQL-result-set
        for ($i=0;$i<$num;$i++)
        {
            // get data from result-set
            $this->polzin_result = mysql_fetch_array($rc);                   
            
            // temporarily store it here
            $link_node = $this->polzin_result['ident'];                             
        
            // draws root nodes in branch of given $node as root nodes in javascript
            // parentnode-id for polzin_javascript tree ... root nodes get "0"
            $parent    = ($this->branches<>1) ? $this->polzin_result['parent'] : 0; 

            // draws root nodes in branch of $node below single root node
            // $parent    = $this->polzin_result['parent'] ; 

            // count the nodes/leafs/lines displayed
            $this->number_of_nodes=$this->number_of_nodes+1;       

            // string to display as node text
            // $disp_string = $this->polzin_result['email']." :: node #".$this->number_of_nodes." :: branch-level #".$this->branches;
            
            $test = "\$this->number_of_nodes";
            echo eval($test);
            echo eval("\$this->polzin_string");
            exit;
            
            // $disp_string = $$this->polzin_string;
            
            /***
            * alternative strings to display as menue entry in the javascript tree
            * --
            * $disp_string=$ar['email']." :: node #".$this->number_of_nodes." :: branch-level #".$this->branches;
            * $disp_string=$ar['email']."...[".$ar['haschild']." ".$ar['ident']." ".$ar['parent']."  ".$this->branches."]";
            */
            
            $js_polzin_string="Note(".$link_node.",".$parent.",'".$disp_string."','')\n";
            echo $js_polzin_string;


            // if there are childs on current node then 
            // ... recursively call populate_polzin_tree
            if ( $this->polzin_result['haschild']=="1" )
            {
                
                $this->branches=$this->branches+1;
                $branches=$this->populate_polzin_tree($this->polzin_result['ident'],$this->branches, $this->string);
                $this->branches=$this->branches-1;

            } /* end of if */
            
        } /* end of for cycling thru branch */

        // number of nodes populated
        return($i);        

    } /* end of function populate_polzin_tree */





    /* ********************************** */
    function insert_into_db($father, $child, $uid)
    {
    /* ********************************** */
    /**
    *
    *    injects an object to the database
    *
    */


        /*

            first retrieve information about father
            (just in case someone has changed database
            in between)


        */
        $qs="SELECT
                ident,
                uid,
                gui,
                parent
            FROM ".$this->table."
            WHERE ident='".$father."'
            AND gui='$this->gui'";
        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);


        /*

            Check if father still present

        */
        if ($num=="0")
        {
            // if father not present anymore or not given
            // put new object in root position
            $parent="-1";
        }
        else
        {
            // father present
            $parent=$father;
        }

        /*

            SQL-statement to insert new object

        */
        if (!isset($this->uid)) { $this->uid=time(); }
        $qs="INSERT INTO ".$this->table."
            SET parent='$parent',
                uid='".$this->uid."',
                gui='".$this->gui."',
                email='".$child."'";
        $rc=mysql($this->db,$qs); fehler();
        
        $this->child=mysql_insert_id();

        /*

            if father present, set father.haschild to 1

        */
        if ( $parent!="-1") {

            // update parent set haschild=1
            $qs="UPDATE ".$this->table."
                SET haschild='1'
                WHERE ident='".$parent."'
                AND gui='".$this->gui."'";
            $rc=mysql($this->db,$qs); fehler();
        }

        return ($this->child);  // ident of inserted object

    } /* end of function insert_into_db */



    /* *************************** */
    function delete_from_db ( $node )
    /* *************************** */
    /**
    *
    *     remove data in a save way
    *     -> moves childs one level up to parents
    *     returns nothing
    */
    {

        // see if node has_childs
        $qs="SELECT
                ident,
                uid,
                gui,
                parent,
                haschild
            FROM ".$this->table."
            WHERE ident='".$node."'
            AND gui='$this->gui'";
        $rc=mysql($this->db,$qs); fehler();

        if ($this->debug=="1") { echo $qs."<br>"; }

        $ar=mysql_fetch_array($rc);
        $this->father = $ar['parent'];

        // if haschilds
        if ($ar['haschild']=="1")
        {
            // move childs up to parents
            $qs="UPDATE ".$this->table."
                SET PARENT='".$ar['parent']."'
                WHERE parent='".$node."'";
            $rc=mysql($this->db,$qs); fehler();
            $this->number_of_nodes=mysql_numrows($rc);                 // just for information, you may use this in example.php

            if ($this->debug=="1") { echo $qs."<br>"; }

        }

        // remove node itself is now save
        $qs="DELETE FROM ".$this->table."
            WHERE ident='".$node."'
            LIMIT 1";                                                  // limit just for safety reason ;-)
        $rc=mysql($this->db,$qs); fehler();

        if ($this->debug=="1") { echo $qs."<br>"; }

    } /* end of function delete_from_db */

    /* *************************** */
    function move_up ( $node ) {
    /* *************************** */
    /**
    *
    *     moves the given node to level of parent
    *     -> returns $this->father with parent node-id
    *
    */

        // retrieve parent id
        $qs="SELECT parent
            FROM ".$this->table."
            WHERE ident='$node'";
        $rc=mysql($this->db,$qs); fehler(); if ($this->debug=="1") { echo $qs."<br>"; }
        $ar_1=mysql_fetch_array($rc);


        // 
        // if given node is in the absolute root of the tree ... it can't be moved up ;-)
        // see if object is at final root position of tree
        // 
        if ($ar_1['parent']!="-1") {

            // retrieve ident of parent
            $qs="SELECT parent
                FROM ".$this->table."
                WHERE ident='".$ar_1['parent']."'";
            $rc=mysql($this->db,$qs); fehler(); if ($this->debug=="1") { echo $qs."<br>"; }
            $ar_2=mysql_fetch_array($rc);
    
            // move 'em up
            // echo $node."->".$ar_2['parent']."<br>";
            $this->move_to($node,$ar_2['parent']);

            // just for information ... return to which node the given node has been moved to
            $this->father=$ar_2['parent'];
        }    

    } /* end of function delete_from_db */

    /* ****************************** */
    function move_to ( $node, $destination_node ) {
    /* ****************************** */
    /**
    *
    *     moves the given node to given parent/node
    *     -> returns parent node-id
    *
    */


        // set ident of node to ident of parent-ident
        $qs="UPDATE ".$this->table."
            SET PARENT='".$destination_node."'
            WHERE ident='".$node."'
            LIMIT 1";                                              // just for safety reason
        $rc=mysql($this->db,$qs); fehler(); if ($this->debug=="1") { echo $qs."<br>"; }

    } /* end of function delete_from_db */



    /* *************************** */
    function delete_from_db_wholetree ( $node )
    /* *************************** */
    /**
    *
    *     remove all data below given node
    *     -> also removes childs and childs of child
    *
    */
    {

        // see what to delete
        $qs="SELECT *
                FROM     ".$this->table."
                WHERE    parent='$node'
                AND     gui='".$this->gui."'
                ORDER BY parent";

        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);


        // delete everything below
        for ($i=0;$i<$num;$i++) {
            // fetch a row from previous select
            $ar=mysql_fetch_array($rc);
            $link_node=$ar['ident'];

            // add 1 to number of nodes, for returning number of deleted objects
            $this->number_of_nodes=$this->number_of_nodes+1;

            // remove node
            $qs="DELETE FROM ".$this->table."
                WHERE ident='".$link_node."'
                AND     gui='".$this->gui."'
                LIMIT 1";                               // limit just for safety reason ;-)
            $rc3=mysql($this->db,$qs); fehler();        // delete the node

            if ($this->debug=="1") { echo $qs."<br>"; } // if debug, display the sql-query

            // if haschild remove them
            if ( $ar['haschild']=="1" )
            {
                $this->delete_from_db_wholetree($ar['ident']);
            }

        }

        // see what has been deleted and where is the parent
        $qs="SELECT *
                FROM     ".$this->table."
                WHERE     (ident='".$node."')
                AND     gui='".$this->gui."'
                ORDER BY parent";

        $rc=mysql($this->db,$qs); fehler();
        if ($this->debug=="1") { echo $qs."<br>"; }

        // get the parent from $node
        $parent=mysql_result($rc,0,"parent");

        // update parent ... remove haschild information if only one is left
        $qs="SELECT *
                FROM     ".$this->table."
                WHERE    ident='".$parent."'
                AND      gui='".$this->gui."'";

        $rc=mysql($this->db,$qs); fehler();
        $num=mysql_numrows($rc);

        if ($num==1) {
            // change haschild to 0 if no one else is here
            $qs="UPDATE ".$this->table."
                SET haschild='0'
                WHERE ident='".$parent."'
                AND     gui='".$this->gui."'
                LIMIT 1";                // limit 1 just for safety
            if ($this->debug=="1") { echo $qs."<br>"; }
            $rc=mysql($this->db,$qs); fehler();
            $num=mysql_numrows($rc);
        }

        // remove node itself
        $qs="DELETE FROM ".$this->table."
            WHERE ident='".$node."'
            AND     gui='".$this->gui."'
            LIMIT 1";                    // limit just for safety reason ;-)
        $rc3=mysql($this->db,$qs); fehler();
        $num3=mysql_numrows($rc);

        $this->father = $parent;

        return($this->number_of_nodes);

    } /* end of function delete_from_db_wholetree */



} /* end of php_tree class */
?>
