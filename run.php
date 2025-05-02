<?php
if ($_REQUEST['fileSrc']) {
	exec('/opt/php82/bin/php ' . 'tasks/' . $_REQUEST['fileSrc']);
}