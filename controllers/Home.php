<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class Home{

    public function getHomePageData()
    {
        $getContent = HomeModel::getHomePageData();
        echo $getContent; exit;
    }

}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

$home = new Home();

if(isset($_POST['getContent'])){
    $home->getHomePageData();
}
