@REM start firefox --kiosk --user-data-dir=%TEMP%/monitor1 --window-position=0,1920 -new-tab localhost/antrian_puskesmas_v1/show-all-queue/1

@REM start chrome.exe --kiosk "http://localhost/antrian_puskesmas_v1/show-all-queue/1" --autoplay-policy=no-user-gesture-required

@echo off
set FIREFOX_PATH="C:\Program Files\Mozilla Firefox\firefox.exe"
set URL=http://localhost/antrian_puskesmas_v1/show-all-queue/1

%FIREFOX_PATH% --kiosk %URL%
