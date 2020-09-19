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
     * @var UserModel $user Модель пользователя
     * @var RoleModel $role Модель ролей
     * @var $users Массив всех пользователей
     */
    protected $user;
    protected $role;
    protected $users = [];

	/**
	 * Функция отрабатывается перед основным action
	 */
    public function before()
	{
        parent::before();
        $this->user = new UserModel(); // создается экземпляр модели пользователя
        $this->role = new RoleModel(); // создается экземпляр модели роли
    }

    /**
     * Страница администрирования пользователей
     */
    protected function index()
    {
        $this->users = $this->user->all();
        $roles = $this->role->all();

        echo $this->blade->render('pages/admin/users', [
            'userData' => $this->userData,
            'users' => $this->users,
            'roles' => $roles
        ]);
    }

    /**
     * Страница показа детальной информации о пользователе
     */
    protected function show()
    {
        $userId = (int)Requester::id(); // получение id пользователя
        $user = $this->user->one('*', 'id=' . $userId);
        $role = $this->role->one('*', 'id_role=' . $user['id_role']);
        // var_dump($role['name_role']);die;

        echo $this->blade->render('pages/admin/user', [
            'userData' => $this->userData,
            'user' => $user,
            'roleName' => $role['name_role']
        ]);
    }

    /**
     * Функция изменения роли пользователя
     */
    protected function edit()
    {
        $userId = (int)Requester::id(); // получение id пользователя

        if ($this->isPost()) {
            $this->user->clear($_POST);
            // var_dump($_POST);die;
            $role = $this->role->one('*', 'name_role="' . $_POST['newRole'] . '"');
            // var_dump($role);die;

            if ($this->user->update(['id_role' => (int)$role['id_role']], 'id=' . $userId)) {
                $this->flash('Роль пользователя ID-' . $userId . ' успешно изменена на "' . $_POST['newRole'] . '"!');
            } else {
                $this->flash('По техническим причинам изменить роль пользователя ID-' . $userId . ' на "' . $_POST['newRole'] . '" не удалось! Поробуйте позже!');
            }
        }
        $this->users = $this->user->all();
        $roles = $this->role->all();

        echo $this->blade->render('pages/admin/users', [
            'userData' => $this->userData,
            'users' => $this->users,
            'newUserId' => $userId,
            'roles' => $roles
        ]);
    }
}
