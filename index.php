<?php 

session_start();
require_once("vendor/autoload.php");

use \Slim\Slim;
use \Hcode\Page;
use \Hcode\PageAdmin;
use \Hcode\Model\User;
use \Hcode\Model\Category;

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
//Template Usuário Logados
$app -> get("/admin/users", function(){

	User::verifyLogin();

	$users = User::listAll();
	//Métodos estático
	$page = new PageAdmin();

	$page -> setTpl("users",array(
		"users" => $users
	));

});

$app -> get("/admin/users/create", function(){

	User::verifyLogin();

	$page = new PageAdmin();

	$page -> setTpl("users-create");

});

$app ->get("/admin/users/:iduser/delete", function($iduser)
{
	//Essa rota precisa estar acima da /:iduser pois o slim poderá entender que a mesma coisa e não executar. 
	User::verifyLogin();//Precisa estar logado

	$user = new User();

	$user->get((int)$iduser);

	$user->delete();

	header("Location: /admin/users");
	exit;

});

//TPl Usuário Preenchida do banco
$app -> get("/admin/users/:iduser", function($iduser){

	User::verifyLogin();

	$user = new User();

	$user->get((int)$iduser);

	$page = new PageAdmin();

	$page -> setTpl("users-update", array(
		"user"=>$user->getValues()
	));

});

$app ->post("/admin/users/create", function()
{

	User::verifyLogin();//Precisa estar logado

	$user = new User();

	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:0;

	$user -> setData($_POST); //Cria um atributo para cada valor que tem, pois possui o mesmo nome do DB

	$user -> save();

	header("Location: /admin/users");
	exit;
});

$app ->post("/admin/users/:iduser", function($iduser)
{

	User::verifyLogin();//Precisa estar logado

	$user = new User();

	$_POST['inadmin'] = (isset($_POST['inadmin']))?1:0;

	$user->get((int)$iduser);

	$user->setData($_POST);

	$user->update();

	header("Location: /admin/users");
	exit;

});
//Iniciando Esqueci a senha//
$app->get("/admin/forgot",function()
{

	$page = new PageAdmin([
		"header" => false,
		"footer" => false
		//Desabilitando header e footer
	]);

	$page->setTpl("forgot");

});

$app->post("/admin/forgot", function()
{

	$user = User::getForgot($_POST["email"]);

	header("Location: /admin/forgot/sent");
	exit;

});

$app->get("/admin/forgot/sent", function()
	{

		$page = new PageAdmin([
		"header" => false,
		"footer" => false
		//Desabilitando header e footer
	]);

	$page->setTpl("forgot-sent");

	});

$app->get("/admin/forgot/reset", function()
{
	$user = User::validForgotDecrypt($_GET['code']);

	$page = new PageAdmin([
		"header" => false,
		"footer" => false
		//Desabilitando header e footer
	]);


	$page->setTpl("forgot-reset", array(
		"name"=>$user['desperson'],
		"code"=>$_GET["code"]
	));

});

$app->post("/admin/forgot/reset", function(){

	$forgot = User::validForgotDecrypt($_POST['code']);

	User::setForgotUsed($forgot['idrecovery']);

	$user = new User();

	$user->get((int)$forgot["iduser"]);

	$password = password_hash($_POST["password"], PASSWORD_DEFAULT, [
		'cost'=>12
	]);

	$user->setPassword($password);

	$page = new PageAdmin([
		"header" => false,
		"footer" => false
		//Desabilitando header e footer
	]);


	$page->setTpl("forgot-reset-success");

});

$app->get("/admin/categories", function()
{
	User::verifyLogin();

	$categories = Category::listAll();

	$page = new PageAdmin();

	$page->setTpl("categories",[

		'categories'=>$categories
	]);

});

$app->get("/admin/categories/create", function()
{

	User::verifyLogin();

	$page = new PageAdmin();

	$page->setTpl("categories-create");

});

$app->post("/admin/categories/create", function()
{

	User::verifyLogin();

	$category = new Category();

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;
});


$app->get("/admin/categories/:idcategory/delete", function($idcategory)//colocou na rota a variável precisa declara na função como parâmetro.
{

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->delete();

	header("Location: /admin/categories");
	exit;

});

$app->get("/admin/categories/:idcategory", function($idcategory)//colocou na rota a variável precisa declara na função como parâmetro.
{

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$page = new PageAdmin();

	$page->setTpl("categories-update", [
		'category'=>$category->getValues()
	]);
	

});

$app->post("/admin/categories/:idcategory", function($idcategory)//colocou na rota a variável precisa declara na função como parâmetro.
{

	User::verifyLogin();

	$category = new Category();

	$category->get((int)$idcategory);

	$category->setData($_POST);

	$category->save();

	header("Location: /admin/categories");
	exit;

});

$app->get("/categories/:idcategory", function($idcategory)
	{

		$category = new Category();

		$category->get((int)$idcategory);

		$page = new Page();

		$page->setTpl("category",[
			'category'=>$category->getValues(),
			'products'=>[]
		]);

	});

$app -> run();

 ?>