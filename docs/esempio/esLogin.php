<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>

<?php
// Connessione al database
$servername = "localhost";
$username = "root"; // Il tuo nome utente del database
$password = ""; // La tua password del database
$dbname = "outdoortribe"; // Il nome del tuo database

// Creazione della connessione
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica della connessione
if ($conn->connect_error) {
    die("Connessione fallita: " . $conn->connect_error);
}

// Verifica se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Recupero delle credenziali inserite dall'utente
    $id = $_POST['id'];
    $password = $_POST['password'];

    // Query per verificare se le credenziali sono presenti nel database
    $sql = "SELECT * FROM UTENTE WHERE id = '$id' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // L'utente è stato trovato nel database, quindi l'accesso è consentito
        echo "Entrato";
    } else {
        // Nessun utente corrisponde alle credenziali fornite, quindi l'accesso è negato
        echo "Accesso negato";
    }
}

// Chiusura della connessione
$conn->close();
?>

<!-- Form per l'inserimento delle credenziali -->
<h2>Login</h2>
<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
    <label for="id">ID:</label>
    <input type="text" id="id" name="id" required><br><br>
    <label for="password">Password:</label>
    <input type="password" id="password" name="password" required><br><br>
    <input type="submit" value="Login">
</form>

</body>
</html>
