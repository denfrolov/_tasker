<?php
$_SERVER["DOCUMENT_ROOT"] = str_replace('/_tasker/tasks', '', dirname(__FILE__));
$DOCUMENT_ROOT = $_SERVER["DOCUMENT_ROOT"];
define("NO_KEEP_STATISTIC", true);
define("NOT_CHECK_PERMISSIONS", true);
define('CHK_EVENT', true);

require $_SERVER['DOCUMENT_ROOT'] . '/_tasker/init.php';

$count = 10;
Tasker::addToLog('start');
for ($i = 1; $i <= $count; $i++) {
	Tasker::addToLog($i . ' of ' . $count);
	sleep(1);
}
Tasker::addToLog('finish');