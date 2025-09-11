start msedge "http://localhost/antrian_puskesmas/play_suara/choosed_lantai/2" --kiosk --user-data-dir=%TEMP%/monitor1 --autoplay-policy=no-user-gesture-required

@REM start firefox --kiosk --user-data-dir=%TEMP%/monitor1 --window-position=0,1920 -new-tab localhost/antrian_puskesmas
@REM start firefox --kiosk --user-data-dir=%TEMP%/monitor0 --window-position=1920,0 -new-tab localhost/antrian_puskesmas/play_suara/choosed_lantai/1
