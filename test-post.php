<?php
include 'wp-includes/class-IXR.php';

$client = new IXR_Client('http://localhost/wordpress2/xmlrpc.php');

$title = $_REQUEST[''];

$note = array(
    'title'             => 'Hello World!',   //title
    'description'        => 'to będzie wstęp...',  //content
    'mt_text_more'      => 'treść wpisu',    //tag more
    'categories'        => array('Uncategorized'),   //categories of post
    'mt_keywords'       => array('tag1', 'tag2', 'tag'), // tag
//'dateCreated'       => date(DATE_RFC822, mktime(0, 0, 0, 1, 1, 2000)),   //data publikacji wpisu
//'wp_password'     => 'hasuo',    //hasło wpisu
//'mt_allow_pings'    => true,  //zezwalać na pingbacki?
//'mt_allow_comments' => true,  //a na komentarze?
);

if(!$client->query('metaWeblog.newPost', 1, 'admin', 'password', $note, true)){
	echo $client->getErrorCode().': '.$client->getErrorMessage();
}

echo $client->getResponse();

?>