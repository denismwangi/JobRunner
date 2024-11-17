# Background Job Runner for Laravel

This repository provides a system to run background jobs asynchronously in a Laravel environment. It allows you to execute methods of any class with given parameters, log execution details, and handle errors effectively.

## Features
- **Run jobs asynchronously**: Execute any class method in the background with parameters passed dynamically.
- **Logging**: Log job execution details, including success and failure messages, into `background_jobs_errors.log`.
- **Error Handling**: Capture and log detailed error messages if there are missing parameters, incorrect method names, or execution failures.
- **Reflection-based Invocation**: Dynamically call methods on classes with parameters passed at runtime.


## Installation

### Clone the Repository

Clone the repository
```bash
git clone https://github.com/denismwangi/JobRunner.git
```

##### .env
Copy contents of .env.example file to .env file. Create a database and connect your database in .env file.
**sample env**
```bash

APP_NAME=JobRunner
APP_ENV=local
APP_KEY=base64:vTeETn02lFotAla9a5Z/V95dQztiuglcFg4HIlY0GrQ=
APP_DEBUG=true
APP_URL=http://localhost

LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=debug

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=job_runner
DB_USERNAME=root
DB_PASSWORD=


```
##### Composer Install
cd into the project directory via terminal and run the following  command to install composer packages.

##### Generate Key
then run the following command to generate fresh key.

###### `php artisan key:generate`

##### Run Migration
then run the following command to create migrations in the database.

###### `php artisan migrate`
then run the following command to run the project.
###### `php artisan serve`

### Testing the script

**Testing Using Terminal for Linux Operating System**

-Testing TestJob class and execute function with parameters 10 and 1
```bash 
/usr/bin/php8.1 /opt/lampp/htdocs/jobrunner/background_job_runner.php 'App\Jobs\TestJob' execute '[10,1]' 
```

