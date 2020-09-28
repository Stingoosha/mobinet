<?php
namespace controllers\admin;

use controllers\BaseController;
use models\UserModel;
use models\RoleModel;
use resources\Requester;
/**
 * Контроллер администратора пользователей
 */
class AdminUserController extends BaseController
{
    /**
     * @var RoleModel $role Модель ролей
     * @var $users Массив всех пользователей
     * @var $roles Массив всех ролей
     */
    protected $role;
    protected $users = [];
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
     * Страница администрирования пользователей
     */
    protected function index()
    {
        $this->users = $this->user->all();
        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/users', [
            'layout' => $this->layout,
            'users' => $this->users,
            'roles' => $this->roles,
            'newUserId' => null
        ]);
    }

    /**
     * Страница показа детальной информации о пользователе
     */
    protected function show()
    {
        $userId = Requester::id(); // получение id пользователя
        $user = $this->user->one('*', 'id_user=' . $userId);
        $role = $this->role->one('*', 'id_role=' . $user['id_role']);
        // var_dump($role['name_role']);die;

        echo $this->blade->render('pages/admin/user', [
            'layout' => $this->layout,
            'user' => $user,
            'roleName' => $role['name_role']
        ]);
    }

    /**
     * Функция изменения роли пользователя
     */
    protected function edit()
    {
        $userId = Requester::id(); // получение id пользователя

        $this->user->clear($_POST);
        // var_dump($_POST);die;
        $role = $this->role->one('*', 'name_role="' . $_POST['newRole'] . '"');
        // var_dump($role);die;

        if ($this->user->update(['id_role' => (int)$role['id_role']], 'id_user=' . $userId)) {
            $this->flash('Роль пользователя ID-' . $userId . ' успешно изменена на "' . $_POST['newRole'] . '"!');
        } else {
            $this->flash('По техническим причинам изменить роль пользователя ID-' . $userId . ' на "' . $_POST['newRole'] . '" не удалось! Поробуйте позже!');
        }

        $this->users = $this->user->all();
        $this->roles = $this->role->all();

        echo $this->blade->render('pages/admin/users', [
            'layout' => $this->layout,
            'users' => $this->users,
            'newUserId' => $userId,
            'roles' => $this->roles
        ]);
    }
}
