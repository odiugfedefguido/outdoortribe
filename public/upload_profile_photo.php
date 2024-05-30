<?php
session_start();
include("./../server/connection.php");

// Inizializza un array per la risposta
$response = array();

// Verifica se il metodo della richiesta è POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Verifica se esistono il file 'profile_photo' e l'ID utente
    if (isset($_FILES['profile_photo']) && isset($_POST['user_id'])) {
        echo "File and user ID provided";
        $user_id = intval($_POST['user_id']); // Ottieni l'ID utente come numero intero
        $file = $_FILES['profile_photo']; // Ottieni il file caricato

        // Valida il file (controlla il tipo di file, dimensione, ecc.)
        $allowedTypes = array(IMAGETYPE_PNG, IMAGETYPE_JPEG, IMAGETYPE_GIF); // Tipi di file consentiti
        $detectedType = exif_imagetype($file['tmp_name']); // Ottieni il tipo di immagine rilevato
        if (!in_array($detectedType, $allowedTypes)) {
            // Se il tipo di file non è consentito, imposta una risposta di errore e termina
            $response['success'] = false;
            $response['message'] = "Tipo di file non valido.";
            echo json_encode($response);
            exit();
        }

        // Crea la directory di destinazione se non esiste
        $uploadDir = './../uploads/photos/profile/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Sposta il file caricato nella directory di destinazione
        $fileName = basename($file['name']); // Ottieni il nome del file
        $targetFilePath = $uploadDir . $fileName; // Imposta il percorso di destinazione del file

        if (move_uploaded_file($file['tmp_name'], $targetFilePath)) {
            // Se il file è stato spostato correttamente, aggiorna il database
            $stmt = $conn->prepare("UPDATE photo SET name = ? WHERE user_id = ? AND post_id IS NULL");
            $stmt->bind_param("si", $fileName, $user_id); // Associa i parametri alla query
            if ($stmt->execute()) {
                // Se la query è eseguita con successo, imposta una risposta di successo
                $response['success'] = true;
                $response['new_photo_url'] = $targetFilePath; // URL della nuova foto
                echo "Photo updated successfully";
            } else {
                // Se la query fallisce, imposta una risposta di errore
                $response['success'] = false;
                $response['message'] = "Impossibile aggiornare il database.";
                echo "Error updating photo";
            }
            $stmt->close(); // Chiudi lo statement
        } else {
            // Se il file non può essere spostato, imposta una risposta di errore
            $response['success'] = false;
            $response['message'] = "Impossibile spostare il file caricato.";
        }
    } else {
        // Se non è stato fornito il file o l'ID utente, imposta una risposta di errore
        $response['success'] = false;
        $response['message'] = "File o ID utente non fornito.";
    }
} else {
    // Se il metodo della richiesta non è POST, imposta una risposta di errore
    $response['success'] = false;
    $response['message'] = "Metodo di richiesta non valido.";
}

$conn->close(); // Chiudi la connessione al database
echo json_encode($response); // Restituisci la risposta come JSON
?>
