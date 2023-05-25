<?
session_start();
include_once "common/connection.php";

if (!isset($_SESSION["role"])) {
	$_SESSION["role"] = 0;
	header("Location: /index.php");
} else if ($_SESSION["role"] == 0) {
	header("Location: /index.php");
} else if ($_SESSION["role"] == 1) {
	header("Location: /hostess.php");
}

$openUser = "";
$floorPlanDnone = "";
$userEditDnone = "d-none";

if (isset($_GET["id"]) && ctype_digit($_GET["id"])) {
	$openUser = $_GET["id"];
	$floorPlanDnone = "d-none";
	$userEditDnone = "";
}
if (isset($_POST["id"]) && isset($_POST["login"]) && isset($_POST["name"]) && isset($_POST["password"]) && $_POST["password"] != "" && isset($_POST["role"])) {
	$db->query("UPDATE users SET login=?s, password=?s, name=?s, role=?s WHERE id =?i", $_POST["login"], password_hash($_POST["password"], PASSWORD_DEFAULT), $_POST["name"], $_POST["role"], $_POST["id"]);
} else if (isset($_POST["id"]) && isset($_POST["login"]) && isset($_POST["name"]) && isset($_POST["role"])) {
	$db->query("UPDATE users SET login=?s, name=?s, role=?s WHERE id =?i", $_POST["login"], $_POST["name"], $_POST["role"], $_POST["id"]);
}
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<title>Главная</title>
	<meta charset="UTF-8">
	<meta name="format-detection" content="telephone=no">
	<style>
		body {
			opacity: 0;
		}
	</style>
	<link rel="stylesheet" href="css/style.min.css?_v=20230525130846">
	<link rel="shortcut icon" href="favicon.ico">
	<meta name="theme-color" content="#1F1F1F">
	<meta name="robots" content="noindex, nofollow">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
	<div class="wrapper wrapper_manager">
		<header class="wrapper-manager__header">
			<div class="header__menu menu">
				<button type="button" class="menu__icon icon-menu"><span></span></button>
			</div>
		</header>
		<main class="main-manager">
			<section class="main-manager__left">
				<div class="main-manager__top">
					<button class="main-manager__plan">План зала</button>
					<a href="/exit.php" class="main-manager__exit">Выйти</a>
				</div>
				<div class="main-manager__bottom">
					<h2 class="main-manager__title">Список аккаунтов</h2>
					<ul class="main-manager__list">
						<?
						$openClass = "";
						$users = $db->getAll("SELECT * FROM USERS");
						foreach ($users as $user) {
							if (($_SESSION["role"] == 3 && $user["role"] != "director") || ($_SESSION["role"] == 2 && $user["role"] != "director" && $user["role"] != "manager")) {
								if ($user["id"] == $openUser) {
									$openClass = "main-manager__item_open";
								}
								echo '<li class="main-manager__item '. $openClass .'">
								<a href="manager.php?id='. $user["id"] .'">
									<p class="main-manager__account-title">' . $user["name"] . ', ' . $user["role"] . '</p>
									<p class="main-manager__email">' . $user["login"] . '</p>
								</a>
								</li>';
								$openClass = "";
							}
						}
						dump($users);
						?>
					</ul>
				</div>
			</section>
			<section class="main-manager__right">
				<?
				if ($openUser) {
					$userInfo = $db->getRow("SELECT * FROM users WHERE id=?i", $openUser);
				}
				?>
				<form class="main-manager__form form-main-manager <?=$userEditDnone ?>" method="POST" action="manager.php">
					<h2 class="form-main-manager__title">Редактирвоание аккаунта</h2>
					<div class="form-main-manager__line">
						<input class="form-main-manager__input" type="text" name="name" placeholder="Имя" value="<?=$userInfo["name"]?>">
					</div>
					<div class="form-main-manager__line">
						<input class="form-main-manager__input" type="text" name="login" placeholder="Логин" value="<?=$userInfo["login"]?>">
					</div>
					<div class="form-main-manager__line">
						<input class="form-main-manager__input" type="password" name="password" placeholder="Пароль" value="">
					</div>
						<input type="text" name="id" hidden value="<?=$userInfo["id"]?>">
					<div class="form-main-manager__line">
						<select name="role" class="form-main-manager__select" placeholder="Роль">
							<?
							if ($_SESSION["role"] == 3) {
								echo '<option value="manager">Менеджер</option>';
							}
							?>
							<option <? if($userInfo["role"] == "hostess") echo "selected" ?> value="hostess">Хост</option>
						</select>
					</div>
					<button type="submit" class="form-main-manager__submit">Изменить</button>
				</form>
				<form class="main-manager__editor editor-main-manager <?=$floorPlanDnone ?>">
					<h2 class="editor-main-manager__title">Редактирование плана зала</h2>
					<div class="editor-main-manager__line">
						<div class="editor-main-manager__editor"></div>
					</div>
					<button class="editor-main-manager__submit" id="savePlan" type="submit">Сохранить</button>
				</form>
			</section>
		</main>
	</div>
	<script src="js/app.min.js?_v=20230525130846"></script>
</body>

</html>