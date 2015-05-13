## XSnapCourier 

XSnapCourier is a Laravel based snapshot scheduling application built for the EMC XtremIO all flash array. On top of doing basic snapshots, the application will also gather and report statistics on the cluster as a whole and any volumes you may add. The application is self-learning, and once you have updated the config file and run the crons for the first time, you should be good to begin scheduling

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

You can copy and paste the below code block into the /etc/apache2/sites-available/default-ssl.conf file. 

```
#
# When we also provide SSL we have to listen to the
# the HTTPS port in addition.
#
Listen 443 https

##
##  SSL Global Context
##
##  All SSL configuration in this context applies both to
##  the main server and all SSL-enabled virtual hosts.
##

#   Pass Phrase Dialog:
#   Configure the pass phrase gathering process.
#   The filtering dialog program (`builtin' is a internal
#   terminal dialog) has to provide the pass phrase on stdout.
SSLPassPhraseDialog exec:/usr/libexec/httpd-ssl-pass-dialog

#   Inter-Process Session Cache:
#   Configure the SSL Session Cache: First the mechanism
#   to use and second the expiring timeout (in seconds).
SSLSessionCache         shmcb:/run/httpd/sslcache(512000)
SSLSessionCacheTimeout  300

#   Pseudo Random Number Generator (PRNG):
#   Configure one or more sources to seed the PRNG of the
#   SSL library. The seed data should be of good random quality.
#   WARNING! On some platforms /dev/random blocks if not enough entropy
#   is available. This means you then cannot use the /dev/random device
#   because it would lead to very long connection times (as long as
#   it requires to make more entropy available). But usually those
#   platforms additionally provide a /dev/urandom device which doesn't
#   block. So, if available, use this one instead. Read the mod_ssl User
#   Manual for more details.
SSLRandomSeed startup file:/dev/urandom  256
SSLRandomSeed connect builtin
#SSLRandomSeed startup file:/dev/random  512
#SSLRandomSeed connect file:/dev/random  512
#SSLRandomSeed connect file:/dev/urandom 512

#
# Use "SSLCryptoDevice" to enable any supported hardware
# accelerators. Use "openssl engine -v" to list supported
# engine names.  NOTE: If you enable an accelerator and the
# server does not start, consult the error logs and ensure
# your accelerator is functioning properly.
#
SSLCryptoDevice builtin
#SSLCryptoDevice ubsec

##
## SSL Virtual Host Context
##

<VirtualHost _default_:443>

# General setup for the virtual host, inherited from global configuration
#DocumentRoot "/var/www/html"
#ServerName www.example.com:443

DocumentRoot    /directory/to/xsnapcourier

        <Directory /directory/to/xsnapcourier >
                Options Indexes FollowSymLinks MultiViews
                AllowOverride All
                Order allow,deny
                allow from all
        </Directory>

        ScriptAlias /cgi-bin/ /usr/lib/cgi-bin/
        <Directory "/usr/lib/cgi-bin">
                AllowOverride None
                Options +ExecCGI -MultiViews +SymLinksIfOwnerMatch
                Order allow,deny
                Allow from all
        </Directory>

        ErrorLog /var/log/httpd/xsc-error.log

        # Possible values include: debug, info, notice, warn, error, crit,
        # alert, emerg.
        LogLevel warn

        CustomLog /var/log/httpd/xsc-access.log combined
        ServerSignature On

# Use separate log files for the SSL virtual host; note that LogLevel
# is not inherited from httpd.conf.
LogLevel warn

#   SSL Engine Switch:
#   Enable/Disable SSL for this virtual host.
SSLEngine on

#   SSL Protocol support:
# List the enable protocol levels with which clients will be able to
# connect.  Disable SSLv2 access by default:
SSLProtocol all -SSLv2

#   SSL Cipher Suite:
#   List the ciphers that the client is permitted to negotiate.
#   See the mod_ssl documentation for a complete list.
SSLCipherSuite HIGH:MEDIUM:!aNULL:!MD5

#   Speed-optimized SSL Cipher configuration:
#   If speed is your main concern (on busy HTTPS servers e.g.),
#   you might want to force clients to specific, performance
#   optimized ciphers. In this case, prepend those ciphers
#   to the SSLCipherSuite list, and enable SSLHonorCipherOrder.
#   Caveat: by giving precedence to RC4-SHA and AES128-SHA
#   (as in the example below), most connections will no longer
#   have perfect forward secrecy - if the server's key is
#   compromised, captures of past or future traffic must be
#   considered compromised, too.
#SSLCipherSuite RC4-SHA:AES128-SHA:HIGH:MEDIUM:!aNULL:!MD5
#SSLHonorCipherOrder on

#   Server Certificate:
# Point SSLCertificateFile at a PEM encoded certificate.  If
# the certificate is encrypted, then you will be prompted for a
# pass phrase.  Note that a kill -HUP will prompt again.  A new
# certificate can be generated using the genkey(1) command.
SSLCertificateFile /etc/pki/tls/certs/localhost.crt

#   Server Private Key:
#   If the key is not combined with the certificate, use this
#   directive to point at the key file.  Keep in mind that if
#   you've both a RSA and a DSA private key you can configure
#   both in parallel (to also allow the use of DSA ciphers, etc.)
SSLCertificateKeyFile /etc/pki/tls/private/localhost.key

#   Server Certificate Chain:
#   Point SSLCertificateChainFile at a file containing the
#   concatenation of PEM encoded CA certificates which form the
#   certificate chain for the server certificate. Alternatively
#   the referenced file can be the same as SSLCertificateFile
#   when the CA certificates are directly appended to the server
#   certificate for convinience.
#SSLCertificateChainFile /etc/pki/tls/certs/server-chain.crt

#   Certificate Authority (CA):
#   Set the CA certificate verification path where to find CA
#   certificates for client authentication or alternatively one
#   huge file containing all of them (file must be PEM encoded)
#SSLCACertificateFile /etc/pki/tls/certs/ca-bundle.crt

#   Client Authentication (Type):
#   Client certificate verification type and depth.  Types are
#   none, optional, require and optional_no_ca.  Depth is a
#   number which specifies how deeply to verify the certificate
#   issuer chain before deciding the certificate is not valid.
#SSLVerifyClient require
#SSLVerifyDepth  10

#   Access Control:
#   With SSLRequire you can do per-directory access control based
#   on arbitrary complex boolean expressions containing server
#   variable checks and other lookup directives.  The syntax is a
#   mixture between C and Perl.  See the mod_ssl documentation
#   for more details.
#<Location />
#SSLRequire (    %{SSL_CIPHER} !~ m/^(EXP|NULL)/ \
#            and %{SSL_CLIENT_S_DN_O} eq "Snake Oil, Ltd." \
#            and %{SSL_CLIENT_S_DN_OU} in {"Staff", "CA", "Dev"} \
#            and %{TIME_WDAY} >= 1 and %{TIME_WDAY} <= 5 \
#            and %{TIME_HOUR} >= 8 and %{TIME_HOUR} <= 20       ) \
#           or %{REMOTE_ADDR} =~ m/^192\.76\.162\.[0-9]+$/
#</Location>

#   SSL Engine Options:
#   Set various options for the SSL engine.
#   o FakeBasicAuth:
#     Translate the client X.509 into a Basic Authorisation.  This means that
#     the standard Auth/DBMAuth methods can be used for access control.  The
#     user name is the `one line' version of the client's X.509 certificate.
#     Note that no password is obtained from the user. Every entry in the user
#     file needs this password: `xxj31ZMTZzkVA'.
#   o ExportCertData:
#     This exports two additional environment variables: SSL_CLIENT_CERT and
#     SSL_SERVER_CERT. These contain the PEM-encoded certificates of the
#     server (always existing) and the client (only existing when client
#     authentication is used). This can be used to import the certificates
#     into CGI scripts.
#   o StdEnvVars:
#     This exports the standard SSL/TLS related `SSL_*' environment variables.
#     Per default this exportation is switched off for performance reasons,
#     because the extraction step is an expensive operation and is usually
#     useless for serving static content. So one usually enables the
#     exportation for CGI and SSI requests only.
#   o StrictRequire:
#     This denies access when "SSLRequireSSL" or "SSLRequire" applied even
#     under a "Satisfy any" situation, i.e. when it applies access is denied
#     and no other module can change it.
#   o OptRenegotiate:
#     This enables optimized SSL connection renegotiation handling when SSL
#     directives are used in per-directory context.
#SSLOptions +FakeBasicAuth +ExportCertData +StrictRequire
<Files ~ "\.(cgi|shtml|phtml|php3?)$">
    SSLOptions +StdEnvVars
</Files>
<Directory "/var/www/cgi-bin">
    SSLOptions +StdEnvVars
</Directory>

#   SSL Protocol Adjustments:
#   The safe and default but still SSL/TLS standard compliant shutdown
#   approach is that mod_ssl sends the close notify alert but doesn't wait for
#   the close notify alert from client. When you need a different shutdown
#   approach you can use one of the following variables:
#   o ssl-unclean-shutdown:
#     This forces an unclean shutdown when the connection is closed, i.e. no
#     SSL close notify alert is send or allowed to received.  This violates
#     the SSL/TLS standard but is needed for some brain-dead browsers. Use
#     this when you receive I/O errors because of the standard approach where
#     mod_ssl sends the close notify alert.
#   o ssl-accurate-shutdown:
#     This forces an accurate shutdown when the connection is closed, i.e. a
#     SSL close notify alert is send and mod_ssl waits for the close notify
#     alert of the client. This is 100% SSL/TLS standard compliant, but in
#     practice often causes hanging connections with brain-dead browsers. Use
#     this only for browsers where you know that their SSL implementation
#     works correctly.
#   Notice: Most problems of broken clients are also related to the HTTP
#   keep-alive facility, so you usually additionally want to disable
#   keep-alive for those clients, too. Use variable "nokeepalive" for this.
#   Similarly, one has to force some clients to use HTTP/1.0 to workaround
#   their broken HTTP/1.1 implementation. Use variables "downgrade-1.0" and
#   "force-response-1.0" for this.
BrowserMatch "MSIE [2-5]" \
         nokeepalive ssl-unclean-shutdown \
         downgrade-1.0 force-response-1.0

#   Per-Server Logging:
#   The home of a custom SSL log file. Use this when you want a
#   compact non-error SSL logfile on a virtual host basis.
CustomLog logs/ssl_request_log \
          "%t %h %{SSL_PROTOCOL}x %{SSL_CIPHER}x \"%r\" %b"

</VirtualHost>
```

After doing this you will need to do three things:

1. Update the DocumentRoot directive
2. Update the Directory block
3. Restart Apache

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

### License for Visuals
This application was built with the [Metro Admin Theme](https://wrapbootstrap.com/theme/metro-admin-theme-metro-king-WB0GRG7H2), on an extended license purchased by the original author (Darrell Breeden). License number for original acquisition is 3db84235-f781-405e-82cb-0d49b020f601
