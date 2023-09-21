# Test like sertificate test

### First start
- Copy .env by command
``` cp .env.example .env ```

Update .env if need.
- USER_PHP - you can update to you current user. 
- UID defined for debian sistem. To check you UID, write in console:
``` echo $UID```

- Create .env for framework from example by equals command:
``` cp src/.env.example src/.env ```
- start project
```make up```
- Install packajes
```make install```
- Start migrations
```make migrate```
- Fill db by seeds
```make seed```

Execute command in container:
``` make bash ```
or by root:
``` make bash-root ```