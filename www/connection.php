<?php
//variables
$hostname = "localhost";
$username = "root";
$password = "";
$dbname = "test";

//connection
$dbc = mysqli_connect($hostname, $username, $password, $dbname)
OR die("could not connect to database, ERROR: " .mysqli_connect_error());

$query = "CREATE TABLE IF NOT EXISTS Builders (id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, password VARCHAR(25) NOT NULL,
  PRIMARY KEY (id));";
$query2 = "CREATE TABLE IF NOT EXISTS Owners (id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, password VARCHAR(25) NOT NULL,
  PRIMARY KEY (id));";
$query3 = "CREATE TABLE IF NOT EXISTS ChecklistItems (id INT NOT NULL AUTO_INCREMENT,
  checklist_id INT NOT NULL, description VARCHAR(50),
  PRIMARY KEY (id), FOREIGN KEY (checklist_id) REFERENCES Checklists(id));";
$query4 = "CREATE TABLE IF NOT EXISTS Checklists (id INT NOT NULL AUTO_INCREMENT,
  username VARCHAR(20) NOT NULL, email VARCHAR(20) NOT NULL, password VARCHAR(25) NOT NULL,
  PRIMARY KEY (id));";
$query5 = "CREATE TABLE IF NOT EXISTS Sessions (id INT NOT NULL AUTO_INCREMENT, name VARCHAR(25) NOT NULL,
  owner_id INT NOT NULL, builder_id INT NOT NULL, checklist_id INT NOT NULL, PRIMARY KEY (id),
  FOREIGN KEY (owner_id) REFERENCES Owners(id), FOREIGN KEY (builder_id) REFERENCES Builders(id),
  FOREIGN KEY (checklist_id) REFERENCES Checklists(id));";
?>
