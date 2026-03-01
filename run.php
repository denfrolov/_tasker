<?php
require 'init.php';
$fileSrc = $_REQUEST['fileSrc'];
if ($fileSrc) {
  // Закрываем сессию, если она используется
  session_write_close();

// Продолжаем выполнение даже после закрытия соединения
  ignore_user_abort(true);

// Завершаем FastCGI-запрос
  fastcgi_finish_request();

// Отправляем заголовки для закрытия соединения
  header('Content-Length: 0');
  header('Connection: close');

// Очищаем буферы
  if (ob_get_level() > 0) {
    ob_end_clean();
    ob_flush();
  }
  flush();

  $output = [];
  $return_var = 0;
  exec('/opt/php56/bin/php ' . __DIR__ . '/tasks/' . $fileSrc . ' 2>&1', $output, $return_var);

  if ($return_var !== 0 || !empty($output)) {
    Tasker::addToLog('ERROR [' . $fileSrc . ']: ' . implode("\n", $output));
  }
}
