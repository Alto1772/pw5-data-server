<?php

//Update User Data Endpoint for pw5
/* params:
   uname
   password
   kills
   deaths
   gameplays

   only response:
   "Updated"
*/

echo "Updated";
function die1($str){
  error_log(__FILE__.": $str");
  exit();
}

//foreach(["uname","password","kills","deaths","gameplays"] as $a) empty($_POST[$a])&&die1("$a parameter is empty!");
extract($_POST,EXTR_SKIP); $name=$uname;
foreach(array("|","/") as $a){
  $pos=strpos($uname,$a);
  if($pos!==false) die1("Invalid character \"$a\" at column $pos of param \"uname\"!");
}

$database=scandir("Database");
array_shift($database); array_shift($database); sort($database);
foreach($database as $i){
  $data=json_decode(file_get_contents("Database/$i"),true);
  if(json_last_error()) continue;
  if($data["name"]==$name){
    if($data["password"]==$password) {
      $exists=true;
      break;
    }
    else die1("Invalid password for user $name!");
  }
}

$exists or die1("User $name does not exist!");
$data["kills"]=$kills; $data["deaths"]=$deaths; $data["gameplays"]=$gameplays;
file_put_contents("Database/$i",json_encode($data));
