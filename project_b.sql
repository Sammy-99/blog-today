-- Adminer 4.7.6 MySQL dump

SET NAMES utf8;
SET time_zone = '+00:00';
SET foreign_key_checks = 0;
SET sql_mode = 'NO_AUTO_VALUE_ON_ZERO';

SET NAMES utf8mb4;

DROP TABLE IF EXISTS `blog_data`;
CREATE TABLE `blog_data` (
  `id` int NOT NULL AUTO_INCREMENT,
  `content` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `blog_data` (`id`, `content`, `created_at`) VALUES
(3,	'<pre class=\"language-php\"><code>&lt;?php\r\n\r\nerror_reporting( E_ALL );\r\nini_set( \"display_errors\", 1 );\r\n\r\nclass DashboardModel{\r\n\r\n    protected static $dbc;\r\n\r\n    public function __construct(){\r\n        Self::$dbc = DB::getDbConn();\r\n    }\r\n\r\n    public static function saveBlog($editorContent)\r\n    {\r\n        $date = date(\'Y-m-d H:i:s\');\r\n        $query = Self::$dbc-&gt;query(\"SELECT * FROM blog_data\");\r\n        if($query-&gt;num_rows == 0){\r\n            $insertQuery = \" INSERT INTO blog_data ( content, created_at)\r\n                             VALUES ( \'$editorContent\', \'$date\')\";\r\n            \r\n            $runQuery = Self::$dbc-&gt;query($insertQuery);\r\n            \r\n            if($runQuery){\r\n                return json_encode([\"status\" =&gt; true, \"type\" =&gt; \"content_inserted\", \"message\" =&gt; \"Data inserted\"]);\r\n            }\r\n            return json_encode([\"status\" =&gt; false, \"type\" =&gt; \"content_not_inserted\", \"message\" =&gt; \"Data not inserted\"]);\r\n        }\r\n\r\n        if($query-&gt;num_rows &gt; 0){\r\n            $selectData = $query-&gt;fetch_assoc();\r\n            $updateQuery = \"UPDATE blog_data SET content=\'$editorContent\', created_at=\'$date\' WHERE id=\" .$selectData[\'id\']. \"\";\r\n\r\n            $runQuery = Self::$dbc-&gt;query($updateQuery);\r\n\r\n            if($runQuery){\r\n                return json_encode([\"status\" =&gt; true, \"type\" =&gt; \"content_updated\", \"message\" =&gt; \"Data inserted\"]);\r\n            }\r\n            return json_encode([\"status\" =&gt; false, \"type\" =&gt; \"content_not_updated\", \"message\" =&gt; \"Data not inserted\"]);\r\n        }\r\n\r\n    }\r\n\r\n}\r\n\r\n$dashboardmodel = new DashboardModel();\r\n\r\nspl_autoload_register(function ($className) {\r\n    require_once(\"./\" . $className . \".php\");\r\n});</code></pre>',	'2022-08-06 06:21:40');

DROP TABLE IF EXISTS `users`;
CREATE TABLE `users` (
  `id` int NOT NULL AUTO_INCREMENT,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `name` varchar(55) NOT NULL,
  `role` varchar(55) NOT NULL,
  `status` tinyint NOT NULL,
  `created_at` timestamp NOT NULL ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO `users` (`id`, `email`, `password`, `name`, `role`, `status`, `created_at`) VALUES
(1,	'admin123@gmail.com',	'$2y$10$YtH1Tt5sZ21HEzPkbN/nVutMyO.j1jCl0o/NuW69LDpfbXYeRY4vO',	'Admin',	'admin',	1,	'2022-08-02 14:08:19');

-- 2022-08-06 06:59:16
