<?php

class AwesomePluginActivate {
	public static function activate() {
		flush_rewrite_rules();
	}

}