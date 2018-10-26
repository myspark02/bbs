
<?php
require_once("boardDao.php");

$file = fopen("rows.txt","r");
$dao = new boardDao();
while(! feof($file))
  {
  	/* 한줄씩 읽어서 ","를 기준으로 추출한 데이터를 1차원 
  	배열로 만들어 준다. fgetcsv();
  	*/
  	$data = fgetcsv($file);  
  	/*
  	for($i = 0; $i < count($data); $i++) {
  		//echo $data[$i], " ";

  	}
  	*/
  	//echo "<br>";

  	$dao->insertMsg($data[0], $data[1], $data[2]);
  }

fclose($file);

header("Location: board.php");
?>
