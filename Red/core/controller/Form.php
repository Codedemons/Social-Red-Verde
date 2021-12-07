<?php


class Form {

	public static function exists($formname){
		$fullpath = self::getFullpath($formname);
		$found=false;
		if(file_exists($fullpath)){
			$found = true;
		}
		return $found;
	}

	public static function getFullpath($formname){
		return "core/modules/".Module::$module."/forms/".$formname.".php";
	}


}



?>