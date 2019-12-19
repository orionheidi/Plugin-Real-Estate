<?php
/**
 * Основне поставке Вордпреса.
 *
 * Ова датотека се користи од стране скрипте за прављење wp-config.php током
 * инсталирања. Не морате да користите веб место, само умножите ову датотеку
 * у "wp-config.php" и попуните вредности.
 *
 * Ова датотека садржи следеће поставке:
 * * MySQL подешавања
 * * тајне кључеве
 * * префикс табеле
 * * ABSPATH
 *
 * @link https://codex.wordpress.org/Editing_wp-config.php
 *
 * @package WordPress
 */

// ** MySQL подешавања - Можете добити ове податке од свог домаћина ** //
/** Име базе података за Вордпрес */
define( 'DB_NAME', 'plugin_r_e' );

/** Корисничко име MySQL базе */
define( 'DB_USER', 'root' );

/** Лозинка MySQL базе */
define( 'DB_PASSWORD', '' );

/** MySQL домаћин */
define( 'DB_HOST', 'localhost' );

/** Скуп знакова за коришћење у прављењу табела базе. */
define( 'DB_CHARSET', 'utf8mb4' );

/** The Database Collate type. Не мењајте ово ако сте у сумњи. */
define( 'DB_COLLATE', '' );

/**#@+
 * Јединствени кључеви за аутентификацију.
 *
 * Промените ово у различите јединствене изразе!
 * Можете направити ово користећи {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org услугу тајних кључева}
 * Ово можете променити у сваком тренутку да бисте поништили све постојеће колачиће.
 * Ово ће натерати кориснике да се поново пријаве.
 *
 * @since 2.6.0
 */
define( 'AUTH_KEY',         '6dUQW89y0z<AlG=vyyzz4` )KA4aAojSM+`o}]%H<(8_#(T{d$zVmZ@Rx.fxtN-5' );
define( 'SECURE_AUTH_KEY',  'H<;PBVX;a##`>LQtJ7TKz9(aLE57?!$N<(u,B]mx%{) 7*#$=vVA<L:awM#]bQmm' );
define( 'LOGGED_IN_KEY',    'xly{B?5=x7]lc9n~ 26&s}R=$5qUpLng jAbA^hEe0~uAL9;ftA]+ZI>P*.5pFNX' );
define( 'NONCE_KEY',        's~!MPe&34R,.XGt;@F`H4TaA/@r{z^+Ov#1c9GuV2RT~sgbCPgMk2yB#@Pu!yxZ>' );
define( 'AUTH_SALT',        'a?!#S+_;}E@F|H3kfz$fn)M{7rQ`//0v_n?SM>H8<h2X#QfOF(od|mX- s!h2N1 ' );
define( 'SECURE_AUTH_SALT', 'pQV%$zs|X~YV{;[rS4EOFyMPo{k3Qk4yqFi?m9xZ^[lk~ae4+jmx4joHOIAub!x9' );
define( 'LOGGED_IN_SALT',   's00=1.RPi$y#|&`,~5<sCb5<;=pZ<&k7KB{4?zcft!!Rl?ew$;.WkoW{;d0.JX&;' );
define( 'NONCE_SALT',       'KuMcS@3c~+<fp]XETk8!#.[&wIgsQzA&U`O*q/h#vCAoz*3L+) Q)a1Um3cfXR_$' );

/**#@-*/

/**
 * Префикс табеле Вордпресове базе података.
 *
 * Можете имати више инсталација Вордпреса у једној бази уколико
 * свакој дате јединствени префикс. Само бројеви, слова и доње цртице!
 */
$table_prefix = 'wp_';

/**
 * За градитеље: исправљање грешака у Вордпресу ("WordPress debugging mode").
 *
 * Промените ово у true да бисте омогућили приказ напомена током градње.
 * Веома се препоручује да градитељи тема и додатака користе WP_DEBUG
 * у својим градитељским окружењима.
 *
 * За више података о осталим константама које могу да се
 * користе током отклањања грешака, посетите Документацију.
 *
 * @link https://codex.wordpress.org/Debugging_in_WordPress
 */
define( 'WP_DEBUG', false );

/* То је све, престаните са уређивањем! Срећно објављивање. */

/** Апсолутна путања ка Вордпресовом директоријуму. */
if ( ! defined( 'ABSPATH' ) ) {
	define( 'ABSPATH', dirname( __FILE__ ) . '/' );
}

/** Поставља Вордпресове променљиве и укључене датотеке. */
require_once( ABSPATH . 'wp-settings.php' );
