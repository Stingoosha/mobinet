<?php
namespace models;

use PDO;

/**
 * Базовая модель сайта
 */
class BaseModel extends AbstractModel
{
    /**
     * @var static array $database Массив настроек базы данных
     * @var static PDO $db Экземляр класса для соединения с базой данных
     * @var string $table Таблица, используемая моделью
     */
    protected static $database = [];
    protected static $db;
    protected $table;

    /**
	 * Функция инициализации базовой модели (подключение настроек базы данных)
     * @var string $databasePath Путь до массива с настройками
     * @return void
	 */
    public static function init(string $databasePath) :void
    {
        self::$database = include $databasePath;
    }

    /**
     * Функция подключения к БД (Singleton)
     * @return PDO
     */
    protected function connect() :PDO
    {
        if (self::$db === null) {
            self::$db = new PDO(self::$database['DRIVER'] . ':host=' . self::$database['HOST'] .
            ';dbname=' . self::$database['DBNAME'], self::$database['LOGIN'], self::$database['PASS'], [
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => self::$database['AS_ARRAY']
            ]);

            self::$db->exec('SET NAMES ' . self::$database['ENCODE']);
        }

        return self::$db;
    }

    /**
     * Унифицированная функция запроса к БД через подготовленный запрос
     * @var string $sql Строка SQL-запроса
     * @var string $return Строка с названием возвращаемой функции
     * @var array $params Массив параметров для подготовленного запроса (по умолчанию пустой)
     * @return Может возвращать различные типы данных
     */
    protected function query($sql, $return, $params = [])
    {
        // var_dump($sql);die;
        self::$db = $this->connect(); // соединение с БД

        $query = self::$db->prepare($sql); // подготовка SQL-запроса
        $query->execute($params); // выполнение SQL-запроса

        $this->checkErrors($query); // проверка на ошибки SQL-запроса
        if (!$return) {
            return $query;
        } else {
            return $query->$return();
        }
    }

    /**
     * Функция проверки SQL-запроса на ошибки
     * @var PDOStatement $query подготовленный SQL-запрос
     * @return bool
     */
    protected function checkErrors(\PDOStatement $query) :bool
    {
        $errInfo = $query->errorInfo();

        if ($errInfo[0] !== PDO::ERR_NONE) {
            echo $errInfo[2];
            exit();
        }

        return true;
    }

    /**
     * Функция вывода данных модели по его id
     * @var int $id Идентификационный номер id модели
     * @return array
     */
    public function one(int $id) :array
    {
        $sql = "SELECT * FROM $this->table WHERE id=:id";

        return $this->query($sql, 'fetch', ['id' => $id]);
    }

    /**
     * Функция вывода всех данных таблицы
     * @return array
     */
    public function all() :array
    {
        $sql = "SELECT * FROM $this->table";

        return $this->query($sql, 'fetchAll');
    }

    /**
     * Функция вывода ограниченного количества данных таблицы
     * @var int $limit Максимальное количество моделей
     * @return array
     */
    public function some(int $limit) :array
    {
        $sql = "SELECT * FROM $this->table LIMIT $limit";

        return $this->query($sql, 'fetchAll');
    }

    /**
     * Функция добавления данных в таблицу
     * @var array $object Массив данных для подготовленного SQL-запроса
     * @return string
     */
    public function insert(array $object) :string
    {
        $columns = array();

        foreach ($object as $key => $value) {
            $columns[] = $key;
            $masks[] = "'$value'";

            if ($value === null) {
                $object[$key] = 'NULL';
            }
        }

        $columns_s = implode(',', $columns);
        $masks_s = implode(',', $masks);

        $sql = "INSERT INTO $this->table ($columns_s) VALUES ($masks_s)";

        $this->query($sql, '', $object);
        return self::$db->lastInsertId();
    }

    /**
     * Функция обновления данных таблицы
     * @var array $object Массив данных для подготовленного SQL-запроса
     * @var string $where Условие, согласно которому будет произведено обновление
     * @return string
     */
    public function update(array $object, string $where) :string
    {
        $sets = array();

        foreach($object as $key => $value){

            $sets[] = "$key='$value'";

            if($value === NULL){
                $object[$key]='NULL';
            }
        }

        $sets_s = implode(',',$sets);
        $sql = "UPDATE $this->table SET $sets_s WHERE $where";

        return $this->query($sql, 'rowCount', $object);
    }

    /**
     * Функция удаления данных из таблицы
     * @var string Условие, согласно которому будет произведено удаление
     * @return string
     */
    public function delete(string $where) :string
    {
        $sql = "DELETE FROM $this->table WHERE $where";

        return $this->query($sql, 'rowCount');
    }

    /**
     * Функция очитски данных, вводимых пользователем и сохранение их в массиве POST
     * @var array $post Массив данных, которые ввел пользователь
     * @return void
     */
    public function clear(array $post) :void
	{
        // var_dump($post);die;
		foreach ($post as $key => $val) {
			$_POST[$key] = htmlspecialchars(strip_tags(trim($val)));
		}
    }

    /**
     * Функция возвращает нужный суффикс в зависимости от числа, (например, 1 модел/ь, 2 модел/и, 5 модел/ей)
     * @var int $amount Количество, к которому необходимо подобрать суффикс
     * @var array $variants Варианты суффиксов, из которых выбирается ответ
     * @return string
     */
    public function getSpoiler(int $amount, array $variants) :string
    {
        $remain = $amount % 10;
        if ($remain == 1 && ($amount < 10 || $amount > 20)) {
            return $variants[0];
        } elseif (($remain > 1 && $remain < 5) && ($amount < 10 || $amount > 20)) {
            return $variants[1];
        } else {
            return $variants[2];
        }
    }
}
