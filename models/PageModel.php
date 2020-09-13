<?php
namespace models;

class PageModel extends BaseModel
{
    protected $table = 'goods';

    /**
     * функция вывода части товаров
     */
    public function part(int $lastId, int $total)
    {

        $sql = "SELECT * FROM $this->table WHERE id>$lastId LIMIT " . $total;

        return $this->query($sql, 'fetchAll');
    }

    /**
     * функция поиска товаров
     */
    public function search(string $search)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE name LIKE \'%' . $search . '%\' OR short_desc LIKE \'%' . $search . '%\'';

        return $this->query($sql, 'fetchAll');
    }

    public function getBrends(string $where)
    {
        $sql = "SELECT * FROM $this->table WHERE $where";

        return $this->query($sql, 'fetchAll');
    }

}
