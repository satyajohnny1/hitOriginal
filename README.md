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
- Centers by type & city
- New Fonts for poster 
- Regenerate all Posters, if files deleted in server




# Code Snippets

- Centers logic - addcenters.php
