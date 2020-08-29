# pw5-data-server

an experimental implemented server that i use for my local map storage instead of their official server

uses [lighttpd](https://lighttpd.net) and [php](https://php.net)

## Paths

`www/games/pixel-warfare-5/Build/` - base game *(download it from their server and put it here)*

`www/datafiles/pw5/` - base game server files

`www/datafiles/pw5/GameMaps/` - default preinstalled maps for guest rooms

`www/datafiles/pw5/UserMaps/` - user maps for login

`www/datafiles/pw5/Database/` - user login info database without sql *(not included in their server)*

`server.conf` - lighttpd configuration

`server.pem` - ssl certificate