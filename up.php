<?php


if (count($argv) <= 1 )
{
	echo "USAGE: ".$argv[0]." num_res\n";
	die();
}

$json = file_get_contents("event.json");

$obj = json_decode($json);
$obj->eventType = "UPDATE_RESOURCES";
file_put_contents("event.json",json_encode($obj));

file_put_contents("num.txt",$argv[1]);
?>
