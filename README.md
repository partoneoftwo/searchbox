    ┌───────────────────────────────────────────────────────────────┐
    │                                                               │
    │  mmmm  mmmmmm   mm   mmmmm    mmm  m    m mmmmm   mmmm  m    m│
    │ #"   " #        ##   #   "# m"   " #    # #    # m"  "m  #  # │
    │ "#mmm  #mmmmm  #  #  #mmmm" #      #mmmm# #mmmm" #    #   ##  │
    │     "# #       #mm#  #   "m #      #    # #    # #    #  m""m │
    │ "mmm#" #mmmmm #    # #    "  "mmm" #    # #mmmm"  #mm#  m"  "m│
    │                                                               │
    │                                                               │
    └───────────────────────────────────────────────────────────────┘


#INTRODUCTION#
Searchbox is a web based search application that lets the user search
for files and download them from the browser.

Surprisingly this was not available in a simple package elsewhere so I
decided to write it myself.

The program reads filenames generated from a filesystem
command run in the shell and written to a file.

I created it because I needed a search engine for my files.


Screenshot
<img src="http://i.imgur.com/u7k6bbd.png"/>


#LICENSE#
Searchbox is free and libre software.
It is licensed under the MIT license.
The complete license is available here:
http://choosealicense.com/licenses/mit/

#USAGE#
Execute index.php from a webbrowser on a server with php enabled

#REQUIREMENTS#
Needs a cronjob to work
the cronjob periodically recreates the database tables with new fresh
data.
Postgresql
Apache with PHP

#INITIAL SETUP#

Database:
Create a postgresql user with password
Create a database on your postgresql

Config files:
edit /settings.php 
- and configure database settings

edit /installation/files/home/user/.pgpass 
- and enter postgresql details: database name databaseusername and databaseuserpass 

edit /installation.files/cron.daily/thefile
- and set the REPOSITORYPATH to where the files you wish to have indexed are located
- and enter postgresql details: database name databaseusername and databaseuserpass 

edit /installation.files/cron.daily/thefile.schema
- and set database credentials
- and change the second line: databasename to the actual database you
wish to use

Background files:
Enable cronjob from the cronjob folder. Copy the file to
/etc/cron.daily (for daily database updates) or /etc/cron.hourly (for
hourly database  updates)

Runtime files:
Place project files in a directory where the webserver can see it eg in /var/www

Place cronjob files in /etc/cron.daily or whatever suits your needs - this will update the database.
Finetune path in thefile file, so that the shell script indexes
the correct folder.
Cronjob file makeitrain must be executable


Symlink:
Create symlink to the file archive and place it in the web folder
like this: ln -s /mnt/cyberdynelabs/research.library library
then the web folder should look like this:
output of: ls -l

61 Aug 31 08:43 library -> /mnt/cyberdynelabs/research.library

Optional security:
Create apache password protected area using a .htaccess file and the
htpasswd tool
uncomment all the lines in the .htaccess line (remove hashes #).

#SECURITY NOTE#

The application should only be used behind a password protected area.
The code may very well not be secure. It is not using PDO's which makes it vulnerable to SQL Injection hacks.
It is not within the scope of the project to make a security hardened solution for now.


You must make sure to password protect your file area, or else the
folder will be accessible to the world.
Also enable SSL. To be sure, to be sure.


#ARCHITECHTURE#
data layer:
postgresql
select query with regexp

php html frontend
some css used for table


#KNOWN ISSUES#
Does not work with filenames with very crazy characters like the
' apostrophe and # hash signs.

The application is not secured against sql injection attacks


#TODO / WISHLIST#
* use a nice javascript library, maybe like Twitter Bootstrap to
change the GUI
DONE * fine tune the search log to only display the last 100 search
* Rewrite database connection to use the PDO abstraction layer
** This will solve the sql injection attack vulnerability
** It will probably also solve the escape weird character problem
** Must escape weird characters, particularly ~'# (probably others also) 
* a cool jQuery table for the search log
* maybe also a jQuery table for the search results
* some cool graphing widgets using the D3 library, like search
statistics graph
* secure the code against sql injection attacks

Over engineering suggestions (probably won't happen):
Write PDO code instead of mysqli queries, so that the code will
support any database engine supported by PDO abstraction layer.
Rewrite the entire UI with a jQuery library so that it becomes fancier.


#CHANGELOG#
v33 - 31.08.2014

* Mysql support ditched
* Data layer changed to postgresql
* New query in postgresql gives more precise results, slightly faster 
and it feels a lot better to work on Postgresql.
* Improvements made to design

v29 - 05.09.2014

Code somewhat refined. Output somewhat simplified.
License changed to MIT.

v27 - 03.09.2014

The search log is now displayed, including timestamp and hit counter.

v26 - 03.09.2014

Added a search log. Every query is now stored in the database

v24 - 31.08.2014

Code ready for public release now
Straighened code out a bit

v23 - unknown date

First acceptable stable version.
An attempt at proper release documentation. Still not done ready to release
to public. Will need some more code cleanup such as write some variables into the cronjob
file.
MVP