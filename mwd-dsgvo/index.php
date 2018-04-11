<?php

/**
 * Plugin Name: MWD DSGVO
 * Version: 1.0.0
 * Plugin URI: 
 * Description: Plugin zum Verwalten der Datenschutzrichtlinien
 * Author: medani web &amp; design
 * Author URI: https://medani.at
 * Text Domain: mwd-dsgvo
 */

include_once( 'inc/update-settings.php' );
include_once( 'inc/helper.php' );
include_once( 'inc/functions.php' );
include_once( 'inc/classes/mwd-dsgvo.php' );
include_once( 'inc/shortcodes.php' );
include_once( 'inc/buttons.php' );


register_activation_hook( __FILE__, 'mwd_dsgvo_on_activate' );

new MWD_DSGVO();


function mwd_dsgvo_on_activate() {

	mwd_dsgvo_create_tables();
	mwd_dsgvo_seed_tables();
}

function mwd_dsgvo_create_tables() {

	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$sections_table_name = $wpdb->prefix . 'mwd_dsgvo_sections';
	$temp_sections_table_name = $wpdb->prefix . 'mwd_dsgvo_temp_sections';
	$temp_general_settings_table_name = $wpdb->prefix . 'mwd_dsgvo_temp_general_settings';
	$versions_table_name = $wpdb->prefix . 'mwd_dsgvo_versions';

	$sql = "
		CREATE TABLE $sections_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			slug VARCHAR(30) NOT NULL,
			active boolean NOT NULL DEFAULT 0,
			title VARCHAR(100) NOT NULL,
			displaytitle VARCHAR(100) NOT NULL,
			text TEXT NOT NULL,
			defaulttext TEXT NOT NULL,
			additionaltext TEXT NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;
		CREATE TABLE $temp_sections_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			slug VARCHAR(30) NOT NULL,
			active boolean NOT NULL DEFAULT 0,
			title VARCHAR(100) NOT NULL,
			displaytitle VARCHAR(100) NOT NULL,
			text TEXT NOT NULL,
			defaulttext TEXT NOT NULL,
			additionaltext TEXT NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;
		CREATE TABLE $temp_general_settings_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			keyid VARCHAR(100) NOT NULL,
			value VARCHAR(100) NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;
		CREATE TABLE $versions_table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			created datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			content TEXT NOT NULL,
			userid mediumint(9) NOT NULL,
			username VARCHAR(50) NOT NULL,
			UNIQUE KEY id (id)
		) $charset_collate;
	";

	require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
	dbDelta( $sql );
}

function mwd_dsgvo_seed_tables() {

	global $wpdb;

	$sections = array (
		array (
			'slug'              => 'dsgvo-first-section',
			'active'            => 0,
			'title'             => 'Einführungs-Abschnitt',
			'displayTitle'      => 'Einführungs-Abschnitt',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Einführungs-Abschnitt',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'datenschutz-section',
			'active'            => 0,
			'title'             => 'Datenschutz',
			'displayTitle'      => 'Datenschutz',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Datenschutz',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'responsible-parties-section',
			'active'            => 0,
			'title'             => 'Verantwortliche Gesellschaften',
			'displayTitle'      => 'Verantwortliche Gesellschaften',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für verantwortliche Gesellschaften',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'cookies-section',
			'active'            => 0,
			'title'             => 'Cookies',
			'displayTitle'      => 'Cookies',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Cookies',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'forms-section',
			'active'            => 0,
			'title'             => 'Formulare',
			'displayTitle'      => 'Formulare',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Formulare',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'server-log-files-section',
			'active'            => 0,
			'title'             => 'Server Log Files',
			'displayTitle'      => 'Server Log Files',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Server Log Files',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'google-analytics-section',
			'active'            => 0,
			'title'             => 'Google Analytics',
			'displayTitle'      => 'Google Analytics',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Google Analytics',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'google-adwords-section',
			'active'            => 0,
			'title'             => 'Google Adwords',
			'displayTitle'      => 'Google Adwords',
			'text'              => '',
			'defaultText'       => '
			Diese Webseite nutzt ferner das Google Conversion Tracking, welches von der Google Inc. („Google“), 1600 Amphitheatre 
			Parkway, Mountain View, CA 94043, USA („Google“) betrieben wird. Dabei wird von Google Adwords ein Cookie auf Ihrem 
			Rechner gesetzt, sofern Sie über eine Google-Anzeige auf unsere Webseite gelangt sind. Diese Cookies verlieren nach 30 
			Tagen ihre Gültigkeit und dienen nicht der persönlichen Identifizierung. Besucht der Nutzer bestimmte Seiten der 
			Webseite des Adwords-Kunden und das Cookie ist noch nicht abgelaufen, können Google und der Kunde erkennen, dass 
			der Nutzer auf die Anzeige geklickt hat und zu dieser Seite weitergeleitet wurde. Jeder Adwords-Kunde erhält ein 
			anderes Cookie. Cookies können somit nicht über die Webseiten von Adwords-Kunden nachverfolgt werden. Die Mithilfe 
			des Conversion-Cookies eingeholten Informationen dienen dazu, Conversion-Statistiken für Adwords-Kunden zu erstellen, 
			die sich für Conversion-Tracking entschieden haben. Die Adwords-Kunden erfahren die Gesamtanzahl der Nutzer, die 
			auf ihre Anzeige geklickt haben und zu einer mit einem Conversion-Tracking-Tag versehenen Seite weitergeleitet wurden. 
			Sie erhalten jedoch keine Informationen, mit denen sich Nutzer persönlich identifizieren lassen. Wenn Sie nicht an 
			dem Tracking-Verfahren teilnehmen möchten, können Sie auch das hierfür erforderliche Setzen eines Cookies ablehnen – 
			etwa per Browser-Einstellung, die das automatische Setzen von Cookies generell deaktiviert. Sie können Cookies für 
			Conversion-Tracking auch deaktivieren, indem Sie Ihren Browser so einstellen, dass Cookies von der Domain 
			„www.googleadservices.com“ blockiert werden. Googles Datenschutzbelehrung zum Conversion-Tracking finden Sie hier: 
			http://www.google.com/intl/de/policies/privacy/.<br /><br />
			[link-opt-out-adwords]
			',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'google-remarketing-section',
			'active'            => 0,
			'title'             => 'Google Remarketing',
			'displayTitle'      => 'Google Remarketing',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Google Remarketing',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'facebook-pixel-section',
			'active'            => 0,
			'title'             => 'Facebook Pixel',
			'displayTitle'      => 'Facebook Pixel',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für Facebook Pixel',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'ssl-section',
			'active'            => 0,
			'title'             => 'SSL Verschlüsselung',
			'displayTitle'      => 'SSL Verschlüsselung',
			'text'              => '',
			'defaultText'       => '
			Ihre Bestellungen und Ihre persönlichen Daten wie Ihr Name, Ihre Adresse oder die Angaben zu Ihrer Kreditkarte werden
			durch moderne Sicherheitssysteme geschützt. Die Übertragung dieser Daten erfolgt verschlüsselt und für Außenstehende
			unlesbar unter Verwendung des Secure Socket Layers (SSL) von VeriSign, einem Sicherheitsstandard, der von allen
			üblichen Internet-Browsern unterstützt wird. Sie erkennen den Sicherheitsstatus an der Endung „s“ im ersten Teil
			der Adresse ( „https:“ anstatt „http:“ ). [firmenname] trifft alle notwendigen Vorkehrungen, um Ihre persönlichen
			Daten zu schützen. Dabei können Sie uns aktiv unterstützen, indem Sie niemals Ihr Passwort weitergeben, die
			verschlüsselte Datenübertragung (SSL) auswählen, wann immer wir Ihnen dies anbieten (z.B. im Rahmen des Bestellvorgangs)
			 Wenn Sie Ihren Computer mit anderen teilen, sollten Sie darauf achten, sich nach jeder Sitzung abzumelden.
			 Gemeinsam erreichen wir, dass Ihr Online-Einkauf wirklich sicher ist.
			',
			'additionalText'    => '',
		),
		array (
			'slug'              => 'dsgvo-last-section',
			'active'            => 0,
			'title'             => 'Letzter Abschnitt',
			'displayTitle'      => 'Letzter Abschnitt',
			'text'              => '',
			'defaultText'       => 'Default Text der dsgvo für den letzten Abschnitt',
			'additionalText'    => '',
		),
	);

	foreach ( $sections as $section ) {

		$updateValue = array (
			/* deaktiviert, weil man sonst den vom Redakteur eingetragenen Wert überschreibt*/
			/*'active'         => $section['active'],*/
			/*'title'          => $section['title'],*/
			/*'text'           => $section['text'],*/
			'displaytitle'   => $section['displayTitle'],
			'defaulttext'    => $section['defaultText'],
			'additionaltext' => $section['additionalText'],
		);
		$where = array (
			'slug'  => $section['slug'],
		);
		$insertValue = array(
			'slug'           => $section['slug'],
			'active'         => $section['active'],
			'title'          => $section['title'],
			'displaytitle'   => $section['displayTitle'],
			'text'           => $section['text'],
			'defaulttext'    => $section['defaultText'],
			'additionaltext' => $section['additionalText'],
		);
		$sections_table_name = $wpdb->prefix . 'mwd_dsgvo_sections';
		$slug =  $section['slug'];

		mwd_dsgvo_add_or_update_custom_table_entry(
			$wpdb->prepare("SELECT * FROM {$sections_table_name} WHERE slug = %s", $slug),
			$sections_table_name,
			$updateValue,
			$insertValue,
			$where
		);
	}
}
