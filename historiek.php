<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css, "Mijn Historiek");
$userservice = $container->getUserService();
$user = $userservice->loadUserFromId($_SESSION['usr_id'])
?>

    <div class="container">
        <div class="row">

            <p>Gebruiker: <?= $user->getVoornaam() ?> <?=$user->getNaam() ?></p>
            <table class="table">
                <tr>
                    <th>Inloggen</th>
                    <th>Uitloggen</th>
                </tr>
                    <?php
                    $databaseService = $container->getDatabaseService();
                        $sql = "SELECT * FROM log_user WHERE log_usr_id=" . $_SESSION['usr_id']. " ORDER BY log_in" ;
                        $data = $databaseService->getData($sql);

                        foreach( $data as $row )
                        {
                            echo "<tr>";
                            echo "<td>" . $row['log_in'] . "</td>";
                            echo "<td>" . $row['log_out'] . "</td>";
                            echo "</tr>" ;
                        }
                    ?>
            </table>

        </div>
    </div>
    </body>
</html>