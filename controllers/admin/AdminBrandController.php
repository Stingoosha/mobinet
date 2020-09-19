<?php
namespace controllers\admin;

use controllers\BaseController;
use models\BrandModel;
use resources\Requester;

/**
 * Контроллер администратора брендов
 */
class AdminBrandController extends BaseController
{
    /**
     * @var BrandModel $brand Модель бренда
     * @var array $this->brands Массив брендов
     */
	private $brand;
	protected $brands = [];

    /**
     * Функция отрабатывается перед основным action
     */
    public function before()
	{
        parent::before();
        $this->brand = new BrandModel(); // создается экземпляр модели бренда
    }

    /**
     * Страница администрирования брендов
     */
    protected function index()
    {
        $this->brands = $this->brand->all();
        // var_dump($this->brands);die;
        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $this->brands
        ]);
    }

    /**
     * Функция добавления нового бренда
     */
    protected function create()
    {
        if ($this->isPost()) {
            $this->brand->clear($_POST);
            $newBrandId = $this->brand->insert(['name_brand' => $_POST['newBrand']]);
            // var_dump($newBrandId);die;
            if ($newBrandId) {
                $this->flash('Новый бренд "' . $_POST['newBrand'] . '" успешно добавлен!');
            } else {
                $this->flash('По техническим причинам новый бренд добавить не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите наименование бренда!');
        }
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $this->brands,
            'newBrandId' => $newBrandId
        ]);
    }

    /**
     * Функция изменения наименования бренда
     */
    protected function edit()
    {
        $brandId = Requester::id(); // получение id изменяемого бренда

        if ($this->isPost()) {
            $this->brand->clear($_POST);

            if ($this->brand->update(['name_brand' => $_POST['newBrand']], 'id_brand=' . (int)$brandId)) {
                $this->flash('Наименование бренда успешно изменено на "' . $_POST['newBrand'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить наименование бренда на "' . $_POST['newBrand'] . '" не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите наименование бренда!');
        }
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $this->brands,
            'newBrandId' => $brandId
        ]);
    }

    /**
     * Функция удаления бренда
     */
    protected function remove()
    {
        $brandId = Requester::id(); // получение id удаляемого бренда

        $brandName = $this->brand->one('name_brand', 'id_brand=' . (int)$brandId);;
        // var_dump($brandName);die;
        if ($this->brand->delete('id_brand=' . (int)$brandId)) {
            $this->flash('Бренд "' . $brandName['name_brand'] . '" успешно удален!');
        } else {
            $this->flash('По техническим причинам удаление бренда "' . $brandName['name_brand'] . '" не удалось! Поробуйте позже!');
        }
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $this->brands
        ]);
    }
}
