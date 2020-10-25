# mymobiletracker

It is an app to track the following features from a user
 * App installs
 * App events
 * Automated push notifications
 * Custom or 3rd party login
 
This app supports both IOS and Android system. The app also supports multiple apps to track user's activities on the apps. 
 
### App Installs
When the app is called, the basic data the app collects are the following 
 * Ip Addresses
 * Country
 * Visit time
 * Device characteristics 

With the data collected from user, our backend generates unique User Id and store the User Id on users' mobile to use it with any subsequent services.
The app also offers login systems. When user logins to our login system, his mobile sends following infos:
 * User Id
 * Login Type
 * Oauth Token
 * Oauth User Id Token
 * Password

### App Events Tracking
The app records any activities that we want to track from users when they use our app. The app also make custom reports of user events.
The app uses the following parameters to records:
 * User Id
 * Time/Date of the event
 * Event Value
Using the app event service, we are able to track users' behavior toward some of the features of the app (like what they do with our push notifications)

### Automated Push Notification
 Using One Signal API, the app's backend send push notifactions after creating a specific query to users upon specific events they make.

# ER Model

![ER](https://raw.githubusercontent.com/avrevic/mymobiletracker/527304841cda013a99409378555b9cedd2ae149f/er-diagram.png)

# Server setup

This guide is created on Ubuntu 16 machine. It should work correctly for all Debian linux operating systems.

Server setup will only show basic commands required to install Docker CE and setup initial PostgreSQL database.

Full Docker CE install guide can be found on: https://docs.docker.com/engine/install/ubuntu/

## Docker CE installation commands

```bash
sudo apt-get update

sudo apt-get install \
    apt-transport-https \
    ca-certificates \
    curl \
    gnupg-agent \
    software-properties-common

curl -fsSL https://download.docker.com/linux/ubuntu/gpg | sudo apt-key add -

sudo add-apt-repository \
   "deb [arch=amd64] https://download.docker.com/linux/ubuntu \
   $(lsb_release -cs) \
   stable"

sudo apt-get update
sudo apt-get install docker-ce docker-ce-cli containerd.io

sudo docker run hello-world
```

## Connect to DB

To connect to db, we need to install postgres client:

```bash
apt install postgresql-client-common
sudo apt-get install postgresql-client
```

## PostgreSQL db setup commands

Pull the docker postgres image, run it then connect to the postgres server to create our users.

```bash
docker pull postgres
docker run -d --name postgres-instance -e POSTGRES_PASSWORD=mypwd -p 543:5432 postgres
psql -h 127.0.0.1 -p 543 -U postgres
create database clicktracker;
create user username with password 'pwd';
grant all privileges on database clicktracker to username;
\q
```

After that we need to set up a crontab script to reboot postgres container if the server reboots.

To open crontab use:

```bash
crontab -e
```

Then add the following line:

```bash
@reboot docker postgres-instance
```

## How to connect to DB

```bash
psql "postgresql://username:pwd@<ip>/clicktracker" -p 543
```

## Database backups every 2 hours

Create directory on the desired location on the server

```bash
mkdir ~/backups
```

Open cronjob configuration

```bash
crontab -e
```

Add the following line at the end of a file

```bash
0 */2 * * * docker exec -t postgres-instance pg_dumpall -c -U postgres > ~/backups/dump_`date +%d-%m-%Y"_"%H_%M_%S`.sql
```