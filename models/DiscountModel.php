<?php
namespace models;

/**
 * Модель скидки
 */
class DiscountModel extends BaseModel
{
    /**
     * @var string $table Наименование таблицы скидок
     * @var GoodDiscountModel $goodDiscount Модель товар-скидка
     * @var PageModel $good Модель товара
    */
    protected $table = 'discounts';
    protected $goodDiscount;
    protected $good;

    public function __construct()
    {
        $this->goodDiscount = new GoodDiscountModel(); // создается экземпляр модели товар-скидка
        $this->good = new PageModel(); // создается экземпляр модели товара
    }

    /**
     * Функция обновления скидки
     * @var int $id id обновляемой скидки
     * @var array $params новые данные скидки
     * @return bool
     */
    public function updateDiscount(int $id, array $params) :bool
    {
        self::$db = $this->connect(); // подключение к БД

        try {
            self::$db->beginTransaction(); // начало транзакции

            $discountedPhones = $this->goodDiscount->allWhere('id_discount=' . $id); // определяем модели, на которые дейтсвует эта скидка
            $discountedPhones = array_column($discountedPhones, 'id_good');

            // в каждой модели перерасчитываем новую стоимость
            $this->editPrice($id, $params['newDiscountPercent'], $discountedPhones);

            // обновляем данные по самой скидке
            $this->update(['name_discount' => $params['newDiscountName'],
            'percent' => $params['newDiscountPercent'],
            'updated_at' => date('Y-m-d H:i:s')], 'id_discount=' . $id);

            self::$db->commit(); // подтверждение успешного завершения транзакции
            return true;

        } catch (\Exception $e) {
            self::$db->rollBack(); // откат всех операций
            echo "Ошибка: " . $e->getMessage();
        }
    }

    /**
     * Функция обновления списка моделей, подлежащих скидке
     * @var int $id id скидки
     * @var int $percent процент скидки
     * @var array $ids id моделей, подлежащих скидке
     * @return bool
     */
    public function saveList(int $id, int $percent, array $ids) :bool
    {
        self::$db = $this->connect(); // подключение к БД

        try {
            self::$db->beginTransaction(); // начало транзакции

            $discountedPhones = $this->goodDiscount->allWhere('id_discount=' . $id); // определяем текущие модели, на которые дейтсвует эта скидка
            $discountedPhones = array_column($discountedPhones, 'id_good');

            $addedIds = array_diff($ids, $discountedPhones); // определяем id добавляющихся моделей
            $removedIds = array_diff($discountedPhones, $ids); // определяем id удаляющихся моделей

            // var_dump($removedIds);die;
            // в каждой удаляющейся модели обнуляем новую стоимость
            $this->removePrice($removedIds);

            // в каждой добавляющейся модели перерасчитываем новую стоимость
            $this->editPrice($id, $percent, $addedIds);

            self::$db->commit(); // подтверждение успешного завершения транзакции
            return true;

        } catch (\Exception $e) {
            self::$db->rollBack(); // откат всех операций
            echo "Ошибка: " . $e->getMessage();
        }
    }

    /**
     * Функция добавления новой стоимости
     * @var int $id id скидки
     * @var int $percent процент скидки
     * @var array $ids id моделей, подлежащих скидке
     */
    public function editPrice(int $id, int $percent, array $ids)
    {
        foreach ($ids as $item) {
            $oldPrice = $this->good->one('price_good', 'id_good=' . $item)['price_good'];
            $newPrice = $oldPrice * (100 - $percent) / 100;
            // var_dump($item);die;
            $this->good->update(['new_price' => $newPrice], 'id_good=' . $item);
            if ($this->goodDiscount->allWhere('id_good=' . $item)) { // проверяем, была ли модель уже на скидке
                $this->goodDiscount->delete('id_good=' . $item); // удаляем привязку модели к прежней скидке
            }
            $this->goodDiscount->insert(['id_good' => $item,'id_discount' => $id]); // добавляем привязку модели к новой скидке
        }
    }

    /**
     * Функция удаления скидочной стоимости
     * @var array $ids id моделей, подлежащих удалению скидочной стоимости
     */
    public function removePrice(array $ids)
    {
        foreach ($ids as $id) {
            $this->goodDiscount->delete('id_good=' . $id); // удаляем привязку модели к скидке
            $this->good->update(['new_price' => NULL    ], 'id_good=' . $id); // обнуляем для модели скидочную стоимость
        }
    }
}
