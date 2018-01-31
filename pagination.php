<?php
//Nous récupérons le contenu de la requête dans $retour_total
$requete = $database->query('SELECT COUNT(`id`) AS `pages` FROM patients');
$result = $requete->fetchAll(PDO::FETCH_OBJ);
foreach ($result AS $total) {
    $messagesPerPage = 3;
    $numberOfPages = ceil($total->pages / $messagesPerPage);
}
if (isset($_GET['page'])) {
    //  Retourne la valeur numérique entière équivalente d'une variable
    $currentPage = intval($_GET['page']);
    if ($currentPage > $numberOfPages) {
        $currentPage = $numberOfPages;
    }
} else {
    $currentPage = 1;
}
$firstEntry = ($currentPage - 1) * $messagesPerPage; // On calcul la première entrée à lire
// La requête sql pour récupérer les messages de la page actuelle.
$requete = $database->query('SELECT `id`, `lastname`, `firstname`, DATE_FORMAT(`birthdate`, \' %d/%m/%Y \') AS `birthdate`, `phone`, `mail` FROM `patients` ORDER BY `id` DESC LIMIT ' . $firstEntry . ', ' . $messagesPerPage . '');
$result = $requete->fetchAll(PDO::FETCH_OBJ);

  <!-- PAGINATION -->
        <div class="row">
            <p class="text-center">
            <?php
            for ($i = 1; $i <= $numberOfPages; $i++) {
                if ($i == $currentPage) {
                    echo ' [ ' . $i . ' ] ';
                } else {
                    echo ' <a href="liste-patients.php?page=' . $i . '">' . $i . '</a> ';
                }
            }
            ?></p>
        </div>
