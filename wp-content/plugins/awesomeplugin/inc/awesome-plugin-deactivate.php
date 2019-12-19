<?php

class AwesomePluginDeactivate {
	public static function deactivate() {
		flush_rewrite_rules();
	}

}