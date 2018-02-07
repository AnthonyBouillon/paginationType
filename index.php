        <!-- Ajout d'avatar pour le profil de l'utilisateur -->
        <?php
           /* * Ajout d'avatar * *
           * Vérifie si l'utilisateur est connecté
           * Vérifie si il y a une image et que le nom de cette image ne soit pas vide
           */
            if(isset($_SESSION['id'])){
            if(isset($_FILES['avatar']) && !empty($_FILES['avatar']['name'])){
                // Taille maximum de l'image
                $maxSize = 9000000;
                // Les extensions d'images autorisés
                $validsExtensions = array('jpg', 'jpeg', 'png', 'gif');
                // Si la taille de l'image est inférieur ou égale à la taille maximum 
                if($_FILES['avatar']['size'] <= $maxSize){
                    // On met notre chaine en minuscule et on recupère l'extension après le point de notre fichier avec strrchr
                    $extensionUpload = strtolower(substr(strrchr($_FILES['avatar']['name'], '.'), 1));
                    // Si l'extension de l'image reçue fait partie des extensions valide
                    if(in_array($extensionUpload, $validsExtensions)){
                        // Le chemin des images reçues
                        $path = 'members/avatars/' . $_SESSION['id'] . '.' . $extensionUpload;
                        // Fonction qui déplace le fichier au chemin assigné à la variable $path
                        $movement = move_uploaded_file($_FILES['avatar']['tmp_name'], $path);
                        // Si l'image qu'il a choisi est déplacé dans le dossier : ça l'ajoute et le met à jour dans la base de donnée
                        if($movement){
                            $request = $database->prepare('UPDATE `members` SET `avatar` =:avatar WHERE `id` =:id');
                            $request->bindValue(':avatar', $_SESSION['id'] . '.' . $extensionUpload);
                            $request->bindValue(':id', $_SESSION['id']);
                            $request->execute();
                        }else{
                            echo 'Erreur durant l\'importation du fichier, veuillez réessayer avec une autre image';
                        }
                        // /fin de ce if
                    }else{
                        echo 'Votre image doit être au format : jpg, jpeg, png ou gif';
                    }
                }else{
                    echo 'Votre photo de profil ne doit pas dépasser 8 mo';
                }
            }
        }else{
            echo 'Vous devez être connecté';
        }
        
        // Test d'ajout d'avatar en html -->
        if(isset($_SESSION['id'])){ ?>
        <form method="POST" action="" enctype="multipart/form-data">
        <label>Choisi ton avatar : </label>
        <input type="file" name="avatar" />
        <input type="submit" />
        </form>