<?php

class PostImageData {
	public static $tablename = "post_image";


	public function PostImageData(){
		$this->name = "";
		$this->lastname = "";
		$this->email = "";
		$this->password = "";
		$this->created_at = "NOW()";
	}

	public function getImage(){ return ImageData::getById($this->image_id); }

	public function add(){
		$sql = "insert into ".self::$tablename." (post_id,image_id) ";
		$sql .= "value (\"$this->post_id\",\"$this->image_id\")";
		return Executor::doit($sql);
	}

	public function del(){
		$sql = "delete from ".self::$tablename." where id=$this->id";
		Executor::doit($sql);
	}

	public function update(){
		$sql = "update ".self::$tablename." set name=\"$this->name\" where id=$this->id";
		Executor::doit($sql);
	}

	public static function getById($id){
		$sql = "select * from ".self::$tablename." where id=$id";
		$query = Executor::doit($sql);
		return Model::one($query[0],new PostImageData());
	}



	public static function getAll(){
		$sql = "select * from ".self::$tablename;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostImageData());
	}
	
	public static function getAllByPostId($id){
		$sql = "select * from ".self::$tablename." where post_id=".$id;
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostImageData());
	}


	public static function getLike($q){
		$sql = "select * from ".self::$tablename." where name like '%$q%'";
		$query = Executor::doit($sql);
		return Model::many($query[0],new PostImageData());
	}


}

?>