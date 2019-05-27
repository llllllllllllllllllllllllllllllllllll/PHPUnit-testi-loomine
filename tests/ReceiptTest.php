<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
	public function testTotal() {
	    // Loob uue Receipt klassi objekti.
		$Receipt = new Receipt();
        // Käivitab total funktsiooni esemetega, mille kogusumma on 15.
        // Kontrollib, kas funktsioon tagastab summana 15.
		$this->assertEquals(
			15,
			$Receipt->total([0,2,5,8]),
			'When summing the total should equal 15'
		);
	}
}