ci-test-task
============

Codeigniter test task repository


Installation
----------------------------------

* clone the repo

		git clone https://github.com/y-zaitcev/ci-test-task.git %YOUR EMPTY PATH%
		
* copy `application/config/config.php.sample` to `application/config/config.php` and replace the placeholders:

                %BASE_URL%

* copy `application/config/database.php.sample` to `application/config/database.php` and replace the placeholders:

                %HOSTNAME%
                %USERNAME%
                %PASSWORD%
                %DATABASE%

* create database & import application/config/_database_.sql

* run your application:
                
                registration page: %BASE_URL%/index.php/auth/registration
                login page: %BASE_URL%/index.php/auth/login