<?php

//Template/New Maps Get Endpoint for pw5
/* only get maps in GameMaps/new_map directory */

foreach(array_diff(scandir('GameMaps/new_map'),array('.','..')) as $i) $str.="~$i";
echo $str;
