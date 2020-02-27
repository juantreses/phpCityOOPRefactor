<?php
$form = true;
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css);
$MS->showMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Registratie</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        var_dump($_SESSION);
        print $viewService->loadTemplate("register");
        ?>

    </div>
</div>

</body>
</html>