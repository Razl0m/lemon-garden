<?
session_start();
include_once "common/connection.php";

if (isset($_POST["login"]) && isset($_POST["password"])) {
	$query = $db->getRow("SELECT * FROM users WHERE login=?s", $_POST["login"]);
	if (password_verify($_POST["password"], $query["password"])) {
		if ($query["role"] == "hostess") {
			$_SESSION["role"] = 1;
			header("Location: /hostess.php");
		} else if ($query["role"] == "manager") {
			$_SESSION["role"] = 2;
			header("Location: /manager.php");
		} else if ($query["role"] == "director") {
			$_SESSION["role"] = 3;
			header("Location: /manager.php");
		}
	} else {
		$error = true;
	}
}
$error = isset($error) ?? false;
?>

<!DOCTYPE html>
<html lang="ru">

<head>
	<title>Авторизация</title>
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
	<div class="wrapper">
		<main class="page page_auth">
			<section class="page__auth auth">
				<div class="auth__body">
					<h1 class="auth__title">Авторизация</h1>
					<form class="auth__form form" method="post" action="auth.php">
						<div class="form__line">
							<input class="form__input" type="text" placeholder="Логин" name="login">
						</div>
						<div class="form__line">
							<input class="form__input" type="password" placeholder="Пароль" name="password">
						</div>
						<?
						if ($error) {
							echo '<p class="form__error">Не верный логин или пароль</p>';
						}
						?>
						<button class="form__submit" type="submit">Войти</button>
					</form>
				</div>
			</section>
		</main>
	</div>
</body>
<script src="js/app.min.js?_v=20230525130846"></script>

</html>