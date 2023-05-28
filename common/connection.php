<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable($_SERVER['DOCUMENT_ROOT']);
$dotenv->load();

$opts = array(
   'host'	 => $_ENV['DBhost'],
   'user'	 => $_ENV['DBuser'],
   'pass'    => $_ENV['DBpass'],
   'db'      => $_ENV['DBname'],
);

try {
   $db = new SafeMySQL($opts);
} catch (\Throwable $th) {
   echo $th;
}