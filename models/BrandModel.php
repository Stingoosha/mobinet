<?php
namespace models;

/**
 * Модель бренда
 */
class BrandModel extends BaseModel
{
    /**
     * @var string $table Наименование таблицы брендов
     */
    protected $table = 'brands';

    /**
     * Функция создания нового бренда
     * @var string $newBrand Наименование нового бренда
     * @return int
     */
    public function createBrand(string $newBrand) :int
    {
        // var_dump($newBrand);die;
        return $this->insert(['name_brand' => $newBrand]);
    }

    /**
     * Фукнция изменения наименования бренда
     * @var int $id id бренда
     * @var string $newName Новое наименование бренда
     * @return int
     */
    public function editBrand(int $id, string $newName) :int
    {
        return $this->update(['name_brand' => $newName], "id_brand = $id");
    }

    /**
     * Фукнция удаления бренда
     * @var int $id id бренда
     * @return string
     */
    public function removeBrand(int $id) :?string
    {
        $brandName = $this->query("SELECT name_brand FROM $this->table WHERE id_brand=:id_brand", 'fetch', ['id_brand' => $id]);

        if ($this->delete("id_brand = $id")) {
            return $brandName['name_brand'];
        }
        return null;
    }
}
