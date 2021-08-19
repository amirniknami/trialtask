## Trial Task

### requirements
* PHP 7.3+
* MySql 8+
* composer 2+

### getting started

#### Steps
* Run the following command inside project directory
 ```
     composer install
```
* Next you should create the .env file . if you are in windows
  tou should make a dotenv file in the project root
  and copy the content of .env.example file to the
  created .env file but if you are in unix systems like mac
  or linux you could run the following command
```
cp .env.example .env
```
* next you have to configure the .env file so the project
could interact with database. First you should create a 
database in your mysql server then fill the following
variables in the .env file
```
DB_HOST=localhost or your mysql host ip
DB_PORT=3306 or your mysql default port
DB_DATABASE=databasename
DB_USERNAME=username
DB_PASSWORD=password
```
* next : As we are using the database queue driver for
the test purposes you should configure the following
variable and fill it with database
```
QUEUE_CONNECTION=database
```
* Next run this command
```
php artisan key:generate
```

* Next Run the following command
 ```
     php artisan migrate
```
* As This project Deepened on queued jobs for importing
  shifts you should run this command on the supervisor
   or just run it in separate terminal for test purposes
 <br >
 <span style="color:red">*Remember That this commadn should be running on background otherwise the import api does not work </span>
 ```
 php artisan queue:work
```
* if you have the <span style="color:red">php SQLite extension enabled</span> you can
run the following command to see if everything configured
correctly
```
php artisan test
```

