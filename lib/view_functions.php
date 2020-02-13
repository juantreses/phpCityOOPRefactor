<?php
/* Deze functie laadt de <head> sectie */
function BasicHead( $css = "" )
{
    global $_application_folder;

    $str_stylesheets = "";
    if ( is_array($css))
    {
        foreach( $css as $stylesheet )
        {
            $str_stylesheets .= '<link rel="stylesheet" href="' . $_application_folder . '/css/' . $stylesheet . '">' ;
        }
    }

    $data = array("stylesheets" => $str_stylesheets );
    $template = LoadTemplate("basic_head");
    print ReplaceContentOneRow($data, $template);

    $_SESSION["head_printed"] = true;
}

function PrintNavBar()
{
    //navbar items ophalen
    $data = GetData("select * from menu order by men_order");

    $laatste_deel_url = basename($_SERVER['SCRIPT_NAME']);

    //aan de juiste datarij, de sleutels 'active' en 'sr-only' toevoegen
    foreach( $data as $r => $row )
    {
        if ( $laatste_deel_url == $data[$r]['men_destination'] )
        {
            $data[$r]['active'] = 'active';
            $data[$r]['sr_only'] = '<span class="sr-only">(current)</span>';
        }
        else
        {
            $data[$r]['active'] = '';
            $data[$r]['sr_only'] = '';
        }
    }

    //template voor 1 item samenvoegen met data voor items
    $template_navbar_item = LoadTemplate("navbar_item");
    $navbar_items = ReplaceContent($data, $template_navbar_item);

    //navbar template samenvoegen met resultaat ($navbar_items)
    $data = array( "navbar_items" => $navbar_items ) ;
    $template_navbar = LoadTemplate("navbar");
    print ReplaceContentOneRow($data, $template_navbar);
}

/* Deze functie laadt de opgegeven template */
function LoadTemplate( $name )
{
    if ( file_exists("$name.html") ) return file_get_contents("$name.html");
    if ( file_exists("templates/$name.html") ) return file_get_contents("templates/$name.html");
    if ( file_exists("../templates/$name.html") ) return file_get_contents("../templates/$name.html");
}

/* Deze functie voegt data en template samen en print het resultaat */
function ReplaceContent( $data, $template_html )
{
    $returnval = "";

    foreach ( $data as $row )
    {
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

        $returnval .= $content;
    }

    return $returnval;
}

/* Deze functie voegt data en template samen en print het resultaat */
function ReplaceCities( $cities, $template_html )
{
    $returnval = "";

    foreach ( $cities as $city )
    {
        $content = $template_html;
        $content = str_replace("@@img_id@@", $city->getId(), $content);
        $content = str_replace("@@img_title@@", $city->getTitle(), $content);
        $content = str_replace("@@img_filename@@", $city->getFileName(), $content);
        $content = str_replace("@@img_width@@", $city->getWidth(), $content);
        $content = str_replace("@@img_height@@", $city->getHeight(), $content);

        $returnval .= $content;
    }

    return $returnval;
}

/* Deze functie voegt data en template samen en print het resultaat */
function ReplaceContentOneRow( $row, $template_html )
{
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

    return $content;
}