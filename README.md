# Phockito integration module for SilverStripe

Phockito generates subclasses of the class under mock or spy. This doesn't work well with SilverStripe, which builds
a manifest of classes and expects them to remain static during execution.

This module provides integration between SilverStripe and Phockito, so that every time you create a mock or
spy with Phockito, it's registered in SilverStripe's ClassManifest.

This all happens automatically, so you don't have to worry about it - just add this module to your composer.json,
then start calling Phocktio::mock or Phockito::spy in your tests.

If you're calling `Phockito::include_hamcrest()` to use Hamcrest matchers like `anything()`,
please remember to limit the inclusion to the test execution by placing it in `setUpOnce()`.
Placing it outside of the class scope and executing the include calls when
then PHP file is first included by PHP can cause clashes with PHPUnit's built-in matchers.
To further avoid clashes, you should also avoid including these matchers
yourself (`PHPUnit\Framework\Assert\Functions.php`).

```php
<?php
class MyTest extends SapphireTest {

	public function setUpOnce() {
		if (class_exists('Phockito')) {
			Phockito::include_hamcrest();
		}

		parent::setUpOnce();
	}

}
```