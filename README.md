Theme
===========
FlatLab - Bootstrap 4 Responsive Admin Template



Installation Changes
======================================
1. Use xampp-win32-1.8.3-5-VC11-installer.exe
2. Change db.php for DB Connections 



Infinite Free DB Backup
======================================
**Same DB HOST**
1. Php file to do backup & save in .SQL
2. Manullay upload to Google drive by click on Button - DOne


**External DB Host**
1. Auto send mail with backup attachement using 
    - https://miztechsolutions.com/tools/backup
    - https://miztechsolutions.com/tools/mail

2. Cron job to Hit URL every 2 Weeks






# Process

### 1.Export DB to Excel
- Open db Phpdmin, select table, Foramte:CSV,  export > Custom > unselect all tables : only select one table > [check] Put columns names in the first row
- Convert CSV to EXCEL using https://convertio.co/csv-xlsx/
- Convert EXCEL to SQL https://sqlizer.io/


# Tools 
1. Excel to SQL file Conversion
https://sqlizer.io/

### Poster Generation for Actors
 - Download Image
 - https://www.remove.bg/



# Deployment
Go to https://smlcodes.deployhq.com/


We are using GitHub actions to do FTP Deploy.
1. https://smlcodes.deployhq.com/ (Best)

2. https://smlcodes.deploybot.com/ (2nd Best)

https://www.deployhq.com/

https://www.deploybot.com/

https://launchdeck.io/



# Features Upcoming
- Poster Generation with Telugu Font
- ~~Centers by type & city~~
- ~~New Fonts for poster~~
- Regenerate all Posters, if files deleted in server
- Update Actors photos
- Update Production Company Logo on Poster




# Code Snippets

| Sno | PHP file                      | Ajax Call                     | Usage                                         |
| --- | ----------------------------- | ----------------------------- | --------------------------------------------- |
| 1   | makemovie.php                 |                               | SELECT actor, director,etc                    |
| 2   | makemovie2.php                |                               | SELECT Music, Cinmatao,etc                    |
| 3   | readyforshoot.php             |                               | Displays Ready to Shoot Items                 |
| 4   | shooting.php?rid=125          |                               | Shooting Movie                                |
|     |                               | ratingAjax.php?rid=125        | On Shoot Button                               |
|     |                               | shootingAjax.php?rid=125&s=s3 | On Next Button                                |
| 5   | shootout.php?rid=125&uid=111  |                               | On Finish Shoot button, UPDATE CENTERS        |
| 6   | readyforrelease.php           |                               | Displays Ready to Release Items               |
| 7   | release.php?rid=125           |                               | Displays DIRECT RELEASE & ADD CENETERS Option |
| 8   | released.php?news=msg&rid=125 |                               | On Direct Release Button                      |
| 9   | addcenters.php?rid=125        |                               | On Add Centers Button, UPDATE CENTERS         |
| 10  | running.php?rid=125           |                               | On Running Movie                              |
| 11  | runningAjax.php?rid=125&day=3 |                               | To Update Out of thereaters , Days count      |
| 12  | forceout.php?id=125           |                               | Force Out of theraters                        |


- Centers logic - addcenters.php, shootout.php both files we need to update
- Review logic - addcenters.php, shootout.php both files we need to update

CRON
```
Minute	Hour	Day	Month	Weekday	Command	Actions
0	1	1,15	*	*	curl https://miztechsolutions.com/tools/backup	    
0	3	1,15	*	*	curl https://miztechsolutions.com/tools/mail
```
If you got this error `This site requires Javascript to work, please enable Javascript in your browser or use a browser with Javascript support`,
please check BACKUP_DIR in bkp.php & sendmail.php files

---

## 🛠️ Unified Database Migrations (Phinx)
Database migrations are fully automated and synchronized dynamically inside the project:
* **Migration Directory**: `db/migrations/` (contains raw `.sql` migration files and Phinx `.php` wrappers).
* **Automatic Runs**: Migrations are executed programmatically and silently on page load or deployment in `db.php` if any new migration version is detected.
* **Performance Caching**: Once migrations are completed, a local cache file `db/migrations/.migrated` is created. Subsequent requests skip all checks entirely, resulting in **0ms** runtime overhead.

## 📅 Automated Backup Scheduler
You can schedule automated database backups with dynamic CRON expressions:
* **UI Management**: Manage the schedule directly via the *Automated Backup Scheduler (CRON)* panel on `bkp.php`.
* **Execution Endpoint**: Trigger the schedule by configuring your external health check or cron ping service to hit **`https://hitapp.wasmer.app/cron.php`** periodically (e.g. every 15 minutes).
* **Email Alerts**: Automatically sends success email notifications containing the `.sql` backup file, or failure notifications containing the error trace logs to configured recipients.

## 🏥 Server Health Monitor
A centralized dashboard and endpoint are exposed to check the application state:
* **URL**: `https://hitapp.wasmer.app/health.php` (Web Dashboard)
* **API URL**: `https://hitapp.wasmer.app/health.php?format=json` (JSON endpoint for monitoring services like UptimeRobot/Better Uptime).
* **ChecksPerformed**: Server environment specs, MySQL connection status and latency, active mail provider config, SMTP network handshakes, and backups storage health.

