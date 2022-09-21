<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;

$app = new \Slim\Slim();

//rota do Tpl do Usuário
$app->config('debug', true);

$app->get('/', function() {
    
	$page = new Page();

	$page->setTpl("index");

});

//rota do Tpl do Admin

$app->get('/admin', function() {

	User::verifyLogin();
    
	$page = new PageAdmin();

	$page->setTpl("index");

});
//Rota Tpl Login
$app->get('/admin/login', function() {

	$page = new PageAdmin([
		"header" => false,
		"footer" => false
		//Desabilitando header e footer
	]);

	$page -> setTpl("login");

});

$app -> post('/admin/login',function(){
	//Método estático chamadologin do namespace Model class User
	User::login($_POST["login"], $_POST["password"]);
	//Redirecionar homepage admin
	header("Location: /admin");
	exit;
});

$app -> get("/admin/logout", function(){

	User::logout();

	header("Location: /admin/login");
	exit;

});

$app -> run();

 ?>