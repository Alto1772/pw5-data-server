<?php

//Login Endpoint For pw5
/* params:
   name
   password
   getIP

   returns (|):
   "Login Done"
   name
   kills
   deaths
   gameplays
   unknown ?= 0
   playerID
   unknown ?

   if not exists:
   "User <color=#FF4E50>" name " </color>does not exist \n"

   if unset:
   "no data found"
*/

define("NotAllowedChars",["|"]); //altered
foreach(["name","password"] as $a) empty($_POST[$a])&&die("$a parameter is empty!");
extract($_POST,EXTR_SKIP);
foreach(NotAllowedChars as $a)($pos=strpos($name,$a))!==false&&die("Invalid <b>$a</b> at column <color=yellow>$pos</color>!");
//begin altered code
die("Login Done|$name|0|0|0|0|1||");
//end altered code
$database=scandir("Database");
array_shift($database); array_shift($database); sort($database);
foreach($database as $i){
  $data=json_decode(file_get_contents("Database/$i"),true);
  if(json_last_error()) continue;
  if($data["name"]==$name){
    if($data["password"]==$password) { 
      $exists=true;
      extract($data);
      break;
    }
    else die("Invalid password for user <color=#FF4E50>$name</color> \n");
  }
}

if($exists) print("Login Done|$name|$kills|$deaths|$gameplays|0|$i||");
else print("User <color=#FF4E50>$name </color>does not exist \n");
