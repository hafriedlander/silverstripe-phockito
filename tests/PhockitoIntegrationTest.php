<?php

class PhockitoIntegrationTest extends SapphireTest {

	function setUpOnce() {
		Phockito::include_hamcrest(true);
	}

	function testUpdater() {
		$mock = Phockito::mock('ArrayList');

		$this->assertContains(get_class($mock), ClassInfo::allClasses());
		$this->assertContains(get_class($mock), ClassInfo::subclassesFor('ViewableData'));
		$this->assertContains(get_class($mock), ClassInfo::implementorsOf('SS_List'));

		$mock = Phockito::mock('SS_List');

		$this->assertContains(get_class($mock), ClassInfo::allClasses());
		$this->assertContains(get_class($mock), ClassInfo::implementorsOf('SS_List'));
	}

	function testPhockitoIntegration() {
		$mock = Phockito::mock('ViewableData');

		Phockito::when($mock)->getField(stringValue())->return('Foo');

		$this->assertEquals($mock->getField(1), null);
		$this->assertEquals($mock->getField('Bar'), 'Foo');

		Phockito::verify($mock)->getField(integerValue());
	}

}
