<?php 

$servername = "localhost";
$username = "root"; // Il tuo nome utente del database
$password = ""; // La tua password del database
$dbname = "outdoortribeDB"; // Il nome del tuo database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn == false) {
    die("Connessione fallita: " . $conn->connect_error);
}