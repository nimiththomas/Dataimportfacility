# Dataimportfacility
a data import facility to extract data from csv files using html and css with mysql as database.

Abstract
Importing data with different formats into a properly formatted database table is an important feature for web-based systems that involve data analytics, mailing lists, content management, upload facilities and more. 
When building file and data upload systems it is critical to ensure that all imported data is valid, is in the right format and is not malicious. 
In short, a data import facility loads data onto a server or system that meets certain formatting or other requirements and also cleans and checks the data being uploaded. 

This system
-Accepts correctly formatted CSV files for upload
-Checks and cleans uploaded CSV file data then adds it to a database
-Creates a display that can view some database data

Format of csv files accepted currently

-products.csv
productid
name
cost
status
date_added

-purchases.csv
username
productid
quantity
time_placed

-users.csv
username
password
email
name

To do 
change the name ,username, password , host according to your mysql server details in db_connect
change  all the href tags tags to your domain name.

open the system by opening upload.php


