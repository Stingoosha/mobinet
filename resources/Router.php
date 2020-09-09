<?php
namespace resources;

class Router
{
    protected static $routes = [];
    protected static $routePath;

    public static function setRoutePath(string $routePath)
    {
        self::$routePath = $routePath;
    }

    // public static function routing(string $url)
    // {
    //     self::$routes = include self::$routePath;

    //     // var_dump($url);die;
    //     if (array_key_exists($url, self::$routes)) {
    //         return self::$routes[$url];
    //     }

    //     return self::$routes[array_key_last(self::$routes)];
    // }

    //РОУТЕР!!!
    public static function routing($url)
    {
        self::$routes = include self::$routePath;

        $urlParts = explode("/", $url);
        // foreach ($urlParts as $urlPart) {
        //     $id = intval($urlPart);
        //     var_dump($id > 0);
        //     echo '<br>';
        // }
        // die;
        // var_dump($urlParts[3] === (int)$urlParts[3]);die;
        if (!empty($urlParts[2])) {
            $url = '/' . $urlParts[2];//Часть имени класса контроллера
            if (isset($urlParts[3])) {
                if ((int)$urlParts[3] > 0) {
                    $url .= '/{id}';
                    Requester::getInstance()->setId((int)$urlParts[3]);
                } else {
                    $url .= '/' . $urlParts[3];//часть имени метода
                }
                if (isset($urlParts[4])) {//формальный параметр для метода контроллера
                    $url .= '/' . $urlParts[4];
                }
            }
        } else {
            $url = '/';
        }

        // var_dump($url);die;
        if (array_key_exists($url, self::$routes)) {
            return self::$routes[$url];
        }

        return self::$routes[array_key_last(self::$routes)];

        // if (isset($_GET['page'])) {
        //     $controllerName = ucfirst($_GET['page']) . 'Controller';//IndexController
        //     $methodName = isset($_GET['action']) ? $_GET['action'] : 'index';
        //     $controller = new $controllerName();

        //     //Ключи данного массива доступны в любой вьюшке
        //     //Массив data - это массив для использования в любой вьюшке
        //     $data = [
        //         'content_data' => $controller->$methodName($_GET),
        //         'title' => $controller->title,
        //         'categories' => Category::getCategories(0)
        //     ];

        //     $view = $controller->view . '/' . $methodName . '.html';
        //     if (!isset($_GET['asAjax'])) {
        //         $loader = new Twig_Loader_Filesystem(Config::get('path_templates'));
        //         $twig = new Twig_Environment($loader);
        //         $template = $twig->loadTemplate($view);


        //         echo $template->render($data);
        //     } else {
        //         echo json_encode($data);
        //     }
        // }
    }
}
