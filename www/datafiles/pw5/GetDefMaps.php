<?php

//Default Map Get Endpoint for pw5
/* only get maps in GameMaps/default directory */
function randmap($n,$t) {
    $char = "0123456789";
    $char = str_shuffle($char);
    for($i = 0, $rand = '', $l = strlen($char) - 1; $i < 20; $i ++) $rand .= $char{mt_rand(0, $l)};
    return "${n}-${rand}[------------00${t}------------]";
}
$str='';
foreach(array_diff(scandir('GameMaps/default'),array('.','..')) as $i){
	$map=json_decode(file_get_contents("GameMaps/default/$i"));
	$map->t==-1||$str.="~".randmap($map->m,$map->t+1);
}
echo $str;