<?php
foreach(["section","uname","mname","fname"] as $a) if(empty($_GET[$a])) http_response_code(404);
extract($_GET,EXTR_SKIP);
$mname=urldecode($mname);

if($section=="UserMaps"){
	$file="WorkMaps/$mname/$fname";
	if(!file_exists($file)){
		http_response_code(404);
		exit();
	}
	echo file_get_contents($file);
}
else{
	if(substr($mname,0,-50)){
		$type=substr($mname,-14,-13)-1;
		$mname=substr($mname,0,-50);
	}else $type=-1;
	$found=false;
	foreach($y=array_diff(scandir("GameMaps/$uname"),array('.','..')) as $i){
	if(($file=json_decode(file_get_contents("GameMaps/$uname/$i"),true))['m']==$mname){
		$found=true;
		break;
	}}
	if($found && $type == $file['t']){
		if($fname=="Objects")
			echo gzdecode(base64_decode($file["o"]));
		elseif($fname=="RegionsList")
			echo '/'.join('/',array_keys($file["r"]));
		elseif(preg_match('/((0|-1|-2|1),){3}\.region/',$fname))
			echo gzdecode(base64_decode($file["r"][substr($fname,0,-8)]));
		else{
			http_response_code(404);
			exit();
		}
	}else{
		http_response_code(404);
		exit();
	}
}