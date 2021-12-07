<?php


class View {
	public static function load($view){

		if(!isset($_GET['view'])){
			include "core/modules/".Module::$module."/view/".$view."/widget-default.php";
		}else{


			if(View::isValid()){
				include "core/modules/".Module::$module."/view/".$_GET['view']."/widget-default.php";				
			}else{
				View::Error("<b>404 NOT FOUND</b> View <b>".$_GET['view']."</b> folder  !!");
			}



		}
	}

	public static function isValid(){
		$valid=false;
		if(isset($_GET["view"])){
			if(file_exists($file = "core/modules/".Module::$module."/view/".$_GET['view']."/widget-default.php")){
				$valid = true;
			}
		}
		return $valid;
	}

	public static function Error($message){
		print $message;
	}

}



?>