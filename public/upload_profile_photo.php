<?php
session_start();
include ("../server/connection.php");
include ("../admin/functions.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['image'])) {
    $user_id = 1;//$_SESSION['user_id'];
    $image = $_FILES['image'];
    $uploadPath = './../uploads/photos/profile/';
    $allowedExtensions = ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'];

    $uploadErrors = []; // Array to store upload errors

    $imageName = basename($image['name']);
    $imageType = pathinfo($imageName, PATHINFO_EXTENSION);
    $imageTmp = $image['tmp_name'];

    if (!empty($imageName)) { // Check if file name is not empty
        if (in_array($imageType, $allowedExtensions)) {
            $newImageName = str_replace(' ', '_', uniqid('img', true) . '.' . strtolower($imageType));
            $imageUploadPath = $uploadPath . $newImageName;

            if (move_uploaded_file($imageTmp, $imageUploadPath)) {
                $updateQuery = "UPDATE photo SET name = ? WHERE post_id IS NULL AND user_id = ?";
                $updateStmt = $conn->prepare($updateQuery);

                if ($updateStmt) {
                    $updateStmt->bind_param('si', $newImageName, $user_id);

                    if ($updateStmt->execute()) {
                        // Image uploaded and updated successfully in the database
                    } else {
                        $uploadErrors[] = "Failed to update the image in the database!";
                    }
                } else {
                    $uploadErrors[] = "Failed to prepare the database statement!";
                }
            } else {
                $uploadErrors[] = "Failed to upload the image!";
            }
        } else {
            $uploadErrors[] = "File type not allowed: $imageType";
        }
    } else {
        $uploadErrors[] = "Please upload a photo!";
    }

    // Check if there are upload errors and show alert
    if (!empty($uploadErrors)) {
        echo '<script>';
        foreach ($uploadErrors as $error) {
            echo 'alert("' . $error . '");';
        }
        echo '</script>';
    } else {
        // Redirect to profile page after successful upload
        header("Location: ./../public/profilepage.php");
        exit();
    }
}
?>
