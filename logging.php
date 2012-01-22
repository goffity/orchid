<?php
	include 'log4php/Logger.php';
	
	Logger::configure('log4php.xml');
	
	$log = Logger::getLogger('mylogger');
	
	$log->warn('warn');
	
	$log->error("My fifth message.");
	
	echo 'ABC';
?>