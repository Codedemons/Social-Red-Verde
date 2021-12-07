<?php

function __autoload($modelname){
	if(Model::exists($modelname)){
		include Model::getFullPath($modelname);
	} 

	if(Form::exists($modelname)){
		include Form::getFullPath($modelname);
	}
}



?>