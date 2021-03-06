<?php

return [
	'TOTAL_ON_PAGE' => 12, // количество моделей на странице
	'PATH_IMG_SMALL' => 'public/img/small/', // путь к маленьким картинкам
	'PATH_IMG_LARGE' => 'public/img/large/', // путь к большим картинкам
	'WIDTH' => 160, // Ширина уменьшенных фотографий
	'HEIGHT' => 160, // Высота уменьшенных фотографий
	'QUALITY' => 100, // Качество уменьшенных фотографий
	'LOGS_AMOUNT' => 10, // количество записей, хранимых в логах
	'1MINUTE' => 60, // минута
	'1DAY' => 60 * 60 * 24, // день
	'2DAYS' => 60 * 60 * 48, // 2 дня
	'YEAR' => 60 * 60 * 24 * 365, // год
	'ORDER_STATUSES' => [ // все варианты статуса заказа
		'В процессе',
		'Доставка',
		'Обработан',
		'Отменен'
	]
];
