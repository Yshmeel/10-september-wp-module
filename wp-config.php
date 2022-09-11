<?php
/**
 * Основные параметры WordPress.
 *
 * Скрипт для создания wp-config.php использует этот файл в процессе установки.
 * Необязательно использовать веб-интерфейс, можно скопировать файл в "wp-config.php"
 * и заполнить значения вручную.
 *
 * Этот файл содержит следующие параметры:
 *
 * * Настройки базы данных
 * * Секретные ключи
 * * Префикс таблиц базы данных
 * * ABSPATH
 *
 * @link https://ru.wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */

// ** Параметры базы данных: Эту информацию можно получить у вашего хостинг-провайдера ** //
/** Имя базы данных для WordPress */
define( 'DB_NAME', 'wskaa' );

/** Имя пользователя базы данных */
define( 'DB_USER', 'root' );

/** Пароль к базе данных */
define( 'DB_PASSWORD', '' );

/** Имя сервера базы данных */
define( 'DB_HOST', 'localhost' );

/** Кодировка базы данных для создания таблиц. */
define( 'DB_CHARSET', 'utf8mb4' );

/** Схема сопоставления. Не меняйте, если не уверены. */
define( 'DB_COLLATE', '' );

/**#@+
 * Уникальные ключи и соли для аутентификации.
 *
 * Смените значение каждой константы на уникальную фразу. Можно сгенерировать их с помощью
 * {@link https://api.wordpress.org/secret-key/1.1/salt/ сервиса ключей на WordPress.org}.
 *
 * Можно изменить их, чтобы сделать существующие файлы cookies недействительными.
 * Пользователям потребуется авторизоваться снова.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         'WU=TYdB@KF^cyu<zhN3jM %R=`DzkgupG(8U|)(G=8!=yux}PR1<zTgm{(_t3@n/' );
define( 'SECURE_AUTH_KEY',  '+Fr@-_Iv`<)VkBBeq#D_{=z{z(rF5)~~H/S$RN_9!7q1^nwQ,+g/5n7xBO=Lzn,=' );
define( 'LOGGED_IN_KEY',    '|er=h:N*-jedAv&K^+i#!?8-JF+,:P%`Kp3(4SV^0.qEb1)hz!~AIoc1u J qjSB' );
define( 'NONCE_KEY',        'RSB,fEr`tA~d<<XjE4hw6EdRGMuo>ww7.<Z_=cTw?0+_<{KH#ww1vK9~9D`R6)ED' );
define( 'AUTH_SALT',        'XGd?vev?~da=~7eBKT#]x`yaMS.eg8f}]5GOtj&$DI1eL]iaW^c(xvrm|9I6u5sJ' );
define( 'SECURE_AUTH_SALT', '`*KJEahaxo=HE?&gQ)R>c;:mSE6nDbZxGgZ?MiTXu_6X8~^ z=+38nE0!|-F^}~X' );
define( 'LOGGED_IN_SALT',   '|(M*~FqLnbV6f!]`<bc &B}YBe?a^J%P1C7~fKom!RJG7bjFhc-MTR$ahd`9C<a}' );
define( 'NONCE_SALT',       '-PG,r]?digM(6ALPUp-{gvw*4_b%Ywt#4Yw00nurdYoVKltWCz6nMUQ/tUa45YOa' );

/**#@-*/

/**
 * Префикс таблиц в базе данных WordPress.
 *
 * Можно установить несколько сайтов в одну базу данных, если использовать
 * разные префиксы. Пожалуйста, указывайте только цифры, буквы и знак подчеркивания.
 */
$table_prefix = 'wp_';

/**
 * Для разработчиков: Режим отладки WordPress.
 *
 * Измените это значение на true, чтобы включить отображение уведомлений при разработке.
 * Разработчикам плагинов и тем настоятельно рекомендуется использовать WP_DEBUG
 * в своём рабочем окружении.
 *
 * Информацию о других отладочных константах можно найти в документации.
 *
 * @link https://ru.wordpress.org/support/article/debugging-in-wordpress/
 */
define( 'WP_DEBUG', false );

/* Произвольные значения добавляйте между этой строкой и надписью "дальше не редактируем". */

define('WP_ADMIN_DIR', 'secure');

/* Это всё, дальше не редактируем. Успехов! */

/** Абсолютный путь к директории WordPress. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', __DIR__ . '/' );
}

/** Инициализирует переменные WordPress и подключает файлы. */
require_once ABSPATH . 'wp-settings.php';
