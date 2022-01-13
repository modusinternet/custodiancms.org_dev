<?php
	header("Content-Type: application/javascript; charset=utf-8");
	header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
	header("Cache-Control: post-check=0, pre-check=0", false);
	header("Pragma: no-cache");

	require_once $_SERVER["DOCUMENT_ROOT"] . "/ccmspre/config.php";

	if(!strstr($_SERVER["HTTP_REFERER"], $CFG["DOMAIN"])) {
		exit('No direct script access allowed');
	}



//header("aaaRequestMethod: ".$CLEAN["jsgrid_ajax"]);




	if($CLEAN["jsgrid_ajax"] == "") {
		$error_message = "'jsgrid_ajax' field missing content.";
	} elseif ($CLEAN["jsgrid_ajax"] == "MINLEN") {
		$error_message = "'jsgrid_ajax' field is too short, must be 8 or more characters in length.";
	} elseif ($CLEAN["jsgrid_ajax"] == "INVAL") {
		$error_message = "'jsgrid_ajax' field error, indeterminate.";

	}

if(!$error_message) {








//$method = $_SERVER['REQUEST_METHOD'];





//if($method == 'GET')
if($CLEAN["jsgrid_ajax"] == 'load'){
 $data = array(
  ':first_name'   => "%" . $_GET['first_name'] . "%",
  ':last_name'   => "%" . $_GET['last_name'] . "%",
  ':age'     => "%" . $_GET['age'] . "%",
  ':gender'    => "%" . $_GET['gender'] . "%"
 );
 $query = "SELECT * FROM sample_data WHERE first_name LIKE :first_name AND last_name LIKE :last_name AND age LIKE :age AND gender LIKE :gender ORDER BY id DESC";

 $statement = $CFG["DBH"]->prepare($query);
 $statement->execute($data);
 $result = $statement->fetchAll();
 foreach($result as $row)
 {
  $output[] = array(
   'id'    => $row['id'],
   'first_name'  => $row['first_name'],
   'last_name'   => $row['last_name'],
   'age'    => $row['age'],
   'gender'   => $row['gender']
  );
 }
 header("Content-Type: application/json");
 echo json_encode($output);
}

//if($method == "POST")
if($CLEAN["jsgrid_ajax"] == 'insert'){
 $data = array(
  ':first_name'  => $_POST['first_name'],
  ':last_name'  => $_POST["last_name"],
  ':age'    => $_POST["age"],
  ':gender'   => $_POST["gender"]
 );

 $query = "INSERT INTO sample_data (first_name, last_name, age, gender) VALUES (:first_name, :last_name, :age, :gender)";
 $statement = $CFG["DBH"]->prepare($query);
 $statement->execute($data);
}

//if($method == 'PUT')
if($CLEAN["jsgrid_ajax"] == 'update'){
 parse_str(file_get_contents("php://input"), $_POST);
 $data = array(
  ':id'   => $_POST['id'],
  ':first_name' => $_POST['first_name'],
  ':last_name' => $_POST['last_name'],
  ':age'   => $_POST['age'],
  ':gender'  => $_POST['gender']
 );
 $query = "
 UPDATE sample_data
 SET first_name = :first_name,
 last_name = :last_name,
 age = :age,
 gender = :gender
 WHERE id = :id
 ";
 $statement = $CFG["DBH"]->prepare($query);
 $statement->execute($data);
}

//if($method == "DELETE")
if($CLEAN["jsgrid_ajax"] == 'delete'){
 parse_str(file_get_contents("php://input"), $_POST);
 $query = "DELETE FROM sample_data WHERE id = '".$_POST["id"]."'";
 $statement = $CFG["DBH"]->prepare($query);
 $statement->execute();
}




}
