<?php
namespace models;
use PDO;

class UserModel extends BaseModel {

	private $id;
	private $login;
	private $name;
	private $pass;
	protected $table = 'users';

	// // регистрация пользователя
	// public function reg(array $userData) :bool
	// {
	// 	// получение массива пользователей
	// 	$users = $this->getUsers();

	// 	// проверка наличия такого же логина
	// 	if ($this->checkLogin($users, $userData['login'])) {
	// 		return false;
	// 	}

	// 	// добавление пользователя
	// 	if (!$this->createUser($users, $userData)) {
	// 		return false;
	// 	}

	// 	return true;
	// }

	// // авторизация пользователя
	// public function auth(array $userData) :bool
	// {
	// 	// получение массива пользователей
	// 	$users = $this->getUsers();

	// 	// проверка соответствия логина и пароля
	// 	return $this->checkUserData($users, $userData);
	// }

	// // получение массива пользователей
	// public function getUsers() :array
	// {
	// 	$data = text_get('data/users.json');
	// 	return (array)json_decode($data);
	// }

	// проверка наличия такого же логина
	public function checkLogin(array $users, string $login) :bool
	{
		foreach($users as $user) {
			if($user->login == $login) {
				return true;
			}
		}
		return false;
	}

	// // добавление пользователя
	// public function createUser(array $users, array $userData) :bool
	// {
	// 	$users[$userData['name']]['login'] = $userData['login'];
	// 	$users[$userData['name']]['pass'] = password_hash($userData['pass'], PASSWORD_BCRYPT);
	// 	$data = json_encode($users);
	// 	text_set($data, 'data/users.json');
	// 	return true;
	// }

	// проверка соответствия логина и пароля
	public function checkUserData(array $users, array $userData) :bool
	{
		foreach($users as $user) {
			if($user->login == $userData['login']) {
				if(password_verify($userData['pass'], $user->pass)) {
					return true;
				}
				return false;
			}
		}
		return false;
	}









	public function pass ($name, $password) {
		return strrev(md5($name)) . md5($password);
	}

	public function connecting () {
		return new PDO(self::DRIVER . ':host='. self::HOST . ';dbname=' . self::DBNAME, self::LOGIN, self::PASS);
	}

	public function get ($id) {
		$connect = $this->connecting();
		return $connect->query("SELECT * FROM users WHERE id = '" . $id . "'")->fetch();
	}

	public function newR ($name, $login, $password) {
		$connect = $this->connecting();
		$user = $connect->query("SELECT * FROM users WHERE login = '" . $login . "'")->fetch();
		if (!$user) {
			$connect->exec("INSERT INTO users VALUES (null, '" . $name . "', '" . $login . "', '" . $this->pass($name, $password) . "')");
			return true;
		}
			return false;

	}

	public function login ($login, $password) {
		$connect = $this->connecting();
		$user = $connect->query("SELECT * FROM users WHERE login = '" . $login . "'")->fetch();
		if ($user) {
			if ($user['password'] == $this->pass($user['name'], strip_tags($password))) {
				$_SESSION['user_id'] = $user['id'];
				return 'Добро пожаловать в систему, ' . $user['name'] . '!';
			} else {
				return 'Пароль не верный!';
			}
		} else {
			return 'Пользователь с таким логином не зарегистрирован!';
		}
	}

	public function logout () {
		if (isset($_SESSION["user_id"])) {
			$_SESSION["user_id"]=null;
			session_destroy();
			return true;
		}
		return false;

	}

}
