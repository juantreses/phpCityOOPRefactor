<?php
$form = true;
require_once "lib/autoload.php";

$css = array( "style.css");

$viewService->basicHead($css, "Registratie"); ?>

<div class="container">
    <div class="row">

        <?php
        print $viewService->loadTemplate("register");
        ?>

    </div>
</div>

</body>
</html>