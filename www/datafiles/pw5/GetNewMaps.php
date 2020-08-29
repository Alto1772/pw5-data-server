<?php

//Template/New Maps Get Endpoint for pw5
/* only get maps in GameMaps/new_map directory */
$str='';
foreach(array_diff(scandir('GameMaps/new_map'),array('.','..')) as $i)
	$str.="~".json_decode(file_get_contents("GameMaps/new_map/$i"))->m;
echo $str;