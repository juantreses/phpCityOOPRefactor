<?php
$login_form = true;
require_once "lib/autoload.php";

//redirect naar homepage als de gebruiker al ingelogd is
if ( isset($_SESSION['usr']) )
{
    $MS->AddMessage( "U bent al ingelogd!" );
    header("Location: " . $_application_folder . "/steden.php");
    exit;
}

$css = array( "style.css");
BasicHead( $css );

$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Login</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        print LoadTemplate("login");
        ?>

    </div>
</div>

</body>
</html>