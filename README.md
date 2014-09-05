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
Searchbox is a search application that lets a user search for files on a
computer. The user can download the search results directly in the
interface. The program reads filenames generated from a filesystem
command run in the shell and written to a file.
I created it because I needed a search engine for my files.


Screenshot
<img src="http://i.imgur.com/hH7PO87.png"/>


#LICENSE#
You can have this software for free.
It is licensed under the MIT license.
The complete license is available here:
http://choosealicense.com/licenses/mit/

#USAGE#
Execute index.php from a webbrowser on a server with php enabled

Needs a cronjob to work
the cronjob periodically recreates the database tables with new fresh
data.

#INITIAL SETUP#
Create a database on your mysql/mariadb server
Enable cronjob from the cronjob folder. Could also be run by a php cronjob.

Place project files in a directory where a webserver can see it.

Place cronjob files in /etc/cron.daily or whatever suits your needs.
Finetune path in thefile file, so that the shell script indexes
the correct folder.
Cronjob file makeitrain must be executable



symlinks:
Create symlink to the file archive and place it in the web folder
like this: ln -s /mnt/teraformer/research.library library
then the web folder should look like this:
output of: ls -l

61 Aug 31 08:43 books -> /mnt/cyberdynelabs/research.library

Create apache password protected area using a .htaccess file and the
htpasswd tool

#SECURITY NOTE#

This application must not be used on the public internet or where untrusted users roam. The app is only intented to be run in closed of environments with trusted users.
The code is not secure and at least is vulnerable to sql injection attacks.
It is not within the scope of the project to make a security hardened solution for now.


You must make sure to password protect your file area, or else the
folder will be accessible to the world.
Also enable SSL. To be sure, to be sure.
Don't mess this up.

ARCHITECHTURE
data layer:
mysql
simple select query with regexp

php html frontend
some css used for table


#KNOWN ISSUES#
Does not work with filenames with very crazy characters like the
' apostrophe and # hash signs.

The application is not secured against sql injection attacks


#TODO / WISHLIST#
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
v29
date 05.09.2014
Code somewhat refined. Output somewhat simplified.
License changed to MIT.

v27
date 03.09.2014
The search log is now displayed, including timestamp and hit counter.

v26
date 03.09.2014
Added a search log. Every query is now stored in the database

v24
date 31.08.2014
Code ready for public release now
Straighened code out a bit

v23
First acceptable stable version.
An attempt at proper release documentation. Still not done ready to release
to public. Will need some more code cleanup such as write some variables into the cronjob
file.
MVP