<?php

error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class DashboardModel{

    protected static $dbc;

    public function __construct(){
        Self::$dbc = DB::getDbConn();
    }

    public static function saveBlog($editorContent)
    {
        $date = date('Y-m-d H:i:s');
        $query = Self::$dbc->query("SELECT * FROM blog_data");
        if($query->num_rows == 0){
            $insertQuery = " INSERT INTO blog_data ( content, created_at)
                             VALUES ( '$editorContent', '$date')";
            
            $runQuery = Self::$dbc->query($insertQuery);
            
            if($runQuery){
                return json_encode(["status" => true, "type" => "content_inserted", "message" => "Data inserted"]);
            }
            return json_encode(["status" => false, "type" => "content_not_inserted", "message" => "Data not inserted"]);
        }

        if($query->num_rows > 0){
            $selectData = $query->fetch_assoc();
            $updateQuery = "UPDATE blog_data SET content='$editorContent', created_at='$date' WHERE id=" .$selectData['id']. "";

            $runQuery = Self::$dbc->query($updateQuery);

            if($runQuery){
                return json_encode(["status" => true, "type" => "content_updated", "message" => "Data inserted"]);
            }
            return json_encode(["status" => false, "type" => "content_not_updated", "message" => "Data not inserted"]);
        }

    }

}

$dashboardmodel = new DashboardModel();

spl_autoload_register(function ($className) {
    require_once("./" . $className . ".php");
});