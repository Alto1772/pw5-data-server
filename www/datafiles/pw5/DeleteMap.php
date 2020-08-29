<?php

//Remove Map Endpoint for pw5
/* params:
   uname
   password
   mapname

   only response:
   "ok"
*/

echo "ok";
define("NotAllowedChars",["|"]); //altered
function die1($str){
  error_log(__FILE__.": $str");
  exit();
}
function recurseRmdir($dir) {
  $files = array_diff(scandir($dir), array('.','..'));
  foreach ($files as $file) {
    (is_dir("$dir/$file")) ? recurseRmdir("$dir/$file") : unlink("$dir/$file");
  }
  return rmdir($dir);
}
foreach(["uname","password",] as $a) if(empty($_POST[$a])) die1("$a parameter is empty!");
extract($_POST,EXTR_SKIP);
$mname=&$mapname;

$pos=strpos($mname,"/");
$pos===false or die1("Illegal character \"/\" at column $pos for param \"mname\"!");
foreach(NotAllowedChars as $a){
  $pos=strpos($uname,$a);
  if($pos!==false) die1("Illegal character \"$a\" at column $pos for param \"uname\"!");
}
//begin altered code
recurseRmdir("WorkMaps/$mapname");
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
$dir="UserMaps/$uname/$mname";
recurseRmdir($dir);
