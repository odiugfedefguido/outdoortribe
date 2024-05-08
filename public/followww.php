<?php
session_start();
include("./../server/connection.php");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Controlla se l'utente è loggato
    if (isset($_SESSION['user_id'])) {
        // Verifica se l'ID dell'utente da seguire è stato passato
        if (isset($_POST['followed_id'])) {
            $follower_id = $_SESSION['user_id']; // Utilizza l'ID dell'utente corrente
            $followed_id = $_POST['followed_id']; // Utilizza l'ID dell'utente da seguire

            // Esegui la query per inserire la relazione di follow nella tabella 'follow'
            $query = "INSERT INTO follow (follower_id, followed_id) VALUES (?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $follower_id, $followed_id);

            if ($stmt->execute()) {
                // Rispondi con successo
                http_response_code(200);
            } else {
                // Errore nell'esecuzione della query
                http_response_code(500);
                echo "Errore nell'esecuzione della query: " . $stmt->error;
            }
        } else {
            // Errore: l'ID dell'utente da seguire non è stato fornito
            http_response_code(400);
            echo "ID dell'utente da seguire non fornito.";
        }
    } else {
        // Errore: l'utente non è loggato
        http_response_code(401);
        echo "Utente non autorizzato.";
    }
} else {
    // Errore: metodo di richiesta non consentito
    http_response_code(405);
    echo "Metodo di richiesta non consentito.";
}


$conn->close();
?>
