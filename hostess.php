<?
session_start();

if (!isset($_SESSION["role"])) {
	$_SESSION["role"] = 0;
	header("Location: /index.php");
} else if ($_SESSION["role"] == 0) {
	header("Location: /index.php");
}
if (!isset($_SESSION['token'])) {
	$random_bytes = random_bytes(5); // генерируем 5 случайных байт
	$random_string = base64_encode($random_bytes); // преобразуем в формат base64
	$random_string = substr($random_string, 0, 10); // извлекаем первые 10 символов
	$_SESSION['token'] = $random_string; // сохраняем в session
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
	<div class="wrapper wrapper_hostess">
		<section class="page-1">
			<div class="page-1__body">
				<div class="page-1__top top-page-1">
					<a href="/exit.php" class="top-page-1__exit">Выход</a>
				</div>
				<div class="page-1__middle list-page-1">
					<div class="open-table d-none">
						<button class="open-table__exit">Выбрать другую бронь</button>
						<div class="li-list-page-1">
							<div class="li-list-page-1__top">
								<p class="li-list-page-1__number">№<span>105</span></p>
								<p class="li-list-page-1__table">Стол №<span>2</span></p>
							</div>
							<div class="li-list-page-1__middle">
								<p class="li-list-page-1__name-amount"><span class="name">Павел</span>, <span class="amount">2</span> чел.</p>
								<p class="li-list-page-1__time"></p>
							</div>
							<div class="li-list-page-1__bottom">
								<p class="li-list-page-1__status" style="margin-bottom: 40px;">Открыто</p>
								<p class="li-list-page-1__Phone-number"></p>
							</div>
						</div>
						<p class="open-table__desc">Комментарий: <span></span></p>
						<div class="open-table__bottom">
							<button class="open-table__button open-table__button_close">
								Закрыть
							</button>
							<button class="open-table__button open-table__button_waiting">
								Ожидать
							</button>
							<button class="open-table__button open-table__button_open">
								Открыть
							</button>
						</div>
					</div>
					<ul class="list-page-1__ul">
					</ul>
				</div>
			</div>
		</section>
		<section class="right-block">
			<main class="page__hostess">
				<section class="page__2">
					<header class="header">
						<div class="header__container">
							<a href="#" class="header__logo">
								<img src="img/icons/logo.svg" alt="Логотип - Лиммонный сад">
							</a>
							<div class="header__buttons data-right">
								<input class="header__radio" type="radio" name="viewOption" id="viewList"></input>
								<label class="header__label" for="viewList">Список</label>
								<input class="header__radio" type="radio" name="viewOption" id="viewScheme" checked></input>
								<label class="header__label" for="viewScheme" id="buttonScheme">Схема</label>
							</div>
							<div class="header__menu menu">
								<button type="button" class="menu__icon icon-menu"><span></span></button>
							</div>
						</div>
					</header>
					<div class="hostess-wrapper2">
						<section class="page__scheme scheme">
							<div class="scheme__body">
							</div>
							<div class="scheme__control control-scheme">
								<button class="control-scheme__plus"></button>
								<button class="control-scheme__minus"></button>
							</div>
						</section>
						<section class="page__list list">
							<div class="list__container">
								<ul class="list__body">
								</ul>
							</div>
						</section>
					</div>
				</section>
			</main>
			<footer class="footer footer_hostess">
				<div class="footer__left"></div>
				<div class="footer__right">
					<div class="footer__top">
						<p class="footer__time">
							C <span></span>
						</p>
						<div class="footer__point">
							<img src="img/icons/point.svg" alt="point">
						</div>
						<input class="footer__date" type="text" id="calendar">
					</div>
					<div class="footer__body time">
						<div class="time__slider swiper">
							<div class="time__wrapper swiper-wrapper">
								
							</div>
						</div>
					</div>
				</div>
			</footer>
		</section>
	</div>
	<div id="popup" aria-hidden="true" class="popup" data-id="0">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Стол №<span>1</span></p>
					<div class="item-list__status item-list__status_free popup__status"></div>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="item-list__number-of-seats">
					<span class="item-list__number popup__number-seats">4</span>
					<img src="img/icons/users.svg" alt="users" class="item-list__icon-seats">
				</div>
				<div class="popup__text">
					Описание: Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis risus massa, commodo eu dui eu, condimentum euismod massa. Fusce sit amet sem elementum, hendrerit eros sed, dictum est. Donec sed efficitur nisi, eu euismod ligula.
				</div>
				<button class="popup__book-table" data-popup="#popup2">Забронировать</button>
			</div>
		</div>
	</div>
	<div id="popup2" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Бронирование стола</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<form class="popup__form form-popup" method="POST">
					<div class="form-popup__line">
						<input placeholder="Ваше имя*" required name="firstName" autocomplete="given-name" class="form-popup__input" type="text">
						<select name="guests" required class="form-popup__select">
						</select>
					</div>
					<div class="form-popup__line">
						<input placeholder="Телефон*" required type="phone" autocomplete="tel" name="phone" class="form-popup__input">
					</div>
					<div class="form-popup__line">
						<input placeholder="Комментарий" type="text" name="comment" class="form-popup__input">
					</div>
					<p class="form-popup2__busy"></p>
				</form>
				<button class="popup__book-table">Далее</button>
			</div>
		</div>
	</div>
	<div id="popup3" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Дата и время</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="popup__form form-popup2">
					<div class="form-popup2__line">
						<label for="calendar2" class="form-popup2__label">Дата бронирования</label>
						<input name="date-table" class="form-popup2__input" type="text" id="calendar2">
					</div>
					<div class="form-popup2__line">
						<p class="form-popup2__label">Время бронирования</p>
						<div class="form-popup2__time">
							<label for="time-from" class="form-popup2__name-input">С</label>
							<input id="time-from" name="time-from" class="form-popup2__time-input" type="time">
						</div>
						<div class="form-popup2__time">
							<label for="time-to" class="form-popup2__name-input">До</label>
							<input id="time-to" name="time-to" class="form-popup2__time-input" type="time">
						</div>
						<input class="book__secure" hidden type="text" value="<?=$_SESSION['token']?>" required>
					</div>
					<p class="form-popup2__busy"></p>
				</div>
				<button class="popup__book-table">Забронировать</button>
			</div>
		</div>
	</div>
	<div id="popup4" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title popup-name">Спасибо, <span>имяпользователя</span>!</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="item-list__number-of-seats">
					<div class="item-list__status item-list__status_free">Стол успешно забронирован</div>
				</div>
				<div class="popup__text popup-adress">
					Адрес: г. Москва, улица Лимонная, дом 7
				</div>
				<div class="popup__text popup-date">
					Дата: <span></span>
				</div>
				<div class="popup__text popup-time">
					Время: <span></span>
				</div>
				<div class="popup__text popup-number-table">
					Стол: №<span></span>
				</div>
				<div class="popup__text popup-name2">
					Имя: <span></span>
				</div>
				<div class="popup__text popup-guests">
					Гостей: <span></span> чел.
				</div>
				<div class="popup__text popup-phone-number">
					Тел: <span></span>
				</div>
				<div class="popup__text popup-comment">
					Комментарий: <span></span>
				</div>
			</div>
		</div>
	</div>
	<div id="popup5" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Стол №<span>1</span></p>
					<div class="item-list__status item-list__status_free popup__status"></div>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="item-list__number-of-seats">
					<span class="item-list__number popup__number-seats">4</span>
					<img src="img/icons/users.svg" alt="users" class="item-list__icon-seats">
				</div>
				<button class="popup__book-table" data-popup="#popup2">Забронировать</button>
				<button class="popup__book-table to-popup-6" style="margin-top: 10px;" data-popup="#popup6">Открыть (сели гости)</button>
			</div>
		</div>
	</div>
	<div id="popup6" aria-hidden="true" class="popup to-popup-7">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Стол №1</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<form class="popup__form form-popup" method="POST">
					<div class="form-popup__line">
						<input placeholder="Имя клиента" name="firstName" value="Открыть" autocomplete="given-name" class="form-popup__input" type="text">
						<select name="guests" required class="form-popup__select">
						</select>
					</div>
					<div class="form-popup__line">
						<input placeholder="Телефон" value="80000000000" type="phone" autocomplete="tel" name="phone" class="form-popup__input">
					</div>
					<div class="form-popup__line">
						<input placeholder="Комментарий" type="text" name="comment" class="form-popup__input">
					</div>
					<p class="form-popup2__busy"></p>
				</form>
				<button class="popup__book-table">Далее</button>
			</div>
		</div>
	</div>
	<div id="popup7" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Дата и время</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="popup__form form-popup2">
					<div class="form-popup2__line">
						<label for="calendar2" class="form-popup2__label">Дата бронирования</label>
						<input name="date-table" class="form-popup2__input" type="text" id="calendar2" disabled>
					</div>
					<div class="form-popup2__line">
						<!-- <p class="form-popup2__label">Время бронирования <button style="text-decoration: underline;">По факту</button></p> -->
						<div class="form-popup2__time">
							<label for="time-from" class="form-popup2__name-input">С</label>
							<input id="time-from2" name="time-from" class="form-popup2__time-input" type="time">
						</div>
						<div class="form-popup2__time">
							<label for="time-to" class="form-popup2__name-input">До</label>
							<input id="time-to2" name="time-to" class="form-popup2__time-input" type="time">
							<input class="book__secure" hidden type="text" value="<?=$_SESSION['token']?>" required>
						</div>
						<p class="form-popup2__busy"></p>
					</div>
				</div>
				<button class="popup__book-table">Открыть</button>
			</div>
		</div>
	</div>
	</div>
	<div id="popup8" aria-hidden="true" class="popup">
		<div class="popup__wrapper">
			<div class="popup__content">
				<div class="popup__top">
					<p class="popup__title">Стол открыт</p>
					<button data-close type="button" class="popup__close"></button>
				</div>
				<div class="item-list__number-of-seats">
				</div>
				<div class="popup__text popup-adress">
					Адрес: г. Москва, улица Лимонная, дом 7
				</div>
				<div class="popup__text popup-date">
					Дата: <span></span>
				</div>
				<div class="popup__text popup-time">
					Время: <span></span>
				</div>
				<div class="popup__text popup-number-table">
					Стол: №<span></span>
				</div>
				<div class="popup__text popup-name2">
					Имя: <span></span>
				</div>
				<div class="popup__text popup-guests">
					Гостей: <span></span> чел.
				</div>
				<div class="popup__text popup-phone-number">
					Тел: <span></span>
				</div>
				<div class="popup__text popup-comment">
					Комментарий: <span></span>
				</div>
			</div>
		</div>
	</div>
	<script src="js/app.min.js?_v=20230525130846"></script>
</body>

</html>