## XSnapCourier 

XSnapCourier is a Laravel based snapshot scheduling application built for the EMC XtremIO all flash array. On top of doing basic snapshots, the application will also gather and report statistics on the cluster as a whole and any volumes you may add. The application is self-learning, and once you have updated the config file and run the crons for the first time, you should be good to to begin scheduling

# Installation

Installation consists of a series of of steps that consite of the following:

1. Package installation and requirements
2. Apache Configuration
3. Database Setup
4. Custom Application Configuration
5. Artisan Migrations and Seeding
6. Cronjobs

## Package Installation and requirements

Since XSC is written on top of Laravel, we have to basically meet [Laravels Requierments](http://laravel.com/docs/5.0/installation). For reference this contains a few key items:
* PHP5
* Mcrypt (PHP)
* OpenSSL (PHP)
* Mbstring (PHP)
* Tokenizer (PHP)

In Ubuntu (My preferred distro) this can be accomplished with the following:

`sudo apt-get install php5 php4-mcrypt php5-mysql`

As a note, you may have to actually enable Mcrypt with `php5enmod mcrypt` followed by `service apache2 restart` 

And custom to our application

* Curl (Both system and php)
* LDAP (PHP)

`sudo apt-get install curl php5-curl php5-ldap` followed by `service apache2 restart`

## Apache Configuration 

A file sample config file (Default for SSL) is located in the root of this project. To deploy this on Ubuntu you can perform the below steps. Please be advised that this is for a system with no other virtual hosts on it, as well as no other SSL connections. Please be aware that you may need to adjust the configuration file along with other Apache configs to fit your environment. 

`sudo cp xsc.conf /etc/apache2/sites-available && sudo a2enmod xsc.conf && sudo service apache2 reload`

If all goes well, the configuration should be good and you should be able to hit it via browser with the IP address of the server. 

## Database Setup

You will need to create a database, username, and password in order for Laravel to communicate with the DB correctly. The application is configured to use database name **xsnapcourier**. Unless you want to change the configurations, create the database with the following command in mysql:

`create database xsnapcourier;`

Now we will create a username and password in mysql (Substituting your desired user and pass of course):

`grant all privileges on xsnapcourier.* to '[USERNAME]' identified by '[PASSWORD]';`

Now, in the application update the config/database.php file to include the hostname/IP of your DB server, database name, and user / pass from above. At this point, Laravel will be able to connect.

## Custom Application Configuration

In XSnapCourier there is a section of the config/app.php file we will need to update. These include the following:

**XSnapCredentials** = This is an array of the username / password used with the XtremIO API. This will be configured in XMS and what you would normally use to access the XtremIO application
**XtremIOIP** - The IP the XMS can be reached at. This is crucial for the API
**ActiveDirectory** - This is an array of configurations you will need to update in order for the AD connection to work:
1. **domain_controllers** - An array of IP addresses for domain controllers in your environment
2. **account_suffix** - Think of this as the @domain.com in your email address. If your domain is example.come, this will be @example.com
3. **base_dn** - The base location in AD from which we will begin looking. If your domain was example.com, it would be DC=example,DC=com
4. **ad_port** - 389 for cleartext, 636 for AD with Certificate services and SSL (more secure. Get with your windows admins to see if it is available)
5. **use_ssl** - 0 if using cleartext, 1 if using SSL
6. **use_tls** - 0 in most cases. 
7. **sso** - 0 in most cases

## Artisan Migrations and Seeding

At this point the app, DB, and apache configs are all done, so we will allow the application to create the database and populate some base data. To do this, navigate to the directory where you cloned the application (or unzipped it) and issue the following

`php artisan migrate`

It will ask you if you want to do it since you are in production. Hit yes. You will see output indicating the migrations have completed. The DB structure and procedures are all in place. Now we will issue:

`php artisan db:seed`

You may get asked here as well, just select yes. It should indicate the seed has completed. At this point, the DB is up, structured, and has the base data we need. 

## Cronjobs
There are two cronjobs the system will need to schedule snapshot and stats evaluations. Edit the crontab file with 

`sudo vim /etc/crontab`

and add the following two lines to the end:

```
1  *    * * *   root    curl -k "https://localhost/process/snaps" > /dev/null
1  *    * * *   root    curl -k "https://localhost/process/stats" > /dev/null
```

These assume you are running https and that the crons are located on the webserver running XSnapCourier. If this is not the case, you will need to update the crons accordingly. The first time that /process/stats is called, it will pull dthe cluster, bricks, and volumes and sync them up to the DB. From there you can log in to the application and specify which volumes are snapshottable. Once a volume is designated as such, whenever /process/snaps is called, it will determine whether or not a snapshot is required based on the Data Type and make / purge snapshots accordingly. 

## Contributing

This is the first open-source application I have run in a while, but feel free to make pull requests. I am currently working with EMC and some other partners to try to get a test system or an XMS emulator. It will be necessary to test the core classes against new version of firmware code that may affect the XtremIO API. 

### License

The XSnapCourier is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)
