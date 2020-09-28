<?php
namespace models;

use PDO;

/**
 * Модель пользователя
 */
class UserModel extends BaseModel
{
	/**
     * @var string $table Наименование таблицы пользователей
     */
	protected $table = 'users';

	/**
	 * Функция проверки пользователя
	 * @return array
	 */
	public function userProfile() :array
	{
		// проверяем сессию $_SESSION['userId'])
		// если есть, даем запрос в БД по id и возвращаем данные пользователя
		// если ее нет, ищем куку $_COOCKIE['remember']
		// если она есть, проверяем ее на валидность ($userId:$login . $pcName . $pcType . $wName)
		// если нормально, даем запрос в БД по id и возвращаем данные пользователя и сохраняем $_SESSION['userId'])
		// если не нормально, удаляем куку, возвращаем role=1
		// если куки тоже нет, возвращаем role=1
		if (isset($_SESSION['userId'])) {
			// var_dump($_SESSION);die;
			return $this->getUserData($_SESSION['userId'])[0];
		} else {
			if (isset($_COOKIE['remember'])) {
				$userId = $this->checkCookie($_COOKIE['remember']);
				if ($userId) {
					return $this->getUserData($userId)[0];
				} else {
					setcookie('remember', '123', time() - 3600);
				}
			}
		}
		return ['id_role' => 1];
    }

	/**
	 * Функция проверки наличия логина пользователя
	 * @var string $login Логин пользователя
	 */
	public function isUserExists(string $login)
	{
		return $this->query("SELECT id_user FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);
	}

	/**
	 * Функция создания нового пользователя
	 * @var string $login Новый логин пользователя
	 * @var string $pass Пароль пользователя
	 * @return string
	 */
	public function createUser(string $login, string $pass) :string
	{
		$pass = password_hash($pass, PASSWORD_BCRYPT);

		return $this->insert(['login' => $login, 'pass' => $pass]);
	}

	/**
	 * Функция создания временного пользователя
	 * @return string
	 */
	public function createTempUser() :string
	{
		return $this->insert(['first_name' => 'temp_shmemp_user_puser']);
	}

	/**
	 * Функция получения роли пользователя (admin, stockman, moderator или user)
	 * @var int $userId ID пользователя
	 * @var array
	 */
	public function getUserRole(int $userId) :array
	{
		return $this->query("SELECT id_role FROM $this->table WHERE id_user=:id_user", 'fetch', ['id_user' => $userId]);
	}

	/**
	 * Функция проверки введенного пароля
	 * @var string $login Логин пользователя
	 * @var string $pass Пароль пользователя
	 * @return array
	 */
	public function checkPass(string $login, string $pass) :array
	{
		$userData = $this->query("SELECT id_user, pass, first_name FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);

		if (password_verify($pass, $userData['pass'])) {
			return ['userId' => $userData['id_user'], 'userName' => $userData['first_name']];
		}

		return ['userId' => null, 'userName' => ''];
	}

	/**
	 * Функция проверки $_COOKIE['remember']
	 * @var string $cookie
	 * @return ?int
	 */
	public function checkCookie(string $cookie) :?int
	{
		$cookieParts = explode(':', $cookie);
		$userId = (int)$cookieParts[0];
		$login = $this->query("SELECT login FROM $this->table WHERE id_user=:id_user", 'fetch', ['id_user' => $userId]);
		if ($login) {
			$pcName = php_uname('n');
			$pcType = php_uname('m');
			$wName = php_uname('v');
			if (password_verify($login['login'] . $pcName . $pcType . $wName, $cookieParts[1])) {
				return $userId;
			}
		}
		return null;
	}

	/**
	 * Функция валидации введенных пользователем данных
	 * @var array $post Массив данных, введенных пользователем
	 */
	public function validating(array $post) :bool
	{
		// TODO: validation
		$this->clear($post); // очищение данных, введенных пользователем
		// var_dump($_POST);die;
		return true;
	}

	/**
	 * Функция получения данных о пользователе
	 * @var int $userId id пользователя
	 * @return array
	 */
	public function getUserData(int $userId) :array
	{
		return $this->selfJoin('login, first_name, last_name, email, male, birthday, users.id_role, name_role', 'users, roles', 'users.id_role=roles.id_role AND id_user=' . $userId);
	}

	/**
	 * Функция изменения данных о пользователе
	 * @var array $newUserData Массив новых данных о пользователе
	 */
	public function changeUserData(array $newUserData)
	{
		// var_dump($newUserData);die;
		$userId = (int)$_SESSION['userId'];

		if ($newUserData['first_name']) {
			$_SESSION['userName'] = $newUserData['first_name'];
		}

		return $this->update(['first_name' => $newUserData['first_name'], 'last_name' => $newUserData['last_name'], 'email' => $newUserData['email'],
		 'male' => $newUserData['male'], 'birthday' => $newUserData['birthday']], "id_user=$userId");
	}

}
