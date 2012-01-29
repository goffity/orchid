<?php
include 'log4php/Logger.php';

Logger::configure('log4php.xml');

class logging {
	public static function getLog($name) {
		$log = Logger::getLogger($name);
		return $log;
	}
}
//$log->warn('warn');
//$log->error("My fifth message.");
//echo 'ABC';
?>