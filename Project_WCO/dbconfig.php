<?php
// SQL Server configuration
$serverName="192.168.**.**";
$dbUsername="userselect";
$dbPassword="**********";
$dbName="SNCrawler";

// Create database connection
try{
    $conn = new PDO("sqlsrv:Server=$serverName;Database=$dbName", $dbUsername, $dbPassword);
    $conn->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
}catch(PDOException $e){
    die("Error connecting to SQL Server:".$e->getMessage());
}/*catch(CDBException $pe){
    die("Could not connect to the database");
}*/
?>