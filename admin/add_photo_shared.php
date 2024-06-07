<?php
// Avvia la sessione
session_start();

// Inclusione del file di connessione al database
include("./../server/connection.php");

// Assicurati che l'utente sia autenticato
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
} else {
    header("Location: ./login.php");
    exit();
}

// Assicurati che il post_id e le immagini siano stati inviati correttamente
if (isset($_POST['post_id']) && isset($_FILES['images'])) {
    // Recupera l'ID del post e l'array delle immagini
    $post_id = $_POST['post_id'];
    $images = $_FILES['images'];

    // Percorso di upload delle immagini
    $target_dir = "../uploads/";
    
    // Itera attraverso ogni immagine
    foreach ($images['tmp_name'] as $key => $tmp_name) {
        // Genera un nome univoco per l'immagine
        $image_name = uniqid('image_') . '_' . basename($images['name'][$key]);
        $target_file = $target_dir . $image_name;

        // Verifica che il file sia un'immagine effettiva
        $check = getimagesize($tmp_name);
        if ($check !== false) {
            // Sposta il file nella cartella di destinazione
            if (move_uploaded_file($tmp_name, $target_file)) {
                // Inserisci i dettagli dell'immagine nel database
                $query = "INSERT INTO photo (post_id, user_id, name) VALUES (?, ?, ?)";
                $stmt = $conn->prepare($query);
                $stmt->bind_param("iis", $post_id, $user_id, $image_name);
                $stmt->execute();
                $stmt->close();
            } else {
                echo "Errore nel caricamento del file.";
            }
        } else {
            echo "Il file non è un'immagine valida.";
        }
    }
    
    // Ritorna alla pagina del post dopo aver aggiunto le immagini
    header("Location: ./../public/sharedd.php?post_id=$post_id");
    exit();
} else {
    // Se i dati non sono stati inviati correttamente, reindirizza o mostra un messaggio di errore
    echo "Dati mancanti.";
    exit();
}
?>
