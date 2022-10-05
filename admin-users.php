<?php

use \Hcode\PageAdmin;
use \Hcode\Model\User;

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

?>