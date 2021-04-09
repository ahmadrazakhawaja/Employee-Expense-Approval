<?php
$servername = "localhost";
$username = "root";
$password = '';
$database = "EMP_app";

try{
$conn = new PDO("mysql:host=$servername; dbname=$database;",$username,$password);
$conn->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
}
catch(PDOException $error){

    echo 'Connection failed' . $error->getMessage();
}
return $conn;
?>