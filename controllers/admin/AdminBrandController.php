<?php
namespace controllers\admin;

use controllers\BaseController;
use models\BrandModel;
use models\PageModel;
use resources\Requester;

/**
 * Контроллер администратора брендов
 */
class AdminBrandController extends BaseController
{
    /**
     * @var BrandModel $brand Модель бренда
     */
	private $brand;

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
            'layout' => $this->layout,
            'brands' => $this->brands,
            'newBrandId' => null
        ]);
    }

    /**
     * Функция добавления нового бренда
     */
    protected function create()
    {

        $this->brand->clear($_POST);
        $newBrand = $this->brand->one('*', "name_brand='" . $_POST['newBrand'] . "'");

        // var_dump($_POST);die;
        if ($newBrand) {
            $newBrandId = $newBrand['id_brand'];
            $this->flash('Бренд "' . $_POST['newBrand'] . '" уже существует!');
        } else {
            $newBrandId = $this->brand->insert(['name_brand' => $_POST['newBrand']]);

            if ($newBrandId) {
                $this->flash('Новый бренд "' . $_POST['newBrand'] . '" успешно добавлен!');
            } else {
                $this->flash('По техническим причинам новый бренд "' . $_POST['newBrand'] . '" добавить не удалось! Поробуйте позже!');
            }
        }

        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'layout' => $this->layout,
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

        $this->brand->clear($_POST);
        $newBrandId = $this->brand->one('*', "name_brand='" . $_POST['newBrand'] . "'");

        // var_dump($newBrandId);die;
        if ($newBrandId) {
            $brandId = $newBrandId['id_brand'];
            $this->flash('Бренд "' . $_POST['newBrand'] . '" уже существует!');
        } else {
            if ($this->brand->update(['name_brand' => $_POST['newBrand']], 'id_brand=' . $brandId)) {
                $this->flash('Наименование бренда успешно изменено на "' . $_POST['newBrand'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить наименование бренда на "' . $_POST['newBrand'] . '" не удалось! Поробуйте позже!');
            }
        }

        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'layout' => $this->layout,
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

        // $phone = new PageModel();
        // $this->phones = $phone->allWhere('id_brand=' . $brandId);

        // var_dump($this->phones);die;
        $brandName = $this->brand->one('name_brand', 'id_brand=' . $brandId);;
        if ($this->brand->delete('id_brand=' . $brandId)) {
            $this->flash('Бренд "' . $brandName['name_brand'] . '" успешно удален!');
        } else {
            $this->flash('По техническим причинам удаление бренда "' . $brandName['name_brand'] . '" не удалось! Поробуйте позже!');
        }
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'layout' => $this->layout,
            'brands' => $this->brands
        ]);
    }
}
