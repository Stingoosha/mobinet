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
	 * Функция проверки наличия логина пользователя
	 * @var string $login Логин пользователя
	 */
	public function isUserExists(string $login)
	{
		// $login = $this->hashLogin($login);

		return $this->query("SELECT id FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);
	}

	/**
	 * Функция создания нового пользователя
	 * @var string $login Новый логин пользователя
	 * @var string $pass Пароль пользователя
	 * @return string
	 */
	public function createUser(string $login, string $pass) :string
	{
		// $login = $this->hashLogin($login);
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
		return $this->query("SELECT id_role FROM $this->table WHERE id=:id", 'fetch', ['id' => $userId]);
	}

	/**
	 * Функция проверки введенного пароля
	 * @var string $login Логин пользователя
	 * @var string $pass Пароль пользователя
	 * @return array
	 */
	public function checkPass(string $login, string $pass) :array
	{
		// $login = $this->hashLogin($login);
		$userData = $this->query("SELECT id, pass, first_name FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);

		if (password_verify($pass, $userData['pass'])) {
			return ['userId' => $userData['id'], 'userName' => $userData['first_name']];
		}

		return ['userId' => null, 'userName' => ''];
	}

	/**
	 * Функция шифрования логина с использованием соли
	 * @var string $login Логин пользователя
	 * @return string
	 */
	// public function hashLogin(string $login) :string
	// {
	// 	return md5(md5($login) . self::$database['SALT']);
	// }

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
		return $this->query("SELECT login, first_name, last_name, email, male, birthday, id_role FROM $this->table WHERE id=:id",
		 'fetch', ['id' => $userId]);
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
		 'male' => $newUserData['male'], 'birthday' => $newUserData['birthday']], "id = $userId");
	}

}
