<?php

$RETRY = 40;
$password = file_get_contents("password.txt");

$conn = libvirt_connect("qemu:///system", false, ["netgroup",$password]);
if ( $conn === false )
{
        header("HTTP/1.0 500 Errore");
        die();
}

$resources = file_get_contents('php://input');

$arr = json_decode($resources);

$c= countResources($arr);


foreach ($c as $impl => $resource )
{
	$res = lookup_by_vnf_name($impl,$conn);

	foreach ($resource as $type => $number )
	{
		if ( $type == "CPU" )
		{
			for ($t=0; $t < $RETRY; $t++ )
			{
				$ret = libvirt_domain_change_vcpus($res, $number, 1+8); // live+guest
				if ( $ret )
				{
					break;
				}
				sleep(2);
			}
			if (!$ret)
			{
			        header("HTTP/1.0 500 Errore");
				die();
			}

		}
	}
}

file_put_contents("resources.json",$resources);


function countResources($arr)
{
	$ret=array();

	foreach ($arr as $obj)
	{
		if ($obj->isUsed )
		{
			$impl=$obj->usedBy;
			if ($impl != null )
			{
				$type=$obj->type;

				if (!isset($ret[$impl]))
				{
					$ret[$impl]=array();
				}
				if(!isset($ret[$impl][$type]))
				{
					$ret[$impl][$type]=0;
				}
				$ret[$impl][$type]++;
			}
		}
	}

	return $ret;
}



function lookup_by_vnf_name($vnf_name,$conn)
{
	$doms = libvirt_list_domains($conn);

	$name="";
	foreach ($doms as $dom)
	{
		if ( strpos($dom,"_".$vnf_name) !== FALSE)
		{
			$name=$dom;
			break;
		}
	}

	if ($name=="")
	{
        	header("HTTP/1.0 500 Errore");
        	die();
	}

	$res = libvirt_domain_lookup_by_name($conn,$name);
	if ( $res === false)
	{
        	header("HTTP/1.0 500 Errore");
        	die();
	}
	return $res;
}

?>
