# laravel-meteoapi

API for meteocat

## curl_setopt

### platges

* /platges
* /platges/geosearch/{longitude}/{latitude}
* /platges/geosearch/{longitude}/{latitude}/{limit}

### municipis

* /municipis
* /municipis/geosearch/{longitude}/{latitude}
* /municipis/geosearch/{longitude}/{latitude}/{limit}
* /municipis/{municipi_slug}
* /municipis/{municipi_slug}/previsio
* /municipis/{municipi_slug}/platges
* /municipis/{municipi_slug}/platges/{platja_slug}
* /municipis/{municipi_slug}/platges/{platja_slug}/previsio

### comarques

* /comarques
* /comarques/{comarca_slug}

### estat

* /estat

## commands

### meteoapi:initdb
init db

### meteoapi:getmunicipis
obté/actualitza els municipis

### meteoapi:getplatges
get platges

### meteoapi:getprevisiomunicipi
obte previsio municipal

### meteoapi:getprevisioplatja
get Previso Platja

### meteoapi:showcomarques
llistat de comarques

### meteoapi:showmunicipis
llistat de municipis

### meteoapi:showplatges
llistat de platges

### meteoapi:updateprevisions
Actualitza previsions existents

S'actualitza diariament dues vegades si es configura el següent cron:

```
* * * * * php /home/jprats/git/laravel-meteoapi/meteoapi/artisan schedule:run 1>> /dev/null 2>&1
```


## systemd - queue worker

```
root@shuvak:/etc/systemd/system# systemctl start laravelqueue@meteoapi
root@shuvak:/etc/systemd/system# systemctl status laravelqueue@meteoapi
● laravelqueue@meteoapi.service - Laravel queue worker meteoapi
   Loaded: loaded (/etc/systemd/system/laravelqueue@.service; disabled; vendor preset: enabled)
   Active: active (running) since Sun 2018-06-24 20:08:03 CEST; 1s ago
 Main PID: 11136 (php)
   CGroup: /system.slice/system-laravelqueue.slice/laravelqueue@meteoapi.service
           └─11136 /usr/bin/php /home/jprats/git/laravel-meteoapi/meteoapi/artisan queue:work --daemon --env=production

Jun 24 20:08:03 shuvak systemd[1]: Started Laravel queue worker meteoapi.
root@shuvak:/etc/systemd/system# systemctl enable laravelqueue@meteoapi
Created symlink from /etc/systemd/system/multi-user.target.wants/laravelqueue@meteoapi.service to /etc/systemd/system/laravelqueue@.service.
root@shuvak:/etc/systemd/system# cat laravelqueue@.service
[Unit]
Description=Laravel queue worker %i

[Service]
User=www-data
Group=www-data
Restart=always
ExecStart=/usr/bin/php /home/jprats/git/laravel-%i/%i/artisan queue:work --daemon --env=production

[Install]
WantedBy=multi-user.target
root@shuvak:/etc/systemd/system#
```
