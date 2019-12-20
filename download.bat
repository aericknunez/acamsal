@echo off
cd\
cd C:\AppServ\www\acamsal
git reset --hard
git pull https://github.com/aericknunez/acamsal.git

cd\
cd C:\AppServ\www\acamsal\sync
call C:\AppServ\www\acamsal\sync\sync_json.bat
exit