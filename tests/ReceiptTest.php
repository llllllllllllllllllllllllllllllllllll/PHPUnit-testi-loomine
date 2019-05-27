<?php
namespace TDD\Test;
require dirname(dirname(__FILE__)) . DIRECTORY_SEPARATOR . 'vendor' . DIRECTORY_SEPARATOR .'autoload.php';

use PHPUnit\Framework\TestCase;
use TDD\Receipt;

class ReceiptTest extends TestCase {
    // Loob teste alustades ja eemaldab teste lõpetades Receipt objekti.
    // Nii ei pea iga funktsiooni sees seda uuesti looma
    public function setUp() {
        $this->Receipt = new Receipt();
    }

    public function tearDown() {
        unset($this->Receipt);
    }
    public function testTotal() {
        $input = [0,2,5,8];
        // Käivitab $input muutujas olevate esemetega total funktsiooni.
        $output = $this->Receipt->total($input);
        // kontrollib, et funktsioon tagastaks esemete summa.
        $this->assertEquals(
            // Oodatav tulemus
            15,
            // Reaalne funktsioonist tagastatud tulemus.
            $output,
            // Errorisõnum ebaõnnestunud testi puhul
            'When summing the total should equal 15'
        );
    }
}