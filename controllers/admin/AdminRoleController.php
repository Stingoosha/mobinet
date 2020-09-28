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
            'layout' => $this->layout,
            'roles' => $this->roles,
            'newRoleId' => null
        ]);
    }

    /**
     * Функция добавления новой роли
     */
    protected function create()
    {

        $this->role->clear($_POST);

        $roleId = $this->role->one('*', 'id_role="' . $_POST['newRoleId'] . '"');
        $roleName = $this->role->one('*', 'name_role="' . $_POST['newRoleName'] . '"');
        // var_dump($roleName);die;

        if ($roleId) {
            $newRole = $roleId;
            $this->flash('Роль номер "' . $newRole['id_role'] . '" уже существует');
        } elseif ($roleName) {
            $newRole = $roleName;
            $this->flash('Роль "' . $newRole['name_role'] . '" уже существует');
        } else {

            $this->role->insert(['id_role' => (int)$_POST['newRoleId'], 'name_role' => $_POST['newRoleName']]);

            $newRole = $this->role->one('id_role', 'id_role=' . (int)$_POST['newRoleId']);
            if ($newRole) {
                $this->flash('Новая роль "' . $_POST['newRoleName'] . '" успешно добавлена под номером "' . $_POST['newRoleId'] . '"!');
            } else {
                $this->flash('По техническим причинам новую роль добавить не удалось! Поробуйте позже!');
            }
        }

        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'layout' => $this->layout,
            'roles' => $this->roles,
            'newRoleId' => $newRole['id_role']
        ]);
    }

    /**
     * Функция изменения наименования роли
     */
    protected function edit()
    {
        $roleId = Requester::id(); // получение id изменяемой роли

        $this->role->clear($_POST);

        if ($this->role->update(['name_role' => $_POST['newRoleName']], 'id_role=' . (int)$roleId)) {
            $this->flash('Наименование роли под номером "' . (int)$roleId . '" успешно изменено на "' . $_POST['newRoleName'] . '"!');
        } else {
            $this->flash('По техническим причинам изменить наименование роли под номером "' . (int)$roleId . '" на "' . $_POST['newRoleName'] . '" не удалось! Поробуйте позже!');
        }

        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/roles', [
            'layout' => $this->layout,
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

        $users = $this->user->allWhere('id_role=' . $roleId);
        // var_dump($users);die;
        if ($users) {
            $flash = 'Нельзя удалить роль, выполняемую пользователями!';
        } else {

            $roleName = $this->role->one('name_role', 'id_role=' . $roleId);
            // var_dump($roleName);die;
            if ($this->role->delete('id_role=' . $roleId)) {
                $flash = 'Роль "' . $roleName['name_role'] . '" под номером "' . $roleId . '" успешно удалена!';
            } else {
                $flash = 'По техническим причинам удаление роли "' . $roleName['name_role'] . '" не удалось! Поробуйте позже!';
            }
        }

        $this->redirect($flash, 'roles');
    }
}
