<?php

//Rename Map Endpoint for pw5
/* params:
   uname
   password
   mapname
   mapname2

   only response:
   "ok"
*/

echo "ok";
function die1($str){
  error_log(__FILE__.": $str");
  exit();
}
define("NotAllowedChars",["|","/"]); //altered
foreach(["uname","password"] as $a) if(empty($_POST[$a])) die1("$a parameter is empty!");
extract($_POST,EXTR_SKIP);

foreach(array("mapname","mapname2") as $a){
  $pos=strpos($$a,"/");
  if($pos!==false) die1("Invalid character \"/\" at column $pos of param \"$a\"!");
}
foreach(NotAllowedChars as $a){
  $pos=strpos($uname,$a);
  if($pos!==false) die1("Invalid character \"$a\" at column $pos of param \"uname\"!");
}
//begin altered code
rename("WorkMaps/$mapname","WorkMaps/$mapname2");
exit();
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
file_exists("UserMaps/$uname/$mapname") or die1("Map \"$mapname\" does not exist!");
rename("UserMaps/$uname/$mapname","UserMaps/$uname/$mapname2");
