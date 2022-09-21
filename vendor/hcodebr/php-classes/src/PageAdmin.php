<?php 

namespace Hcode;

class PageAdmin extends Page {

	public function __construct($opts = array(), $tpl_dir = "/views/admin/")
	{
		//chamando método construtor da class Page
		parent:: __construct($opts, $tpl_dir);
		//opts e tpl_dir da classe PageAdmin
	}

}

?>