<?php

namespace Hcode\Model;

use \Hcode\DB\Sql;
use \Hcode\Model;
use \Hcode\Mailer;

class Category extends Model{

	public static function listAll()
	{
		//Método sem parâmetro porque lê todos os dados da tabela
		$sql = new Sql();

		return $sql -> select ("SELECT * FROM tb_categories ORDER BY descategory");
		//Junção de duas tabelas users e person
	}

	public function save()
	{

		$sql = new Sql();

		$results = $sql -> select("CALL sp_categories_save(:idcategory, :descategory)", array(
			":idcategory"=>$this->getidcategory(),
			":descategory"=>$this->getdescategory()
		));

		$this->setData($results[0]);

		Category::updateFile();

	}

	public function get($idcategory)
	{

		$sql = new Sql();

		$results = $sql->select("SELECT * FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$idcategory
		]);

		$this->setData($results[0]);//Pra colocar dentro do objeto

	}
	
	public function delete()//Não recebe parâmetro porque esperasse que ja está carregado
	{

		$sql = new Sql();

		$sql->query("DELETE FROM tb_categories WHERE idcategory = :idcategory", [
			':idcategory'=>$this->getidcategory()//Pega do próprio objeto
		]);

		Category::updateFile();

	}
	public function updateFile()
	{

		$categories = Category::listAll();

		$html =[];

		foreach ($categories as $row){
			array_push($html, '<li><a href="/categories/'.$row['idcategory'].'">'.$row['descategory'].'</a></li>'); 
			
		}
		
		file_put_contents($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR."views".DIRECTORY_SEPARATOR."categories-menu.html", implode('', $html));

	}
	
}

?>