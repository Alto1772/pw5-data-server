<?php

//Upload Map Endpoint for pw5
/* params:
   pname
   password
   mname
   fname
   fdata

   only response:
   "Ok"
*/

echo "Ok";

function die1($str){
  error_log(__FILE__.": $str");
  exit();
}
function warning($str){
  error_log(__FILE__.": $str");
}

foreach(["pname","password","mname","fname","fdata"] as $a) if(empty($_POST[$a])) die1("$a parameter is empty!");
extract($_POST,EXTR_SKIP);
$uname=&$pname;

$pos=strpos($mname,"/");
$pos===false or die1("Illegal character \"/\" at column $pos for param \"mname\"!");
//begin altered code
file_exists("WorkMaps/$mname") or mkdir("WorkMaps/$mname");
file_put_contents("WorkMaps/$mname/$fname",$fdata);
exit();
//end altered code
foreach(array("|","/") as $a){
  $pos=strpos($uname,$a);
  if($pos!==false) die1("Illegal character \"$a\" at column $pos for param \"uname\"!");
}
$exists=false;
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

$dir="UserMaps/$uname/$mname";
$exists or die1("User $uname does not exist!");
file_exists($dir) or mkdir($dir);
file_put_contents("$dir/$fname",$fdata);
