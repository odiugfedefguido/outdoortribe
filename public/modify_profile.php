<?php
session_start();

// Inclusione del file di connessione al database e delle funzioni ausiliarie
include("./../server/connection.php");
include("./../admin/functions.php");

// Controlla se il form è stato inviato
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $current_user_id = 5; // Sostituire con $_SESSION['user_id'] nella versione finale

    // Inizializza le variabili per contenere i valori da aggiornare
    $newImage = null;
    $error_message = "";

    // Controlla se è stata caricata una nuova immagine
    if (isset($_FILES["profilePic"]) && $_FILES["profilePic"]["error"] === UPLOAD_ERR_OK) {
        $newImage = file_get_contents($_FILES["profilePic"]["tmp_name"]);

        if ($newImage !== false) {
            // Chiama la funzione per aggiornare l'immagine del profilo
            if (updateImgProfile($conn, $newImage, $current_user_id)) {
                // Redirect alla pagina del profilo
                header("Location: ./../public/profilepage.php");
                exit;
            } else {
                $error_message = "Errore durante l'aggiornamento dell'immagine del profilo.";
            }
        } else {
            $error_message = "Errore durante la lettura del file dell'immagine.";
        }
    } else {
        $error_message = "Nessuna immagine selezionata o errore durante il caricamento.";
    }

    if (!empty($error_message)) {
        echo "<script>
                alert('$error_message');
                window.setTimeout(function() {
                    window.location.href = './../public/profilepage.php';
                }, 100);
              </script>";
    }
}
?>
