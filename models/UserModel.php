<?php
namespace models;
use PDO;

class UserModel extends BaseModel {

	private const SALT = 'some_salt_to_encrypt_login_using_md5_function';
	protected $table = 'users';

	// TODO: все функции

	public function isUserExists(string $login)
	{
		$login = md5(md5($login) . self::SALT);

		return $this->query("SELECT id FROM $this->table WHERE login=:login", 'fetch', ['login' => $login]);
	}

	public function createUser(string $login, string $pass)
	{
		$login = md5(md5($login) . self::SALT);
		$pass = password_hash($pass, PASSWORD_BCRYPT);

		return $this->insert(['login' => $login, 'pass' => $pass]);
	}

}
