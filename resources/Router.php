<?php
namespace resources;
/**
 * класс, отвечающий за маршрутизацию URL-запросов
 */
class Router
{
    protected static $routes = [];

	/**
	 * функция инициализации роутера
	 */
    public static function init(string $routePath) :void
    {
        // загрузка данных маршрутизации в массив
        self::$routes = include $routePath;
    }

	/**
	 * функция - роутер
	 */
    public static function routing(string $url) :array
    {
        // разделение URL на части
        $urlParts = explode("/", $url);
        // var_dump($urlParts);die;

        // Проверка наличия url
        if (!empty($urlParts[2])) {
            $url = '/' . $urlParts[2]; // 1-я часть url - обязательно строка
            if (isset($urlParts[3])) { // 2-я часть url может быть строкой или цифрой
                if ((int)$urlParts[3] > 0) { // проверка, является ли 2-я часть цифрой
                    $url .= '/{id}'; // если это цифра, то во 2-ю часть url вставляется болванка
                    Requester::getInstance()->setId((int)$urlParts[3]); // переданный id сохраняется в классе Requester
                } else {
                    $url .= '/' . $urlParts[3]; // если это строка, она добавляется во 2-ю часть url
                }
                if (isset($urlParts[4])) { // 3-я часть url - тоже обязательно строка
                    $url .= '/' . $urlParts[4];
                }
            }
        } else {
            $url = '/'; // если url пустой
        }

        // var_dump($url);die;

        // поиск созданного запроса url в массиве рутов
        if (array_key_exists($url, self::$routes)) {
            return self::$routes[$url];
        }

        // если запрос url не найден, отправляются данные последней записи массива рутов (ошибка 404)
        return self::$routes[array_key_last(self::$routes)];

    }
}
