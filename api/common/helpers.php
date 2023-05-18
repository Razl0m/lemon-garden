<?php
namespace Helpers;
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

// Получение данных из тела запроса
function getFormData($method)
{

	// GET или POST: данные возвращаем как есть
	if ($method === 'GET') {
		$data = $_GET;
	} else if ($method === 'POST') {
		$data = $_POST;
	} else {
		// PUT, PATCH или DELETE
		$data = json_decode(file_get_contents('php://input'), true);
	}
	return $data;
}

function getFileData()
{
	return current($_FILES);
}

// Получаем все данные о запросе
function getRequestData()
{
	// Определяем метод запроса
	$method = $_SERVER['REQUEST_METHOD'];

	// Разбираем url
	$url = $_GET['q'] ?? '';
	$url = trim($url, '/');
	$urlData = explode('/', $url);

	return array(
		'method' => $method,
		'formData' => getFormData($method),
		'file' => getFileData(),
		'urlData' => $urlData,
		'router' => $urlData[0]
	);
}

// Проверка роутера на валидность
function isValidRouter($router)
{
	return in_array($router, array(
		'main'
	));
}

// Выводим 400 ошибку http-запроса
function throwHttpError($code, $message)
{
	header('HTTP/1.0 400 Bad Request');
	echo json_encode(array(
		'code' => $code,
		'message' => $message
	));
}