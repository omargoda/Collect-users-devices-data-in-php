# Collect-users-devices-data-in-PHP
This is a PHP web application that is used to collect users' devices data such as IP address, operating system, screen width and height, web browser, and then stores it into a MySQL database...  
The application uses the http request header information.  
  
It consists of 4 files (3 PHP modules and 1 HTML file) as follows:  
- Counter.php: PHP-rendered web page that renders the records count in the database and live-updates it by communicating with the counterApp.php API file.   
- counterApp.php: API file that sends the count of the records in the database to the client.  
- index.html: The page that collects users' data and then sends it to the server using AJAX request to the screenRecorder.php file.  
- screenRecorder.php: A PHP module that receives the request header from the index.html file and then inserts the records into a MySQL database, then returns the server response to the client with success or error messages.  
  
To start using this application on your own server and domain, you have to do the follwoing steps:  
1- Create a MySQL database with a table called 'screens'.  
2- screens table should have the follwoing columns with the exact same order: ip, os, browser, height, width, string.  
3- Edit all the three PHP modules by updating the database user data like hostname, database name, username, password in the PDO statement.  
4- Edit the 'domain-name' parameter in the function setCookie() in the screenRecorder.php module.
