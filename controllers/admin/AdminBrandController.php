<?php
namespace controllers\admin;

use controllers\BaseController;
use models\BrandModel;
use resources\Requester;
/**
 * Контроллер администратора сайта
 */
class AdminBrandController extends BaseController
{
    /**
     * @var BrandModel $brand Модель бренда
     */
	private $brand;

	/**
	 * Конструктор
	 */
	public function __construct()
	{
		$this->brand = new BrandModel(); // создается экземпляр бренда
    }

    /**
     * Страница администрирования брендов
     */
    protected function index()
    {
        $brands = $this->brand->all();

        // var_dump($brands);die;
        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $brands
        ]);
    }

    /**
     * Функция добавления нового бренда
     */
    protected function create()
    {
        if ($this->isPost()) {
            $this->brand->clear($_POST);
            $newBrandId = $this->brand->createBrand($_POST['newBrand']);
            // var_dump($newBrandId);die;
            if ($newBrandId) {
                $this->flash('Новый бренд "' . $_POST['newBrand'] . '" успешно добавлен!');
            } else {
                $this->flash('По техническим причинам новый бренд добавить не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите название бренда!');
        }
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $brands,
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

            if ($this->brand->editBrand($brandId, $_POST['newBrand'])) {
                $this->flash('Наименование бренда успешно изменено на "' . $_POST['newBrand'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить наименование бренда на "' . $_POST['newBrand'] . '" не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите название бренда!');
        }
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $brands,
            'newBrandId' => $brandId
        ]);
    }

    /**
     * Функция удаления бренда
     */
    protected function remove()
    {
        $brandId = Requester::id(); // получение id удаляемого бренда

        $brandName = $this->brand->removeBrand($brandId);
        // var_dump($brandName);die;
        if ($brandName) {
            $this->flash('Бренд "' . $brandName . '" успешно удален!');
        } else {
            $this->flash('По техническим причинам удаление бренда "' . $brandName . '" не удалось! Поробуйте позже!');
        }
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/brands', [
            'userData' => $this->userData,
            'brands' => $brands
        ]);
    }
}
