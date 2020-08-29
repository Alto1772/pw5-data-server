<?php

//Register endpoint for pw5
/* params:
   name
   password
   kills
   deaths
   gameplays
   uIP
   hash

   returns:
   "Done"

   if not:
   "A user with this name already exists,\n please choose another one!"
*/
//begin altered code; does nothing
die("Not Implemented!");
//end altered code

define("PlayerCount",10);
define("NotAllowedChars",["|","/"]);

foreach(["name","password","hash"] as $a) empty($_POST[$a])&&die("$a parameter is empty!");
extract($_POST,EXTR_SKIP);
foreach(NotAllowedChars as $a)($pos=strpos($name,$a))!==false&&die("Invalid character \"$a\" at column $pos of param \"name\"!");

$database=scandir("Database");
array_shift($database); array_shift($database); sort($database);
foreach($database as $i){
  $data=json_decode(file_get_contents("Database/$i"),true);
  if(json_last_error()) continue;
  $data["name"]==$name&&die("A user with this name already exists,\n please choose another one!");
}

$newfile=count($database)+PlayerCount; $incr=1;
while(file_exists("Database/$newfile")) $newfile=count($database)+PlayerCount+($incr++);
file_put_contents("Database/$newfile",
  json_encode(Array(
    "name" => $name,
    "password" => $password,
    "kills" => (int) $kills,
    "deaths" => (int) $deaths,
    "gameplays" => (int) $gameplays,
    "hash" => $hash
  ))
);
mkdir("UserMaps/$name");
echo "Done";
