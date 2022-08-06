<?php
error_reporting( E_ALL );
ini_set( "display_errors", 1 );

class Dashboard{

    protected static $acceptedOrigins = array("http://localhost", "http://hestalabs.com");

    public function getEditorData($editorContent)
    {
        $editorContent = addslashes($editorContent);
        $saveData = DashboardModel::saveBlog($editorContent);
        echo $saveData; exit;

    }

    public function fileHandler()
    {
        $imageFolder = "../uploadimage/";
        echo $_SERVER['REQUEST_METHOD'];
        die(" origin");
        if (isset($_SERVER['HTTP_ORIGIN'])) { 
            if (in_array($_SERVER['HTTP_ORIGIN'], Self::$acceptedOrigins)) { 
                header('Access-Control-Allow-Origin: ' . $_SERVER['HTTP_ORIGIN']); 
            } else { 
                header("HTTP/1.1 403 Origin Denied"); 
                return; 
            } 

            if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') { 
                header("Access-Control-Allow-Methods: POST, OPTIONS"); 
                return; 
            } 

            reset ($_FILES); 
            $temp = current($_FILES); 
            if (is_uploaded_file($temp['tmp_name'])){ 
                if (preg_match("/([^\w\s\d\-_~,;:\[\]\(\).])|([\.]{2,})/", $temp['name'])) { 
                    header("HTTP/1.1 400 Invalid file name."); 
                    return; 
                } 
            
                if (!in_array(strtolower(pathinfo($temp['name'], PATHINFO_EXTENSION)), array("gif", "jpg", "jpeg", "png"))) { 
                    header("HTTP/1.1 400 Invalid extension."); 
                    return; 
                } 
            
                $filetowrite = $imageFolder . $temp['name']; 

                // if(move_uploaded_file($temp['tmp_name'], $filetowrite)){ 
                    $filetowrite = "uploadimage/" . $temp['name'];
                    $protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on' ? "https://" : "http://";
                    // $baseurl = $protocol . $_SERVER["HTTP_HOST"] . rtrim(dirname($_SERVER['REQUEST_URI']), "/") . "/";
                    $baseurl = $protocol . $_SERVER["HTTP_HOST"] . '/projectTwo/';
                    echo "protocol -- ". $protocol . "<br>";
                    echo "http_host -- ".  $_SERVER["HTTP_HOST"] . "<br>";
                    echo "base + filetowrite -- ".  $baseurl . $filetowrite . "<br>";
                    echo "baseurl -- ".  $baseurl ;
                    die(" yyyyyyyy ");
                    echo json_encode(array('location' => $baseurl . $filetowrite)); 
                // }else{ 
                //     header("HTTP/1.1 400 Upload failed."); 
                //     return; 
                // } 
            } else {  
                header("HTTP/1.1 500 Server Error"); 
            } 
        } 
    }
}

spl_autoload_register(function ($className) {
    require_once("./models/" . $className . ".php");
});

$dashboard = new Dashboard();

// print_r($_POST);
// print_r($_FILES);
// die(" ggg ");

if(isset($_POST['text_editor']) && !empty($_POST['text_editor'])){
    $dashboard->getEditorData($_POST['text_editor']);
}

if(isset($_FILES['file']['name'])){
    $dashboard->fileHandler();
}