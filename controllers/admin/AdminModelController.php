<?php
namespace controllers\admin;

use controllers\BaseController;
use models\PageModel;
use models\BrandModel;
use models\ParameterModel;
use models\DiscountModel;
use models\GoodDiscountModel;
use resources\Requester;

/**
 * Контроллер администратора моделей телефонов
 */
class AdminModelController extends BaseController
{
    /**
     * @var PageModel $phone Модель телефона
     * @var BrandModel $brand Модель бренда
     * @var ParameterModel $param Модель бренда
     */
    protected $phone;
    protected $brand;
    protected $param;

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->phone = new PageModel(); // создается экземпляр модели телефона
        $this->brand = new BrandModel(); // создается экземпляр модели бренда
        $this->param = new ParameterModel(); // создается экземпляр параметра модели телефона
    }

    /**
     * Страница администрирования телефонов
     */
    protected function index()
    {
        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $this->brands = $this->brand->all();
        // var_dump($this->layout);die;

        echo $this->blade->render('pages/admin/models', [
            'layout' => $this->layout,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'phones' => $this->phones,
            'brands' => $this->brands,
            'newPhoneId' => null
        ]);
    }

    /**
     * Функция добавления новой модели
     */
    protected function create()
    {

        $this->phone->clear($_POST);
        // var_dump($_POST);die;
        $phone = $this->phone->one('*', 'name_good="' . $_POST['newPhoneName'] . '"');

        if ($phone) {
            $newPhoneId = $phone['id_good'];
            $this->flash('Модель телефона "' . $_POST['newPhoneName'] . '" уже существует!');
        } else {
            $brand = $this->brand->one('*', 'name_brand="' . $_POST['newBrandName'] . '"');

            $newPhoneId = $this->phone->insert(['name_good' => $_POST['newPhoneName'], 'id_brand' => $brand['id_brand'], 'price_good' => $_POST['newPhonePrice']]);
            if ($newPhoneId) {
                $this->flash('Новая модель "' . $_POST['newPhoneName'] . '" успешно добавлена!');
            } else {
                $this->flash('По техническим причинам новый бренд добавить не удалось! Поробуйте позже!');
            }
        }

        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'layout' => $this->layout,
            'phones' => $this->phones,
            'brands' => $this->brands,
            'newPhoneId' => $newPhoneId
        ]);
    }
    /**
     * Страница показа детальной информации модели телефона
     */
    protected function show()
    {
        $phoneId = Requester::id(); // получение id телефона

        $phone = $this->phone->one('*', 'id_good=' . $phoneId);
        $params = $this->param->one('*', 'id_good=' . $phoneId);
        // var_dump($params);die;

        echo $this->blade->render('pages/admin/model', [
            'layout' => $this->layout,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'phone' => $phone,
            'params' => $params ?? []
        ]);
    }

    /**
     * Функция изменения основных данных телефона
     */
    protected function edit()
    {
        if ($layout['user']['id_role'] < 3) {
            $this->redirect('У Вас нет доступа к изменению данных моделей!', 'tels');
        }
        $phoneId = Requester::id(); // получение id модели

        $this->phone->clear($_POST);

        $phone = $this->phone->one('*', 'name_good="' . $_POST['newPhoneName'] . '"');

        if(isset($phone['id_good']) && $phone['id_good'] != $phoneId) {
            $phoneId = $phone['id_good'];
            $this->flash('Модель телефона "' . $_POST['newPhoneName'] . '" уже существует!');
        } else {
            $newPrice = null;
            $phone = $this->phone->one('*', 'id_good=' . $phoneId);
            $brand = $this->brand->one('*', 'name_brand="' . $_POST['newBrandName'] . '"');
            if ($phone['new_price']) {
                $goodDiscount = new GoodDiscountModel();
                $discountId = $goodDiscount->one('id_discount', 'id_good=' . $phoneId);
                $discount = new DiscountModel();
                $discountPercent = $discount->one('percent', 'id_discount=' . $discountId['id_discount']);
                // var_dump((int)$_POST['newPhonePrice']);die;
                $newPrice = (int)$_POST['newPhonePrice'] * (100 - $discountPercent['percent']) / 100;
            }

            if ($this->phone->update(['name_good' => $_POST['newPhoneName'], 'price_good' => $_POST['newPhonePrice'], 'new_price' => $newPrice, 'id_brand' => $brand['id_brand']], 'id_good=' . $phoneId)) {
                $this->flash('Данные модели "' . $_POST['newPhoneName'] . '" успешно изменены!');
            } else {
                $this->flash('По техническим причинам изменить данные модели не удалось! Поробуйте позже!');
            }
        }

        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'layout' => $this->layout,
            'phones' => $this->phones,
            'brands' => $this->brands,
            'newPhoneId' => $phoneId
        ]);
    }

    /**
     * Функция изменения дополнительных параметров телефона
     */
    public function save()
    {
        $phoneId = Requester::id(); // получение id модели

        $this->phone->clear($_POST);

        $newPhoneDesc = array_pop($_POST);

        if ($this->param->one('*', 'id_good=' . $phoneId)) {
            $this->param->update($_POST, 'id_good=' . $phoneId);
        } else {
            $_POST['id_good'] = $phoneId;
            // var_dump($_POST);die;
            $this->param->insert($_POST);
        }

        if ($newPhoneDesc) {
            $this->phone->update(['description' => $newPhoneDesc], 'id_good=' . $phoneId);
        }

        if ($_FILES["newPhonePhoto"]['name']) {
            $fileName = $_FILES['newPhonePhoto']['name'] ?? '';
            $tmpName = $_FILES['newPhonePhoto']['tmp_name'] ?? '';
            $size = $_FILES['newPhonePhoto']['size'] ?? '';
            $type = $_FILES['newPhonePhoto']['type'] ?? '';

            if ($fileName) {

                $loadResult = $this->fileUpload(self::$constants['PATH_IMG_LARGE'], $fileName, $tmpName);

                if ($loadResult) {
                    $flash = $fileName . ' успешно загружен на сервер!';
                } else {
                    $this->redirect('Ошибка загрузки файла!', 'tels/' . $phoneId);
                }

                $this->imageResize(self::$constants['PATH_IMG_LARGE'], self::$constants['PATH_IMG_SMALL'], self::$constants['WIDTH'], self::$constants['HEIGHT'], self::$constants['QUALITY'], $fileName, $fileName, $type);

                $this->phone->update(['photo' => $fileName], 'id_good=' . $phoneId);
            }

        }
        $phone = $this->phone->one('*', 'id_good=' . $phoneId);

        $this->flash('Данные модели "' . $phone['name_good'] . '" успешно изменены!');

        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $this->brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'layout' => $this->layout,
            'phones' => $this->phones,
            'brands' => $this->brands,
            'newPhoneId' => $phoneId
        ]);
    }

    /**
     * Функция удаления модели
     */
    protected function remove()
    {
        $phoneId = (int)Requester::id(); // получение id удаляемой модели

        $phoneName = $this->phone->one('name_good', 'id_good=' . $phoneId);
        // var_dump($brandName);die;
        if ($this->param->one('*', 'id_good=' . $phoneId)) {
            $this->param->delete('id_good=' . $phoneId);
        }
        if ($this->phone->delete('id_good=' . $phoneId)) {
            $flash = 'Модель телефона "' . $phoneName['name_good'] . '" успешно удалена!';
        } else {
            $flash = 'По техническим причинам удаление модели телефона "' . $phoneName['name_good'] . '" не удалось! Поробуйте позже!';
        }

        $this->redirect($flash, 'tels');
    }

    /**
     * Загружает файл в заданную директорию $newPath с заданным именем $fileName, используя временное имя $_FILES['file']['tmp_name] в качестве $fileTmpName
     * @var string $newPath Путь, куда будет сохранен файл
     * @var string $fileName Имя файла
     * @var string $fileTmpName Временное имя файла
     * @return bool
     */
    public function fileUpload(string $newPath, string $fileName, string $fileTmpName) :bool
    {
        $path = $newPath . $fileName;

        if (move_uploaded_file($fileTmpName, $path)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Изменяет размер файла расширения jpeg, используя путь к существующему файлу $oldPath, его название $photoName,
     * путь к новому файлу $newPath и параметры для нового файла (ширина - $width, высота - $height, качество - $quality)
     * @var string $oldPath Путь до исходного файла
     * @var string $newPath Путь до измененного файла
     * @var int $width Ширина измененного файла
     * @var int $height Высота измененного файла
     * @var int $quality Качество измененного файла
     * @var string $photoName Исходное наименование фотографии
     * @var string $newPhotoName Наименование измененной фотографии
     * @var string $type Тип файла
     * @return ?string
     */
    public function imageResize(
        string $oldPath,
        string $newPath,
        int $width,
        int $height,
        int $quality,
        string $photoName,
        string $newPhotoName,
        string $type) : ?string
    {
        $im1=imagecreatetruecolor($width, $height);

        switch ($type) {
            case 'image/jpeg':
                $im=imagecreatefromjpeg($oldPath . $photoName);
                imagecopyresampled($im1, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));
                imagejpeg($im1, $newPath . $newPhotoName, $quality);
                break;
            case 'image/png':
                $im = imagecreatefrompng($oldPath . $photoName);
                imagecopyresampled($im1, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));
                imagepng($im1, $newPath . $newPhotoName . '.png');
                break;
            case 'image/gif':
                $im = imagecreatefromgif($oldPath . $photoName);
                imagecopyresampled($im1, $im, 0, 0, 0, 0, $width, $height, imagesx($im), imagesy($im));
                imagegif($im1, $newPath . $newPhotoName . '.gif', $quality);
                break;
            default:
                imagedestroy($im1);
                return 'Неподходящий формат файла';
        }
        imagedestroy($im);
        imagedestroy($im1);
        return null;
    }

}
