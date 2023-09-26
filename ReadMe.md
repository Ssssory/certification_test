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
- update DATABASE_URL with your data.
- start project
```make up```
- Install packajes
```make install```
- Start migrations
```make migrate```

### Commands

Execute command in container:
``` make bash ```
or by root:
``` make bash-root ```


### App
/ - main page
/results - all results
For start new test, go to main page and enter you name.