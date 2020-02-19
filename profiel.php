<?php
require_once "lib/autoload.php";
if (!$_SESSION['usr']-> getPasfoto() != "" )
{
    $MS->AddMessage("U moet uw Pasfoto opladen!!!", "error");
}

$css = array( "style.css");
$viewService->basicHead($css);
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Uw profiel</h1>
</div>

<?php $viewService->printNavBar(); ?>

<div class="container">

    <div class="row"><div class="col-sm-12">&nbsp;</div></div>

    <div class="row">

        <div class="col-sm-5">
            <?php

            //gebruikersgegevens ophalen uit databank
            $sql = "select * from users where usr_id=" . $_SESSION["usr"]->getId();
            $data = GetData($sql);
            $img_az_eid = "";
            $img_vz_eid = "";
            $img_pasfoto = "";
            print "<table class='table table-striped table-bordered'>";
            foreach( $data as $row )
            {
                foreach( $row as $field => $value )
                {
                    $notintable = false;

                    //foto's afhandelen
                    if ( $field == "usr_pasfoto" AND $value != "" ) { $img_pasfoto = "<img class='thumbnail' src=img/$value>"; $notintable = true; }
                    if ( $field == "usr_vz_eid" AND $value != "" ) { $img_vz_eid = "<img class='thumbnail' src=img/$value>"; $notintable = true; }
                    if ( $field == "usr_az_eid" AND $value != "" ) { $img_az_eid = "<img class='thumbnail' src=img/$value>"; $notintable = true; }

                    //password niet tonen
                    if ( $field == "usr_paswd" ) $notintable = true;

                    //alle andere velden weergeven
                    if ( !$notintable )
                    {
                        $caption = str_replace("usr_", "", $field);
                        $caption = strtoupper(substr($caption,0,1)) . substr($caption,1);
                        print "<tr><td>$caption</td><td>$value</td></tr>";
                    }
                }
            }
            print "</table>";
            ?>

        </div>

        <div class="col-sm-7">

            <?php
            print "<table class='table table-striped table-bordered'>";

            //formulier voor het opladen van de afbeeldingen
            print '<form action="lib/upload_functions_profiel.php" method="post" enctype="multipart/form-data">';

            print '<tr><td>Pasfoto</td><td><input type="file" name="pasfoto" id="pasfoto"></td><td>' . $img_pasfoto . '</td></tr>';
            print '<tr><td>E-id voorzijde</td><td><input type="file" name="eidvoor" id="eidvoor"></td><td>' . $img_vz_eid . '</td></tr>';
            print '<tr><td>E-id achterzijde</td><td><input type="file" name="eidachter" id="eidachter"></td><td>' . $img_az_eid . '</td></tr>';
            print '<tr><td></td><td><input type="submit" value="Opladen" name="submit"></td><td></td></tr>';

            print '</form>';

            print "</table>";
            ?>
        </div>


    </div>
</div>

</body>
</html>