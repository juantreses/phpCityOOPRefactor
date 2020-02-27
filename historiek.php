<?php
require_once "lib/autoload.php";

$css = array( "style.css");
$viewService->basicHead($css);
?>
    <body>

    <div class="jumbotron text-center">
        <h1>Mijn historiek</h1>
    </div>
    <?php $viewService->printNavBar(); ?>

    <div class="container">
        <div class="row">

            <p>Gebruiker: <?= $_SESSION['usr']->getVoornaam() ?> <?=$_SESSION['usr']->getNaam() ?></p>
            <table class="table">
                <tr>
                    <th>Inloggen</th>
                    <th>Uitloggen</th>
                </tr>
                    <?php
                    $databaseService = $container->getDatabaseService();
                        $sql = "SELECT * FROM log_user WHERE log_usr_id=" . $_SESSION['usr']->getId() . " ORDER BY log_in" ;
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