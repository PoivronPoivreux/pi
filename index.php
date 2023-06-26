<!DOCTYPE html>
<html>
<head>
    <title>Upload de fichiers</title>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>Upload de fichiers</h1>
        
        <form method="post" enctype="multipart/form-data">
            <input type="file" name="fileToUpload" id="fileToUpload" required>
            <input type="submit" value="Upload" name="submit">
        </form>

        <?php
        if (isset($_POST["submit"])) {
            $targetDirectory = "/var/www/html/files/"; // Spécifiez le répertoire de stockage
            $targetFile = $targetDirectory . basename($_FILES["fileToUpload"]["name"]);
            $uploadOk = 1;
            $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));

            // Vérifiez si le fichier est une image réelle ou une fausse image
            if (isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if ($check !== false) {
                    echo "Le fichier est une image - " . $check["mime"] . ".";
                    $uploadOk = 1;
                } else {
                    echo "Le fichier n'est pas une image.";
                    $uploadOk = 0;
                }
            }

            // Vérifiez si le fichier existe déjà
            if (file_exists($targetFile)) {
                echo "Désolé, ce fichier existe déjà.";
                $uploadOk = 0;
            }

            // Vérifiez la taille du fichier
            if ($_FILES["fileToUpload"]["size"] > 500000) {
                echo "Désolé, le fichier est trop volumineux.";
                $uploadOk = 0;
            }

            // Autorisez uniquement certains formats de fichiers
            if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
                echo "Désolé, seuls les fichiers JPG, JPEG, PNG et GIF sont autorisés.";
                $uploadOk = 0;
            }

            // Vérifiez si $uploadOk est défini à 0 par une erreur
            if ($uploadOk == 0) {
                echo "Désolé, votre fichier n'a pas été téléchargé.";
            } else {
                // Si tout va bien, essayez de télécharger le fichier
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $targetFile)) {
                    echo "Le fichier " . basename($_FILES["fileToUpload"]["name"]) . " a été téléchargé avec succès.";
                } else {
                    echo "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                }
            }
        }
        ?>
    </div>
</body>
</html>
