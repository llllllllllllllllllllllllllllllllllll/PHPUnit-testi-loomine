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
        $coupon = null;
        // Käivitab $input muutujas olevate esemetega total funktsiooni.
        // Kupongi väärtus on null; selle toimivust ei kontrollita.
        $output = $this->Receipt->total($input, $coupon);
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

    public function testTotalAndCoupon() {
        // Kontrollib total funktsiooni toimivust, kasutades kupongi lisamise võimalust.
        $input = [0,2,5,8];
        $coupon = 0.20;
        $output = $this->Receipt->total($input, $coupon);
        // Kasutatud esemete summa on 15, mida andtud kupong vähendab 20% võrra - seega oodatav tulemus on 12.
        $this->assertEquals(
            12,
            $output,
            'When summing the total should equal 12'
        );
    }

    public function testTax() {
        // Testib Receipt klassi loodud tax funktsiooni tööd.
        // Funktsioon peaks tagastama koguse ja maksu korrutise.
        $inputAmount = 10.00;
        $taxInput = 0.10;
        $output = $this->Receipt->tax($inputAmount, $taxInput);
        $this->assertEquals(
            1.00,
            $output,
            'The tax calculation should equal 1.00'
        );
    }
}