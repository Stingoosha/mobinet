<?php
namespace models;

class PageModel extends BaseModel
{
    protected $table = 'goods';

    //
    // функция вывода части товаров
    //
    public function part(int $lastId, int $total)
    {

        $sql = "SELECT * FROM $this->table WHERE id>$lastId LIMIT " . $total;

        return $this->query($sql, 'fetchAll');
    }

}
