# About

I was assigned to create a RESTful API involving a fictional characters game without using any library, framework or copy-paste and this is the result of a week-end work.
Altough it's not perfect I want to keep it like this to see my coding skills at that moment. For more info about the API requests and responses check the controllers.

# Installation instructions

* Create a virtual host

```
<VirtualHost *:80>
	DocumentRoot "/var/www/monsters"
	ServerName monsters.dev

	<Directory "/var/www/monsters">
		Options Indexes MultiViews FollowSymLinks
		AllowOverride All
		Order allow,deny
		Allow from all
	</Directory>
</VirtualHost> 
```

* Run composer install
* Edit `Andrei\App\Config` class with db credentials
* Run the tests and check code coverage: ./vendor/bin/phpunit --coverage-html ./report



