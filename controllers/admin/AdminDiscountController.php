<?php
namespace controllers\admin;

use controllers\BaseController;
use models\DiscountModel;
use models\GoodDiscountModel;
use models\PageModel;
use resources\Requester;

/**
 * Контроллер администратора скидок
 */
class AdminDiscountController extends BaseController
{
    /**
     * @var DiscountModel $discount Модель скидки
     * @var GoodDiscountModel $goodDiscount Модель товар-скидка
     * @var PageModel $phone Модель товара
     * @var $discounts Массив всех скидок
     */
    private $discount;
    private $goodDiscount;
    private $phone;
    protected $discounts = [];

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->discount = new DiscountModel(); // создается экземпляр модели скидки
        $this->goodDiscount = new GoodDiscountModel(); // создается экземпляр модели товар-скидка
        $this->phone = new PageModel(); // создается экземпляр модели товара
    }

    /**
     * Страница администрирования скидок
     */
    protected function index()
    {

        $this->discounts = $this->discount->all();

        echo $this->blade->render('pages/admin/discounts', [
            'layout' => $this->layout,
            'discounts' => $this->discounts,
            'newDiscountId' => null
        ]);
    }

    /**
     * Функция добавления новой скидки
     */
    protected function create()
    {

        $this->discount->clear($_POST);
        $newDiscount = $this->discount->one('*', "name_discount='" . $_POST['newDiscountName'] . "'");

        // var_dump($_POST);die;
        if ($newDiscount) {
            $newDiscountId = $newDiscount['id_discount'];
            $this->flash('Скидка "' . $_POST['newDiscountName'] . '" уже существует!');
        } else {
            $newDiscountId = $this->discount->insert(['name_discount' => $_POST['newDiscountName'], 'percent' => $_POST['newDiscountPercent']]);

            if ($newDiscountId) {
                $this->flash('Новая скидка "' . $_POST['newDiscountName'] . '" успешно добавлена!');
            } else {
                $this->flash('По техническим причинам новую скидку "' . $_POST['newDiscountName'] . '" добавить не удалось! Поробуйте позже!');
            }
        }

        $this->discounts = $this->discount->all();

        echo $this->blade->render('pages/admin/discounts', [
            'layout' => $this->layout,
            'discounts' => $this->discounts,
            'newDiscountId' => $newDiscountId
        ]);
    }

    /**
     * Страница показа моделей, подлежащих скидке
     */
    protected function show()
    {
        $discountId = Requester::id(); // получение id просматриваемой скидки

        $discount = $this->discount->one('*', 'id_discount=' . $discountId);

        $this->phones = $this->phone->all();
        $discountedPhones = $this->goodDiscount->allWhere('id_discount=' . $discountId);
        if ($discountedPhones) {
            $discountedPhones = array_column($discountedPhones, 'id_good');
        } else {
            $this->flash('На скидке "' . $discount['name_discount'] . '" нет ни одной модели!');
        }

        // var_dump($discount);die;

        echo $this->blade->render('pages/admin/discount', [
            'layout' => $this->layout,
            'phones' => $this->phones,
            'phoneIds' => $discountedPhones,
            'discount' => $discount
        ]);
    }

    /**
     * Функция изменения наименования и процента скидки
     */
    protected function edit()
    {
        $discountId = Requester::id(); // получение id изменяемой скидки

        $this->discount->clear($_POST);

        $newDiscount = $this->discount->one('*', "name_discount='" . $_POST['newDiscountName'] . "'");

        // var_dump($newDiscountName);die;
        if ($newDiscount && $discountId != $newDiscount['id_discount']) {
            $discountId = $newDiscount['id_discount'];
            $this->flash('Скидка "' . $_POST['newDiscountName'] . '" уже существует!');
        } else {
            if ($this->discount->updateDiscount($discountId, $_POST)) {
                $this->flash('Скидка "' . $_POST['newDiscountName'] . '" успешно изменена!');
            } else {
                $this->flash('По техническим причинам изменить скидку на "' . $_POST['newDiscountName'] . '" не удалось! Поробуйте позже!');
            }
        }

        $this->discounts = $this->discount->all();

        echo $this->blade->render('pages/admin/discounts', [
            'layout' => $this->layout,
            'discounts' => $this->discounts,
            'newDiscountId' => $discountId
        ]);
    }

    /**
     * Функция изменения списка моделей, подлежащих скидке
     */
    public function save()
    {
        $discountId = Requester::id(); // получение id скидки

        $discount = $this->discount->one('*', 'id_discount=' . $discountId);
        $phoneIds = $_POST['phoneIds'] ?? [];
        // var_dump($_POST);die;

        if ($this->discount->saveList($discountId, $discount['percent'], $phoneIds)) {
            $this->redirect('Список моделей скидки "' . $discount['name_discount'] . '" успешно изменен!', 'discounts/' . $discountId);
        } else {
            $this->redirect('По техническим причинам список моделей скидки "' . $discount['name_discount'] . '" изменить не удалось! Попробуйте позже!', 'discounts/' . $discountId);
        }


    }

    /**
     * Функция удаления скидки
     */
    protected function remove()
    {
        $discountId = Requester::id(); // получение id удаляемой скидки

        $goods = $this->goodDiscount->allWhere('id_discount=' . $discountId);
        // var_dump($users);die;
        foreach ($goods as $good) {
            $this->good->update(['new_price' => null], 'id_good=' . $good['id_good']);
        }
        $discount = $this->discount->one('name_discount', 'id_discount=' . $discountId);
        // var_dump($discountName);die;
        if ($this->discount->delete('id_discount=' . $discountId)) {
            $flash = 'Скидка "' . $discount['name_discount'] . '" успешно удалена!';
        } else {
            $flash = 'По техническим причинам удаление скидки "' . $discount['name_discount'] . '" не удалось! Поробуйте позже!';
        }

        $this->redirect($flash, 'discounts');
    }
}
