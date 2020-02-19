<?php
$register_form = true;
require_once "lib/autoload.php";

$css = array( "style.css");
BasicHead( $css );
$MS->ShowMessages();
?>
<body>

<div class="jumbotron text-center">
    <h1>Registratie</h1>
</div>

<div class="container">
    <div class="row">

        <?php
        $views = new ViewService();
        print $views->loadTemplate("register");
        ?>

    </div>
</div>

</body>
</html>