<?php
namespace models;
use PDO;

class UserModel extends BaseModel {

	private const SALT = 'some_salt_to_encrypt_login_using_md5_function';
	protected $table = 'users';

	/**
	 * функция проверки наличия логина пользователя
	 */
	public function isUserExists(string $login)
	{
		$login = $this->hashLogin($login);

		return $this->query("SELECT id FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);
	}

	/**
	 * функция создания нового пользователя
	 */
	public function createUser(string $login, string $pass)
	{
		$login = $this->hashLogin($login);
		$pass = password_hash($pass, PASSWORD_BCRYPT);

		return $this->insert(['login' => $login, 'pass' => $pass]);
	}

	/**
	 * функция создания временного пользователя
	 */
	public function createTempUser()
	{
		return $this->insert(['first_name' => 'temp_shmemp_user_puser']);
	}

	/**
	 * функция получения роли пользователя (admin, stockman, moderator или user)
	 */
	public function getUserRole(int $userId)
	{
		return $this->query("SELECT id_role FROM $this->table WHERE id=:id", 'fetch', ['id' => $userId]);
	}

	/**
	 * функция проверки введенного пароля
	 */
	public function checkPass(string $login, string $pass) :array
	{
		$login = $this->hashLogin($login);
		$userData = $this->query("SELECT id, pass, first_name FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);

		if (password_verify($pass, $userData['pass'])) {
			return ['userId' => $userData['id'], 'userName' => $userData['first_name']];
		}

		return ['userId' => null, 'userName' => ''];
	}

	/**
	 * функция шифрования логина
	 */
	public function hashLogin(string $login) :string
	{
		return md5(md5($login) . self::SALT);
	}

	/**
	 * функция валидации введенных пользователем данных
	 */
	public function validating(array $post) :bool
	{
		// TODO: validation
		$this->clear($post);
		// var_dump($_POST);die;
		return true;
	}

	/**
	 * функция получения данных о пользователе
	 */
	public function getUserData(int $id)
	{
		return $this->query("SELECT first_name, last_name, email, male, birthday FROM $this->table WHERE id=:id", 'fetch', ['id' => $id]);
	}

	/**
	 * функция изменения данных о пользователе
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

	/**
	 * функция удаления данных из сессии при логауте пользователя
	 */
	public function destroy()
	{
		unset($_SESSION['userId']);
		unset($_SESSION['userLogin']);
		if (isset($_SESSION['userName'])) {
			unset($_SESSION['userName']);
		}
	}

}
