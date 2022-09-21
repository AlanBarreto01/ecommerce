<?php

namespace Hcode;

use Rain\Tpl; // saber que: quando chamar "new Tpl" é do namespace Rain

class Page {

	private $tpl;
	private $options = [];
	private $defaults = [
		"header" => true,
		"footer" => true,
		"data" => []
	];

	public function __construct($opts = array(),$tpl_dir = "/views/"){
		//configurar o template

		$this->options = array_merge($this->defaults,$opts); //sobreescreve 

		$config = array(

			"tpl_dir" 	=> $_SERVER['DOCUMENT_ROOT'].$tpl_dir, // pasta para pegar arquivos html
			"cache_dir" => $_SERVER['DOCUMENT_ROOT']."/views-cache/", //tpl precisa de um cache
			"debug"     => "false"
		);
		Tpl::configure($config);
			
		$this->tpl = new Tpl;

		$this->setData($this->options["data"]);

		if ($this -> options["header"] === true) $this->tpl->draw("header");
		//desenhar header
	}

	    public function setData($data = array()){

	    	foreach ($data as $key => $value) {
            	$this->tpl->assign($key,$value);
       		}
	    }

        public function setTpl($name, $data = array(), $returnHTML = false){
            
         	$this->setData($data);

         	return $this->tpl->draw($name, $returnHTML);

        }

	public function __destruct(){

		if ($this -> options["footer"] === true) $this->tpl->draw("footer");

	}
}

?>