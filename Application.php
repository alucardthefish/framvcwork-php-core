<?php
# **************************************************************************** 
# File: Application.php 
# Author: alucardthefish 
# Created: Sat Feb  6 19:49:00 2021 
# Description:  
# **************************************************************************** 

namespace app\core;

use app\core\db\Database;

class Application {

	#public Router $router;
	public static $ROOT_DIR;

	public $layout = 'main';
	public $userClass;
	public $router;
	public $view;
	public $request;
	public $response;
	public $session;
	public $db;
	public $user;

	public static $app;
	public $controller;
	
	public function __construct($root_path, $config) {
		$this->userClass = $config['userClass'];
		self::$ROOT_DIR = $root_path;
		self::$app = $this;
		$this->request = new Request();
		$this->response = new Response();
		$this->session = new Session();
		$this->router = new Router($this->request, $this->response);
		$this->view = new View();

		$this->db = new Database($config['db']);

		$primaryValue = $this->session->get('user');
		if ($primaryValue) {
			$primaryKey = $this->userClass::primaryKey();
			$this->user = $this->userClass::findOne([$primaryKey => $primaryValue]);
		} else {
			$this->user = null;
		}

	}

	public function run() {
		
		try {
			echo $this->router->resolve();
		} catch (\Exception $e) {
			$this->response->setStatusCode($e->getCode());
			echo $this->router->renderView('_error', [
				'exception' => $e
			]);
		}

	}

	public function setController($ctrller) {
		$this->controller = $ctrller;
	}

	public function getController() {
		return $this->controller;
	}

	public function login($user) {
		$this->user = $user;
		$primaryKey = $user->primaryKey();
		$primaryValue = $user->{$primaryKey};
		$this->session->set('user', $primaryValue);
		return true;
	}

	public function logout() {
		$this->user = null;
		$this->session->remove('user');
	}

	public static function isGuest() {
		return !self::$app->user;
	}
}

?>

