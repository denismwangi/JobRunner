# Background Job Runner for Laravel

This repository provides a system to run background jobs asynchronously in a Laravel environment. It allows you to execute methods of any class with given parameters, log execution details, and handle errors effectively.

## Features
- **Run jobs asynchronously**: Execute any class method in the background with parameters passed dynamically.
- **Logging**: Log job execution details, including success and failure messages, into `background_jobs_errors.log`.
- **Error Handling**: Capture and log detailed error messages if there are missing parameters, incorrect method names, or execution failures.
- **Reflection-based Invocation**: Dynamically call methods on classes with parameters passed at runtime.

## Table of Contents
- [Installation](#installation)
- [Usage](#usage)
  - [Run a Job](#run-a-job)
  - [Configuration](#configuration) 
- [Logging](#logging)
  - [Log Format](#log-format)
  - [Custom Log File](#custom-log-file)
- [Testing](#testing)
  - [Test Cases](#test-cases)
  - [Sample Logs](#sample-logs)
- [Optional Features](#optional-features)
- [Assumptions and Limitations](#assumptions-and-limitations)
- [Contributing](#contributing)
- [License](#license)

## Installation

### Step 1: Clone the Repository

Clone the repository

```bash
git clone https://github.com/denismwangi/JobRunner.git
```

### Step 2: Install Dependencies

composer install

### Step 3: Testing the script
**Testing Using Terminal for Linux Operating System**

-Testing TestJob class and execute function with parameters 10 and 1
```bash 
/usr/bin/php8.1 /opt/lampp/htdocs/jobrunner/background_job_runner.php 'App\Jobs\TestJob' execute '[10,1]' 
```

