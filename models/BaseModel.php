<?php
namespace models;
use PDO;

class BaseModel extends AbstractModel
{
    protected const DRIVER = 'mysql';
    protected const HOST = 'localhost';
    protected const DBNAME = 'mobinet';
    protected const LOGIN = 'root';
    protected const PASS = '';
    protected const ENCODE = 'UTF8';
    protected const AS_ARRAY = PDO::FETCH_ASSOC;
    protected const AS_OBJECT = PDO::FETCH_CLASS;
    protected static $db; // соединение с базой данных
    protected $table;

    protected function connect()
    {
        if (self::$db === null) {
            self::$db = new PDO(self::DRIVER . ':host=' . self::HOST . ';dbname=' . self::DBNAME, self::LOGIN, self::PASS, [
                PDO::ATTR_ERRMODE,
                PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => self::AS_ARRAY
            ]);

            self::$db->exec('SET NAMES ' . self::ENCODE);
        }

        return self::$db;
    }

    protected function query($sql, $return, $params = [])
    {
        // var_dump($sql);die;
        self::$db = $this->connect();

        $query = self::$db->prepare($sql);
        $query->execute($params);

        $this->checkErrors($query);
        if (!$return) {
            return $query;
        } else {
            return $query->$return();
        }
    }

    protected function checkErrors($query)
    {
        $errInfo = $query->errorInfo();

        if ($errInfo[0] !== PDO::ERR_NONE) {
            echo $errInfo[2];
            exit();
        }

        return true;
    }

    public function one(int $id)
    {
        $sql = "SELECT * FROM $this->table WHERE id=:id";

        return $this->query($sql, 'fetch', ['id' => $id]);
    }

    public function some(string $table, int $limit)
    {
        $sql = "SELECT * FROM $table LIMIT $limit";

        return $this->query($sql, 'fetchAll');
    }

    public function insert($object)
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

        $query = $this->query($sql, '', $object);
        return self::$db->lastInsertId();
    }

    public function update($object, $where)
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

    public function delete($where)
    {
        $sql = "DELETE FROM $this->table WHERE $where";

        return $this->query($sql, 'rowCount');
    }
}
