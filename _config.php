<?php

if(class_exists('SS_ClassManifest')) {
	require_once(dirname(__FILE__).'/code/PhockitoClassManifestUpdater.php');
}
else {
	require_once(dirname(__FILE__).'/code/PhockitoClassGlobalUpdater.php');
}
