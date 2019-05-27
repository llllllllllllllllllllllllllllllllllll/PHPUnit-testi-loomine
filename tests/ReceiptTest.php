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

    /**
     * @dataProvider provideTotal
     */
    public function testTotal($items, $expected) {
        $coupon = null;
        // Käivitab provideTotal dataprovideri poolt antud esemetega total funktsiooni.
        // Kupongi väärtus on null; selle toimivust ei kontrollita.
        $output = $this->Receipt->total($items, $coupon);
        // kontrollib, et funktsioon tagastaks esemete summa.
        $this->assertEquals(
            // Oodatav tulemus; saadakse dataproviderilt
            $expected,
            // Reaalne funktsioonist tagastatud tulemus.
            $output,
            // Errorisõnum ebaõnnestunud testi puhul
            "When summing the total should equal {$expected}"
        );
    }
    public function provideTotal() {
        // Annab testTotal funktsioonile mitu erinevat
        return [
            [[1,2,5,8], 16],
            [[-1,2,5,8], 14],
            [[1,2,8], 11],
        ];
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

    public function testPostTaxTotal() {
        // Testib isoleeritult lisatava postTaxTotal funktsiooni tööd,
        // kasutades mocki.
        $items = [1,2,5,8];
        $tax = 0.20;
        $coupon = null;
        $Receipt = $this->getMockBuilder('TDD\Receipt')
            ->setMethods(['tax', 'total'])
            ->getMock();
        $Receipt->expects($this->once())
            ->method('total')
            ->with($items, $coupon)
            ->will($this->returnValue(10.00));
        $Receipt->expects($this->once())
            ->method('tax')
            ->with(10.00, $tax)
            ->will($this->returnValue(1.00));
        $result = $Receipt->postTaxTotal([1,2,5,8], 0.20, null);
        $this->assertEquals(11.00, $result);
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