<?php

function ss_phockito_autoload($className) {
	if ($className == 'Phockito') {
		$base = dirname(__FILE__);

		// Include base phockito
		require_once($base . '/thirdparty/phockito/Phockito.php');
		// Include silverstripe support
		require_once($base . '/thirdparty/phockito/PhockitoSilverStripe.php');
		// Include the Hamcrest matchers
		Phockito::include_hamcrest(true);
	}
}

spl_autoload_register('ss_phockito_autoload');
