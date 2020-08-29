<?php

//User Map List endpoint for pw5
/* params:
   uname
   password

   returns (~):
   [maps from UserMaps/(uname)]

   if not:
   empty string
*/
define("NotAllowedChars",["/","|"]); //altered
function die1($str){
  error_log(__FILE__.": $str");
  exit();
}

foreach(["uname","password"] as $a) if(empty($_POST[$a])) die1("$a parameter is empty!");
extract($_POST,EXTR_SKIP);
foreach(NotAllowedChars as $a){
  $pos=strpos($uname,$a);
  if($pos!==false) die1("Invalid character \"$a\" at column $pos of param \"uname\"!");
}
//begin altered code
foreach(array_diff(scandir("WorkMaps"),array('.','..')) as $i) $str.="~$i";
die($str);
//end altered code
$database=scandir("Database");
array_shift($database); array_shift($database); sort($database);
foreach($database as $i){
  $data=json_decode(file_get_contents("Database/$i"),true);
  if(json_last_error()) continue;
  if($data["name"]==$uname){
    if($data["password"]==$password) {
      $exists=true;
      break;
    }
    else die1("Invalid password for user $uname!");
  }
}

$exists or die1("User $uname does not exist!");
file_exists("UserMaps/$uname") or die1("$uname's folder does not exist!");
foreach(array_diff(scandir("UserMaps/$uname"),array('.','..')) as $i) $str.="~$i";
echo $str;
