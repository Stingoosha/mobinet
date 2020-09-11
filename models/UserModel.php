<?php
namespace models;
use PDO;

class UserModel extends BaseModel {

	private const SALT = 'some_salt_to_encrypt_login_using_md5_function';
	protected $table = 'users';

	public function isUserExists(string $login)
	{
		$login = $this->hashLogin($login);

		return $this->query("SELECT id FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);
	}

	public function createUser(string $login, string $pass)
	{
		$login = $this->hashLogin($login);
		$pass = password_hash($pass, PASSWORD_BCRYPT);

		return $this->insert(['login' => $login, 'pass' => $pass]);
	}

	public function createTempUser()
	{
		return $this->insert(['first_name' => 'temp_shmemp_user_puser']);
	}

	public function checkPass(string $login, string $pass) :int
	{
		$login = $this->hashLogin($login);
		$userData = $this->query("SELECT id, pass FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);

		if (password_verify($pass, $userData['pass'])) {
			return (int)$userData['id'];
		}

		return null;
	}

	public function hashLogin(string $login) :string
	{
		return md5(md5($login) . self::SALT);
	}

	public function validating(array $post) :bool
	{
		// TODO: validation
		$this->clear($post);
		// var_dump($_POST);die;
		return true;
	}

	public function getUserData(int $id)
	{
		return $this->query("SELECT first_name, last_name, email, male, birthday FROM $this->table WHERE id=:id", 'fetch', ['id' => $id]);
	}

	public function changeUserData(array $newUserData)
	{
		// var_dump($newUserData);die;
		$userId = (int)$_SESSION['userId'];

		return $this->update(['first_name' => $newUserData['first_name'], 'last_name' => $newUserData['last_name'], 'email' => $newUserData['email'],
		 'male' => $newUserData['male'], 'birthday' => $newUserData['birthday']], "id = $userId");
	}

	public function destroy()
	{
		unset($_SESSION['userId']);
		unset($_SESSION['userLogin']);
		if (isset($_SESSION['userName'])) {
			unset($_SESSION['userName']);
		}
	}

}
