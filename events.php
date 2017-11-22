<?php

$json = file_get_contents("event.json"); //Reading event file
$obj = json_decode($json);

if ( $obj->eventType == "UPDATE_RESOURCES" )
{
	$resources=array();
	$num = file_get_contents("num.txt");

        for($i=0;$i<$num;$i++)
        {
                $resources[]=[ "id"=>"CPU".$i, "type"=>"CPU","usedBy"=>null,"isUsed"=>false ];
        }
        $json2=json_encode($resources);

	file_put_contents("resources.json",$json2); //Updating resources available

	$obj->eventType = "NONE";
	$ret = file_put_contents("event.json",json_encode($obj)); //Updateing event file
}
echo $json;
?>
