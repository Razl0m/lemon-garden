<?
session_start();
if (!isset($_SESSION['token'])) {
	$random_bytes = random_bytes(5); // генерируем 5 случайных байт
	$random_string = base64_encode($random_bytes); // преобразуем в формат base64
	$random_string = substr($random_string, 0, 10); // извлекаем первые 10 символов
	$_SESSION['token'] = $random_string; // сохраняем в session
}
require_once $_SERVER['DOCUMENT_ROOT'] . '/vendor/autoload.php';

use Symfony\Component\Yaml\Yaml;

function route($data, $db)
{
   if ($data['method'] == "GET" && count($data['urlData']) == 3 && $data['urlData'][1] == "worktime" && ctype_digit($data['urlData'][2])) {
      // GET /main/worktime/1
      echo json_encode(getWorkTime($db, $data['urlData'][2]));
   } else if ($data['method'] == "GET" && count($data['urlData']) == 3 && $data['urlData'][1] == "floorplan" && ctype_digit($data['urlData'][2])) {
      // GET /main/floorplan/1
      echo json_encode(getFloorPlan($db, $data['urlData'][2]));
   } else if ($data['method'] == "GET" && count($data['urlData']) == 3 && $data['urlData'][1] == "tables" && ctype_digit($data['urlData'][2])) {
      // GET /main/tables/1
      echo json_encode(getTables($db, $data['urlData'][2]));
   } else if ($data['method'] == "GET" && count($data['urlData']) == 3 && $data['urlData'][1] == "reservations" && ctype_digit($data['urlData'][2])) {
      // GET /main/reservations/1
      echo json_encode(getReservations($db, $data['urlData'][2]));
   } else if ($data['method'] == "POST" && count($data['urlData']) == 2 && $data['urlData'][1] == "reservation") {
      // POST /main/reservation
      echo json_encode(addReservation($db, $data['formData']));
   } else if ($data['method'] == "POST" && count($data['urlData']) == 3 && $data['urlData'][1] == "reservation" && $data['urlData'][2] == "open") {
      // POST /main/reservation/open
      echo json_encode(addAndOpenReservation($db, $data['formData']));
   } else if ($data['method'] == "POST" && count($data['urlData']) == 2 && $data['urlData'][1] == "changereservation") {
      // POST /main/changereservation
      echo json_encode(changeReservation($db, $data['formData']));
   } else if ($data['method'] == "GET" && count($data['urlData']) == 2 && $data['urlData'][1] == "tableplan") {
      // POST /main/tableplan
      echo json_encode(getTablePlan($db, $data['formData']));
   } else if ($data['method'] == "POST" && count($data['urlData']) == 2 && $data['urlData'][1] == "updatetableplab") {
      // POST /main/updatetableplab
      echo json_encode(updateTablePlan($db, $data['formData']));
   } else {
      \Helpers\throwHttpError('invalid_router', 'router not found');
   }
}

function getWorkTime($db, $restorantId)
{
   $workTime = $db->getOne("SELECT work_time FROM restaurants WHERE id = ?i", $restorantId);
   return $workTime;
}

function getFloorPlan($db, $restorantId)
{
   $floorPlan = Yaml::parse($db->getOne("SELECT table_plan FROM restaurants WHERE id = ?i", $restorantId));
   return $floorPlan;
}

function getTables($db, $restorantId)
{
   $tables = $db->getAll("SELECT * FROM tables WHERE id_restaurant = ?i", $restorantId);
   return $tables;
}

function getReservations($db)
{
   $reservations = $db->getAll("SELECT reservations.id,`id_table`,`amount_guests`,`comment`,`start_reservation`,`end_reservation`,`type`,`name`,`phone_number` FROM `reservations` INNER JOIN clients on reservations.id_clients = clients.id WHERE `start_reservation` >= CURRENT_DATE() AND `start_reservation` <= DATE_ADD(CURRENT_DATE(), INTERVAL 1 DAY);");
   return $reservations;
}

function addReservation($db, $data)
{
   if (!isset($data["secure"]) || $data["secure"] != $_SESSION["token"]) {
      return false;
   }

   $idClient = $db->getOne("SELECT id FROM clients WHERE phone_number = ?i", $data["phone"]);
   $data["start_reserv"] = new DateTime($data["start_reserv"]);
   $data["start_reserv"] = $data["start_reserv"]->format('Y-m-d H:i:s');
   $data["end_reserv"] = new DateTime($data["end_reserv"]);
   $data["end_reserv"] = $data["end_reserv"]->format('Y-m-d H:i:s');

   function reservationInsert($db, $data, $idClient)
   {
      $db->query("INSERT INTO reservations(id_table, id_clients, amount_guests, comment, start_reservation, end_reservation, type) VALUES (?i, ?i, ?i, ?s, ?s, ?s, ?s)", $data["id_table"], $idClient, $data["amount_guests"], $data["comment"], $data["start_reserv"], $data["end_reserv"], "new");
   }
   function newClientInsert($db, $data)
   {
      $db->query("INSERT INTO clients(name, phone_number) VALUES (?s, ?i)", $data["name"], $data["phone"]);
      return $db->insertId();
   }
   if (!$idClient) {
      $idClient = newClientInsert($db, $data);
   }
   reservationInsert($db, $data, $idClient);
   return $data;
}

function addAndOpenReservation($db, $data)
{
   $idClient = $db->getOne("SELECT id FROM clients WHERE phone_number = ?i", $data["phone"]);
   $data["start_reserv"] = new DateTime($data["start_reserv"]);
   $data["start_reserv"] = $data["start_reserv"]->format('Y-m-d H:i:s');
   $data["end_reserv"] = new DateTime($data["end_reserv"]);
   $data["end_reserv"] = $data["end_reserv"]->format('Y-m-d H:i:s');

   function reservationInsert2($db, $data, $idClient)
   {
      $db->query("INSERT INTO reservations(id_table, id_clients, amount_guests, comment, start_reservation, end_reservation, type) VALUES (?i, ?i, ?i, ?s, ?s, ?s, ?s)", $data["id_table"], $idClient, $data["amount_guests"], $data["comment"], $data["start_reserv"], $data["end_reserv"], "come");
   }
   function newClientInsert2($db, $data)
   {
      $db->query("INSERT INTO clients(name, phone_number) VALUES (?s, ?i)", $data["name"], $data["phone"]);
      return $db->insertId();
   }
   if (!$idClient) {
      $idClient = newClientInsert2($db, $data);
   }
   reservationInsert2($db, $data, $idClient);
   return $data;
}

function changeReservation($db, $data)
{
   $query = $db->query("UPDATE reservations SET type=?s WHERE id = ?i", $data["type"], $data["id"]);
   return $data;
}

function getTablePlan($db)
{
   $query = $db->getOne("SELECT table_plan FROM restaurants WHERE id = ?i", 1);
   return $query;
}

function updateTablePlan($db, $data)
{
   $query = $db->query("UPDATE restaurants SET table_plan=?s WHERE id = ?i", $data["plan"], 1);
   return $data;
}