<?php
namespace controllers\admin;

use controllers\BaseController;
use models\RoleModel;
use resources\Requester;

/**
 * Контроллер администратора ролей
 */
class AdminRoleController extends BaseController
{
    /**
     * @var RoleModel $role Модель роли
     * @var $roles Массив всех ролей
     */
    private $role;
    protected $roles = [];

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->role = new RoleModel(); // создается экземпляр модели роли
    }

    /**
     * Страница администрирования ролей
     */
    protected function index()
    {

        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'userData' => $this->userData,
            'roles' => $this->roles
        ]);
    }

    /**
     * Функция добавления новой роли
     */
    protected function create()
    {
        if ($this->isPost()) {
            $this->role->clear($_POST);
            $this->role->insert(['id_role' => (int)$_POST['newRoleId'], 'name_role' => $_POST['newRoleName']]);

            $newRoleId = $this->role->one('id_role', 'id_role=' . (int)$_POST['newRoleId']);
            if ($newRoleId) {
                $this->flash('Новая роль "' . $_POST['newRoleName'] . '" успешно добавлена под номером "' . $_POST['newRoleId'] . '"!');
            } else {
                $this->flash('По техническим причинам новую роль добавить не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите наименование роли!');
        }
        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'userData' => $this->userData,
            'roles' => $this->roles,
            'newRoleId' => $newRoleId['id_role']
        ]);
    }

    /**
     * Функция изменения наименования роли
     */
    protected function edit()
    {
        $roleId = Requester::id(); // получение id изменяемой роли

        if ($this->isPost()) {
            $this->role->clear($_POST);

            if ($this->role->update(['name_role' => $_POST['newRoleName']], 'id_role=' . (int)$roleId)) {
                $this->flash('Наименование роли под номером "' . (int)$roleId . '" успешно изменено на "' . $_POST['newRoleName'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить наименование роли под номером "' . (int)$roleId . '" на "' . $_POST['newRoleName'] . '" не удалось! Поробуйте позже!');
            }
        } else {
            $this->flash('Пожалуйста, введите наименование роли!');
        }
        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'userData' => $this->userData,
            'roles' => $this->roles,
            'newRoleId' => $roleId
        ]);
    }

    /**
     * Функция удаления роли
     */
    protected function remove()
    {
        $roleId = Requester::id(); // получение id удаляемой роли

        $roleName = $this->role->one('name_role', 'id_role=' . (int)$roleId);
        // var_dump($roleName);die;
        if ($this->role->delete('id_role=' . (int)$roleId)) {
            $this->flash('Роль "' . $roleName['name_role'] . '" под номером "' . (int)$roleId . '" успешно удалена!');
        } else {
            $this->flash('По техническим причинам удаление роли "' . $roleName['name_role'] . '" не удалось! Поробуйте позже!');
        }
        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'userData' => $this->userData,
            'roles' => $this->roles
        ]);
    }
}
