<?php namespace CAHNRS\Plugin\News;

class Plugin {
    public static function setup_classes() {

	}


	public static function init() {

		self::setup_classes();

		// Do plugin stuff here

		require_once __DIR__ . '/scripts.php';
		require_once __DIR__ . '/blocks.php';
		require_once __DIR__ . '/functions.php';
        require_once __DIR__ . '/../lib/post-status/post-status.php';
        require_once __DIR__ . '/../lib/cron/archive-cron.php';
	}
}

Plugin::init();
