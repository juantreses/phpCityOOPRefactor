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

$viewService->basicHead($css, "Login");
$MS->ShowMessages();
?>
<div class="container">
    <div class="row">

        <?php
        print $viewService->loadTemplate("login");
        ?>

    </div>
</div>

</body>
</html>