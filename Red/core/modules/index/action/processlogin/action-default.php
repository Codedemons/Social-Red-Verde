<?php

if(!empty($_POST)){
	if($_POST["email"]!=""&&$_POST["password"]!=""){
		$user = UserData::getLogin($_POST["email"],sha1(md5($_POST["password"])));
		if($user!=null){
			if($user->is_active){
				Session::set("user_id",$user->id);
				Core::redir("./?view=home");
			}else{						
				Session::set("user_id",$user->id);				
				Core::redir("./?view=home");
			}
		}else{
			Core::alert("Datos incorrectos");
			Core::redir("./");
		}
	}else{
		Core::alert("Datos vacios");
		Core::redir("./");
	}
}



?>