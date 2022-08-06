<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class HomeModel{

    protected static $dbc;

    public function __construct(){
        Self::$dbc = DB::getDbConn();
    }

    public static function getHomePageData()
    {
        $blogData = Self::$dbc->query("SELECT * FROM blog_data");
        if($blogData->num_rows > 0){
            $data = $blogData->fetch_assoc();
            return json_encode(["status" => true, "data" => $data, "type" => "data_found"]);
        }

        return json_encode(["status" => false, "type" => "no_data_found"]);
    }

}

$homemodel = new HomeModel();

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});