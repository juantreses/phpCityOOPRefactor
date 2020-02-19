<?php


class ViewService
{
    public function loadTemplate( $name )
    {
        if ( file_exists("$name.html") ) return file_get_contents("$name.html");
        if ( file_exists("templates/$name.html") ) return file_get_contents("templates/$name.html");
        if ( file_exists("../templates/$name.html") ) return file_get_contents("../templates/$name.html");
    }

    public function displayImages( $images )
    {
        foreach( $images as $img )
        {
            print "<div class='div_thumb'>";
            print "<img class='thumbnail' src='$img'><br>";
            print "<span class='img_name'>$img</span>";
            print "</div>";
        }
    }
}