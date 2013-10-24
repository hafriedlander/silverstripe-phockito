<?php

class PhockitoClassManifestUpdater extends SS_ClassManifest {
	function __construct($manifest) {
		foreach(array('classes', 'descendants', 'interfaces', 'implementors', 'configs', 'configDirs') as $prop) {
			if(property_exists($manifest, $prop)) $this->$prop = $manifest->$prop;
		}
	}

	function addDouble($double, $doubled, $isInterface = false) {
		// Arguments from Phockito might be absolute namespaced, but ClassManifest assumes relative-from-root,
		// so strip off that first '\' if it exists
		$double = ltrim($double, '\\');
		$doubled = ltrim($doubled, '\\');

		// Get the lower case versions, as the keys in the arrays are all-lower-case for matching
		$lDouble = strtolower($double);
		$lDoubled = strtolower($doubled);

		// Register in classes
		$this->classes[$lDouble] = true;

		if ($isInterface) {
			// Register in implementors
			if (!isset($this->implementors[$lDoubled])) $this->implementors[$lDoubled] = array();
			$this->implementors[$lDoubled][] = $double;
		}
		else {
			// Register in descendants
			foreach ($this->descendants as $parent => $descendants) {
				$lDescendants = array_map('strtolower', $descendants);

				if (in_array($lDoubled, $lDescendants)) {
					$this->descendants[$parent][] = $double;
				}
			}

			// Register in implementors
			foreach ($this->implementors as $interface => $implementors) {
				$lImplementors = array_map('strtolower', $implementors);

				if (in_array($lDoubled, $lImplementors)) {
					$this->implementors[$interface][] = $double;
				}
			}
		}
	}

	/**
	 * The callback that Phockito will call every time there's a new double created
	 *
	 * @param string $double - The class name of the new double
	 * @param string $of - The class new of the doubled class or interface
	 * @param bool $isDoubleOfInterface - True if $of is an interface, False if it's a class
	 */
	static function register_double($double, $of, $isDoubleOfInterface = false) {
		$manifest = SS_ClassLoader::instance()->getManifest();

		if (!($manifest instanceof PhockitoClassManifestUpdater)) {
			$manifest = new PhockitoClassManifestUpdater($manifest);
			SS_ClassLoader::instance()->pushManifest($manifest, true);
		}

		$manifest->addDouble($double, $of, $isDoubleOfInterface);
	}
}

require_once(BASE_PATH . '/vendor/hafriedlander/phockito/Phockito.php');
Phockito::$type_registrar = 'PhockitoClassManifestUpdater';