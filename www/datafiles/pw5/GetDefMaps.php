<?php

//Default Map Get Endpoint for pw5
/* only get maps in GameMaps/default directory */

foreach(array_diff(scandir('GameMaps/default'),array('.','..')) as $i) $str.="~$i";
echo $str;
