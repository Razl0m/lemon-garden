<?
include_once 'common/helpers.php';
include_once '../common/connection.php';

// Получаем данные из запроса
$data = \Helpers\getRequestData();

$router = $data['router'];

// header("Content-Type: application/json");

// Проверяем роутер на валидность
if (\Helpers\isValidRouter($router)) {
   // Подключаем файл-роутер
   include_once "routers/$router.php";
   // Запускаем главную функцию
   route($data, $db);
} else {
   // Выбрасываем ошибку
   \Helpers\throwHttpError('invalid_router', 'router not found');
}
