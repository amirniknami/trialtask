# Trial Task

## Requirements
* PHP 7.3+
* MySQL 8+
* composer 2+

## Getting started

### Steps
* Run the following command inside the project directory
 ```bash
     composer install
```
* Next, you should create the `.env` file. If you are on Windows you should make a `.env` file in the project root and copy the content of `.env.example` file to the
  created .env file but if you are in UNIX systems like MacOS or Linux you could run the following command
```bash
cp .env.example .env
```
* Next, you have to configure the `.env` file so the project could interact with the database. First, you should create a database in your MySQL server then fill the following variables in the `.env` file
```
DB_HOST=localhost or your mysql host ip
DB_PORT=3306 or your mysql default port
DB_DATABASE=databasename
DB_USERNAME=username
DB_PASSWORD=password
```
* Next, as we are using the database queue driver, for test purposes you should initialize the following
variable with `database`
```bash
QUEUE_CONNECTION=database
```
* Next, run this command
```bash
php artisan key:generate
```

* Next, run the following command
 ```bash
php artisan migrate
```
* As this project depends on queued jobs for importing shifts, you should run this command on the Supervisor or just run it in a separate terminal for test purposes.

* Remember that this command should be running in the background otherwise, the import API does not work. 
 ```bash
 php artisan queue:work
```
* If you have the PHP SQLite extension enabled you can
run the following command to see if everything configured
correctly

```bash
php artisan test
```
* You can run a test built-in web server for testing purpose with the following command which is going to start your web server on the following address
> http://localhost:8000

```bash
php artisan serve
```
## API reference

### POST /api/shifts
* parameters:
   + shifts: required if there is no json file,array
   + file: JSON file containing an array of shifts in the shifts offset
  
Least,  one of the above requirements is mandatory

* response:
  + response status: 202
```json
true
```
### GET /api/shifts
* parameters:
    + location: required, exists:locations
    + start:  required, format:iso 8604 datetime
    + end:  required, format:iso 8604 datetime
    
* response:
    + response status: 200
```json
{
    "data": [
        {
            "type": "shift",
            "start": "2018-10-22T09:10:00+00:00",
            "end": "2018-10-22T17:10:00+00:00",
            "user_name": null,
            "user_email": "dummy+3216@dummy.com",
            "location": "Ampleforth Abbey",
            "event": null,
            "rate": 12,
            "charge": 22,
            "area": null,
            "departments": [
                "Empty Department",
                "New department 1",
                "New department 2",
                "Cambridge Department",
                "New department 3"
            ]
        }
    ],
    "links": {
        "first": "http:\/\/localhost\/api\/shifts?page=1",
        "last": "http:\/\/localhost\/api\/shifts?page=1",
        "prev": null,
        "next": null
    },
    "meta": {
        "current_page": 1,
        "from": 1,
        "last_page": 1,
        "links": [
            {
                "url": null,
                "label": "&laquo; Previous",
                "active": false
            },
            {
                "url": "http:\/\/localhost\/api\/shifts?page=1",
                "label": "1",
                "active": true
            },
            {
                "url": null,
                "label": "Next &raquo;",
                "active": false
            }
        ],
        "path": "http:\/\/localhost\/api\/shifts",
        "per_page": 15,
        "to": 1,
        "total": 1
    }
}
```

### DELETE /api/empty-app-data
* parameters
   + No parameters

* response:
  + response status: 200
```json
true
```
