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
        $sql = "SELECT * FROM $this->table WHERE id_good>$lastId LIMIT " . $total;

        return $this->query($sql, 'fetchAll');
    }

    /**
     * Функция поиска товаров
     * @var string $search Условие поиска моделей пользователем
     * @return array
     */
    public function search(string $search) :array
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE name_good LIKE \'%' . $search . '%\' OR description LIKE \'%' . $search . '%\'';

        return $this->query($sql, 'fetchAll');
    }

}
