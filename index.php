<?php
require 'init.php';
?>
<!doctype html>
<html lang="ru">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
	      content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Выполнение задач</title>
	<style>
		ul li {
			cursor: pointer;
			text-align: right;
			margin-bottom: 5px;
			list-style-type: none;
		}
		
		ul li:hover {
			color: red;
		}
		
		ul li.active {
			pointer-events: none;
			opacity: .3;
		}
	</style>
</head>
<body>
<?php
?>
<ul>
	<?php foreach (Tasker::$arTasks as $i => $task): ?>
		<li class="task" data-path="<?= $task ?>"><?= $task ?></li>
	<?php endforeach ?>
</ul>
</body>
<script>
	let taskEls = document.querySelectorAll('.task');
	let consoleData = {};
	let clearConsole = false;
	taskEls.forEach(function (taskEl) {
		taskEl.addEventListener('click', function () {
			console.clear();
			clearConsole = true;
			taskEls.forEach(function (taskEl) {
				taskEl.classList.add('active');
			});
			let xhr = new XMLHttpRequest();
			xhr.open('GET', '/_tasker/run.php?fileSrc=' + taskEl.getAttribute('data-path'), true);
			xhr.send();
		})
	});
	
	setInterval(function () {
		let xhr = new XMLHttpRequest();
		xhr.open('GET', '/_tasker/log.json', true);
		xhr.setRequestHeader("Cache-Control", "no-cache");
		xhr.onreadystatechange = function () {
			if (xhr.readyState === 4 && xhr.status === 200) {
				let data = JSON.parse(xhr.responseText);
				for (let dataKey in data) {
					let dataItem = data[dataKey];
					if (!consoleData[dataKey]) {
						if (dataItem === 'finish') {
							taskEls.forEach(function (taskEl) {
								taskEl.classList.remove('active');
							});
						}
						console.log(dataItem);
						consoleData[dataKey] = dataItem
					}
				}
			}
		};
		xhr.send();
	}, 1000)

</script>
</html>