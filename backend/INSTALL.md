##### Download the Code an extract or Clone the repository

- After Successful installation of the Application.
```bash
    $ php artisan queue:listen
```
- The above code will execute the code and keep listening the job queue.
```bash
    $ crontab -e
    $ * * * * * php /path-to-your-project/artisan schedule:run >> /dev/null 2>&1
```
- The above code will execute the cron job every minute.
- Now, run scheduler locally by running the following command.
```bash
    $ php artisan schedule:work
```
- The above code will execute the scheduler and will run the job queue.

[]: # Path: INSTALL.md
