munin-maniaplanet
=================

Plugin for munin that will show the number of players on each server &amp; the total


##Installation 
Copy the files in ```/etc/munin ```

Edit the file ```/etc/munin/mp-players.php``` 

You need to configure your servers 

```$settings['name'][0] = 'server - 1';``` : The name of the server as you would like to see it in munin$
```
 $settings['ip'][0] = '127.0.0.1';
 $settings['port'][0] = '5005';
 $settings['login'][0] = 'Admin';
 $settings['pwd'][0] = 'Admin';
```

The rest you should know. :smile

Restart munin node and you should be Ok 

