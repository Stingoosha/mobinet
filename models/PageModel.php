<?php
namespace models;

class PageModel extends BaseModel
{
    protected $table = 'goods';

    public function all(string $table)
    {
        $sql = "SELECT * FROM $table";

        $query = $this->query($sql);

        return $query->fetchAll();
    }



    public function part(string $table, int $lastId, int $total)
    {

        $sql = "SELECT * FROM $table WHERE id>$lastId LIMIT " . $total;

        return $this->query($sql, 'fetchAll');
    }

    public function lastId(string $table)
    {
        $sql = "SELECT MAX(id) FROM $table";

        $query = $this->query($sql);

        return $query->fetch();
    }
}
