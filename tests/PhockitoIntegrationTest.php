<?php

class PhockitoIntegrationTest extends SapphireTest {

	function testPhockitoIntegration() {
		$mock = Phockito::mock('ViewableData');

		Phockito::when($mock)->getField(stringValue())->return('Foo');

		$this->assertEquals($mock->getField(1), null);
		$this->assertEquals($mock->getField('Bar'), 'Foo');

		Phockito::verify($mock)->getField(integerValue());
	}

}
