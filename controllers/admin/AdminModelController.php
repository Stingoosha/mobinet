<?php
namespace controllers\admin;

use controllers\BaseController;
use models\PageModel;
use models\BrandModel;
use resources\Requester;

/**
 * Контроллер администратора моделей телефонов
 */
class AdminModelController extends BaseController
{
    /**
     * @var PageModel $phone Модель телефона
     * @var BrandModel $brand Модель бренда
     * @var $phones Массив всех телефонов
     */
    protected $phone;
    protected $brand;
    protected $phones = [];

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->phone = new PageModel(); // создается экземпляр модели телефона
        $this->brand = new BrandModel(); // создается экземпляр модели бренда
    }

    /**
     * Страница администрирования телефонов
     */
    protected function index()
    {
        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $brands = $this->brand->all();
        // var_dump($brands);die;

        echo $this->blade->render('pages/admin/models', [
            'userData' => $this->userData,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'phones' => $this->phones,
            'brands' => $brands
        ]);
    }

    /**
     * Функция добавления новой модели
     */
    protected function create()
    {
        if ($this->isPost()) {
            $this->phone->clear($_POST);
            // var_dump($_POST);die;
            $brand = $this->brand->one('*', 'name_brand="' . $_POST['newBrandName'] . '"');

            $newPhoneId = $this->phone->insert(['name' => $_POST['newPhoneName'], 'id_brand' => $brand['id_brand'], 'price' => $_POST['newPhonePrice']]);
            if ($newPhoneId) {
                $this->flash('Новая модель "' . $_POST['newPhoneName'] . '" успешно добавлена!');
            } else {
                $this->flash('По техническим причинам новый бренд добавить не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите корректные данные!');
        }
        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'userData' => $this->userData,
            'phones' => $this->phones,
            'brands' => $brands,
            'newPhoneId' => $newPhoneId
        ]);
    }
    /**
     * Страница показа детальной информации модели телефона
     */
    protected function show()
    {
        $phoneId = (int)Requester::id(); // получение id телефона
        $phone = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand AND goods.id=' . $phoneId);
        // var_dump($phone[0]);die;

        echo $this->blade->render('pages/admin/model', [
            'userData' => $this->userData,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'phone' => $phone[0]
        ]);
    }

    /**
     * Функция изменения основных данных телефона
     */
    protected function edit()
    {
        $phoneId = (int)Requester::id(); // получение id модели

        $this->phone->clear($_POST);
        // var_dump($_POST);die;
        $brand = $this->brand->one('*', 'name_brand="' . $_POST['newBrandName'] . '"');
        // var_dump($role);die;

        if ($this->phone->update(['name' => $_POST['newPhoneName'], 'price' => $_POST['newPhonePrice'], 'id_brand' => $brand['id_brand']], 'id=' . $phoneId)) {
            $this->flash('Данные модели успешно изменены!');
        } else {
            $this->flash('По техническим причинам изменить данные модели не удалось! Поробуйте позже!');
        }

        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'userData' => $this->userData,
            'pathImgSmall' => self::$constants['PATH_IMG_SMALL'],
            'phones' => $this->phones,
            'brands' => $brands,
            'newPhoneId' => $phoneId
        ]);
    }

    /**
     * Функция изменения дополнительных параметров телефона
     */
    public function save()
    {
        $phoneId = (int)Requester::id(); // получение id модели

        $this->phone->clear($_POST);
        // var_dump($_POST);die;
        if (isset($_FILES)) {
            $fileName = $_FILES['newPhonePhoto']['name'] ?? '';
            $tmpName = $_FILES['newPhonePhoto']['tmp_name'] ?? '';
            $size = $_FILES['newPhonePhoto']['size'] ?? '';
            $type = $_FILES['newPhonePhoto']['type'] ?? '';

            if ($fileName) {

                $loadResult = $this->fileUpload(self::$constants['PATH_IMG_LARGE'], $fileName, $tmpName);

                if ($loadResult) {
                    $this->flash($fileName . ' успешно загружен на сервер!');
                } else {
                    $this->redirect('Ошибка загрузки файла!', 'tels/' . $phoneId);
                }

                $this->imageResize(self::$constants['PATH_IMG_LARGE'], self::$constants['PATH_IMG_SMALL'], self::$constants['WIDTH'], self::$constants['HEIGHT'], self::$constants['QUALITY'], $fileName, $fileName, $type);

                $this->phone->update(['photo' => $fileName], 'id=' . $phoneId);
            }

        }

        if ($this->phone->update(['short_desc' => $_POST['newPhoneDesc']], 'id=' . $phoneId)) {
            $this->redirect('Данные модели успешно изменены!', 'tels/' . $phoneId);
        } else {
            $this->redirect('По техническим причинам данные модели изменить не удалось! Поробуйте позже!', 'tels/' . $phoneId);
        }

    }

    /**
     * Функция удаления модели
     */
    protected function remove()
    {
        $phoneId = (int)Requester::id(); // получение id удаляемой модели

        $phoneName = $this->phone->one('name', 'id=' . $phoneId);;
        // var_dump($brandName);die;
        if ($this->phone->delete('id=' . $phoneId)) {
            $this->flash('Модель телефона "' . $phoneName['name'] . '" успешно удалена!');
        } else {
            $this->flash('По техническим причинам удаление модели телефона "' . $phoneName['name'] . '" не удалось! Поробуйте позже!');
        }
        $this->brands = $this->brand->all();

        $this->phones = $this->phone->selfJoin('*', 'goods, brands', 'goods.id_brand=brands.id_brand');
        $brands = $this->brand->all();

        echo $this->blade->render('pages/admin/models', [
            'userData' => $this->userData,
            'phones' => $this->phones,
            'brands' => $brands
        ]);
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
