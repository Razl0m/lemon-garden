<?
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

function route($data, $db)
{
   if ($data['method'] == "GET" && count($data['urlData']) == 3 && $data['urlData'][1] == "worktime" && ctype_digit($data['urlData'][2])) {
      // GET /main/worktime/1
      echo json_encode(getWorkTime($db, $data['urlData'][2]));
   } else {
      \Helpers\throwHttpError('invalid_router', 'router not found');
   }
}

function getWorkTime($db, $restorantId) {
   $workTime = $db->getOne("SELECT work_time FROM restaurants WHERE id = ?i", $restorantId);
   return $workTime;
}