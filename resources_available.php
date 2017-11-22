<?php

if (!isset($_REQUEST["key"]))
{
	die("Key is required");
}

$key=$_REQUEST["key"];

$last_key=file_get_contents("current_key.txt");

if($last_key != $key )
{
	file_put_contents("current_key.txt",$key);

	$resources=array();
	for($i=0;$i<10;$i++)
	{
		$resources[]=array(
			"id"=>"CPU".$i,
			"type"=>"CPU",
			"usedBy"=>null,
			"isUsed"=>false);
	}
	$json=json_encode($resources);

	file_put_contents("resources.json",$json);
}
else
{
	$json=file_get_contents("resources.json");
}


echo $json;
