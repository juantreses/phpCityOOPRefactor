<?php


class ViewService
{

    private $databaseService;

    public function __construct(DatabaseService $databaseService)
    {
        $this->databaseService = $databaseService;
    }

    public function basicHead( $css = "", $header )
    {
        global $_application_folder;
        global $login_form;
        global $register_form;
        global $no_access;

        $str_stylesheets = "";
        if ( is_array($css))
        {
            foreach( $css as $stylesheet )
            {
                $str_stylesheets .= '<link rel="stylesheet" href="' . $_application_folder . '/css/' . $stylesheet . '">' ;
            }
        }



        $data = array("stylesheets" => $str_stylesheets, "header" => $header, "messages" => $this->returnMessages() );

        unset($_SESSION["error"]);
        unset($_SESSION["info"]);

        $template = $this->loadTemplate("basic_head");
        print $this->replaceContentOneRow($data, $template);

        if (! $login_form and ! $register_form and ! $no_access ) {
            $this->printNavBar();
        }

        $_SESSION["head_printed"] = true;
    }

    private function printNavBar()
    {
        //Load the Menu Model from the database
        $menuModelArray = $this->loadMenuModels();
        $i = 0;
        //Get the data from each MenuModel in a array
        foreach ($menuModelArray as $menuModel)
        {
            $navbarItemsData[$i] = $this->getMenuModelDataInArray($menuModel);
            $i++;
        }

        // replace the data
        $template_navbar_item = $this->loadTemplate("navbar_item");
        $navbar_items = $this->replaceContent($navbarItemsData, $template_navbar_item);

        //navbar template samenvoegen met resultaat ($navbar_items)
        $data = array( "navbar_items" => $navbar_items ) ;
        $template_navbar = $this->loadTemplate("navbar");
        print $this->replaceContentOneRow($data, $template_navbar);
    }

    public function loadTemplate( $name )
    {
        if ( file_exists("$name.html") ) return file_get_contents("$name.html");
        if ( file_exists("templates/$name.html") ) return file_get_contents("templates/$name.html");
        if ( file_exists("../templates/$name.html") ) return file_get_contents("../templates/$name.html");
    }

    public function replaceContent( $data, $template_html )
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


    public function replaceCities( $cities, $template_html )
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
    public function replaceContentOneRow($row, $template_html )
    {
        //replace fields with values in template
        $content = $template_html;
        foreach($row as $field => $value)
        {
            $content = str_replace("@@$field@@", $value, $content);
        }

        return $content;
    }

    public function printWeekAndReturnNewDateForLink($week, $year)
    {
        // correction of the week //
        if( isset($_GET['week']) AND $week < 10 ) { $week = '0' . $week; }
        if ($week > 52)
        {
            $year++;
            $week = 1;
        }
        elseif ($week < 1)
        {
            $year--;
            $week = 52;
        }

        // getting 7 rows of data (day, date and tasks)
        for( $day=1; $day <= 7; $day++ )
        {
            $d = strtotime($year . "W" . $week . $day);
            $dataReplaceContent[$day - 1]['day'] = date("l", $d);
            $dataReplaceContent[$day - 1]['date'] = date("d/m/Y", $d);
            $data = $this->databaseService->getData( "SELECT taa_omschr FROM taak WHERE taa_datum = '".date("Y-m-d", $d)."'" );
            $dataReplaceContent[$day -1]['tasks']= $this->replaceContent($data,$this->loadTemplate("week_tasks"));

        }
        // get this data on the week.php page end replace the new links to previous and next week.

        $dataReplaceOneRow['tableContent'] =  $this->replaceContent($dataReplaceContent,$this->loadTemplate("week_table_row"));
        $dataReplaceOneRow['link_previous_week'] = "week.php?week=" . ($week == 1 ? 52 : $week - 1 ) . "&year=" . ($week == 1 ? $year - 1 : $year);
        $dataReplaceOneRow['link_next_week'] = "week.php?week=" . ($week == 1 ? 52 : $week + 1 ) . "&year=" . ($week == 1 ? $year + 1 : $year);
        print $this->replaceContentOneRow($dataReplaceOneRow,$this->loadTemplate("week_table"));
        return $newDate= array($week,$year);
    }

    public function renderWeek() {
        // Get the year and week
        $year = (isset($_GET['year'])) ? $_GET['year'] : date("Y");
        $week = (isset($_GET['week'])) ? $_GET['week'] : date("W");

        // print the week and return the new date(link updated in class)
        $newdate = $this->printWeekAndReturnNewDateForLink($week,$year);
        $week = $newdate[0];
        $year = $newdate[1];
    }


    private function returnMessages()
    {
        //weergeven 2 soorten messages: errors en infos
        foreach( array("error", "info") as $type )
        {
            if ( key_exists("$type", $_SESSION) AND is_array($_SESSION["$type"]) AND count($_SESSION["$type"]) > 0 )
            {
                foreach( $_SESSION["$type"] as $message )
                {
                    $row = array( "message" => $message );
                    $templ = $this->loadTemplate("$type" . "s");
                    return $this->replaceContentOneRow( $row, $templ );
                }
            }
        }
    }

    /**
     * @return array
     */
    private function loadMenuModels()
    {
        //check the page your one to know the active menu item
        $laatste_deel_url = basename($_SERVER['SCRIPT_NAME']);
        //collect the data from the database
        $data = $this->databaseService->getData("select * from menu order by men_order");
        // each menu item is loaded in a menuModel
        foreach ($data as $row)
        {
            $menu = new Menu($row);
            if ( $laatste_deel_url == $menu-> getDestination() )
            {
                $menu->setActive('active');
                $menu->setSrOnly('<span class="sr-only">(current)</span>');
            }
            $menuModelArray[] = $menu;

        }
        // return a array of menuModels
        return $menuModelArray;
    }

    /**
     * @param Menu $menuModel
     * @return array
     */
    private function getMenuModelDataInArray(Menu $menuModel)
    {
        // put the data of the menuModel in a array
        $dataRow = array();
        $dataRow['men_caption'] = $menuModel->getCaption();
        $dataRow['men_destination'] = $menuModel->getDestination();
        $dataRow['men_order'] = $menuModel->getOrder();
        $dataRow['men_id'] = $menuModel->getId();
        $dataRow['active'] = $menuModel->getActive();
        $dataRow['sr_only'] = $menuModel->getSrOnly();
        return $dataRow;
    }


}