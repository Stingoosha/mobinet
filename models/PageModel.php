<?php
namespace models;

/**
 * Модель страницы показа моделей
 */
class PageModel extends BaseModel
{
    /**
     * @var string $table Наименование таблицы моделей
     */
    protected $table = 'goods';

    /**
     * Функция вывода части товаров
     * @var int $lastId ID последней модели на странцие
     * @var int $total Количество выводимых моделей
     * @return array
     */
    public function part(int $lastId, int $total) :array
    {
        $sql = "SELECT * FROM $this->table WHERE id>$lastId LIMIT " . $total;

        return $this->query($sql, 'fetchAll');
    }

    /**
     * Функция поиска товаров
     * @var string $search Условие поиска моделей пользователем
     * @return array
     */
    public function search(string $search) :array
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE name LIKE \'%' . $search . '%\' OR short_desc LIKE \'%' . $search . '%\'';

        return $this->query($sql, 'fetchAll');
    }

    /**
     * Функция получения моделей по всем отмеченным брендам
     * @var string $where Условие, содержащее id всех брендов
     * @return array
     */
    public function getBrends(string $where) :array
    {
        $sql = "SELECT * FROM $this->table WHERE $where";

        return $this->query($sql, 'fetchAll');
    }

}
