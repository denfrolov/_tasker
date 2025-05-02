<?php

class Tasker
{
	public static string $tasksDir = __DIR__ . '/tasks/';
	public static array $arTasks = [];
	
	public static function getTasks(): array
	{
		self::$arTasks = array_values(array_filter(scandir(self::$tasksDir), function ($v) {
			return is_file(self::$tasksDir . $v);
		}));
		return self::$arTasks;
	}
	
	public static function addToLog($addItem): void
	{
		if ($addItem == 'start') {
			$arLog = [];
		} else {
			$arLog = json_decode(file_get_contents(self::$tasksDir . '../log.json'), true);
		}
		$arLog[] = [date('d.m.Y H:i:s') => $addItem];
		$res = file_put_contents(self::$tasksDir . '../log.json', json_encode($arLog, JSON_PARTIAL_OUTPUT_ON_ERROR));
	}
}

Tasker::getTasks();