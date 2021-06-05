# Rsc

## About

This project represents a platform that can be used by the companies to offer customer support to their clients. The goal of the project is to understand better the concepts behind front-end and back-end side of web programming and it's not for commercial use.

## Dependencies
*	[php_pgsql](https://www.php.net/manual/ro/pgsql.installation.php)
*	[Ratchet - PHP WebSockets](http://socketo.me/) ( for the chat's wss server)
*	[illuminate/database](https://github.com/illuminate/database) ( for communicating with the database)
*	[PHPMailer](https://github.com/PHPMailer/PHPMailer) ( for sending confirmation links and information )

*Note*: The dependencies need to be installed using [Composer](https://getcomposer.org/).

## Requirements
*	[Apache web server](https://httpd.apache.org/)
*	[PHP 7.4](https://www.php.net/downloads.php)
*	[PostgreSQL database](https://www.postgresql.org/)

## Building

For the project to run correctly you need to do the following steps:
1. Set the `DocumentRoot` of the apache server to the root of the repository

2. Configure your apache server to run over ssl ([see here](https://www.digicert.com/kb/csr-ssl-installation/ubuntu-server-with-apache2-openssl.htm)).

3. Go to the project root and use the `composer update` command to install
all of the dependencies and `composer dump-autoload` to generate the
autoload file.

4. Enable the `php_pgsql` extension in case you didn't already do it.

5. Enable the `mod_proxy`, `mod_proxy_http`and `mod_proxy_wstunnel`
	extensions ([see here]((https://stackoverflow.com/questions/27526281/websockets-and-apache-proxy-how-to-configure-mod-proxy-wstunnel))).

6. Write the following lines in your apache configuration file, right after the `DocumentRoot` field :
	```
	ProxyPass /wss ws://localhost:8081/
	ProxyPassReverse /wss ws://localhost:8081/
	```

7. Create a Postgresql database named `Resc` and import the
schema from the `resc_db.sql` file from the root of the project.

8. Change the database credentials from `application/app/Database.php` and `application/app/Mail.php` with your own credentials.

## Running

If you builded the application correctly, you should start the apache server and try to access `https://localhost/` and the website should load. The default credentials for the `login` section are :
```
username: admin
password: 1234
```
You can try out the chat by opening 2 tabs. In one tab you should connect with the previous credentials and go to the `chat` section, and in the second tab you should click the `try a demo` button. In the logged tab, you can click `get a client` and you can start a conversation with yourself.

If you want to use the application like an endpoint, you can call the `api` functions and connect to the `wss` server with a separate app and connect it to your own `CRM` ( you can find more details, along with the documentation in the `documentation.html` file from the root of the project or click [here](https://catalyn45.github.io/ReSC/documentation).

## Contributors
* Ancutei Catalin-Iulian
    * [linkedin](https://www.linkedin.com/in/c%C4%83t%C4%83lin-iulian-ancu%C8%9Bei-189096193/)
    * [facebook](https://www.facebook.com/catalin.iulian.758)
    * [personal page](http://students.info.uaic.ro/~catalin.ancutei)
    * email: `ancutei.catalin@gmail.com`
*	Condurache Andreea-Emanuela
    * [facebook](https://www.facebook.com/andreea3ema7)