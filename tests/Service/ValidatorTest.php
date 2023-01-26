<?php
declare(strict_types=1);
use \PHPUnit\Framework\TestCase;
use \AccelaSearch\ProductMapper\Converter\GoogleShopping\Item as Converter;
use \AccelaSearch\GoogleMerchantValidator\ItemReport;
use \AccelaSearch\GoogleMerchantValidator\Service\Validator;

final class ValidatorTest extends TestCase {
    public function testFromDefault() {
        $validator = Validator::fromDefault();
        $expected = new Validator(Converter::fromDefault());
        $this->assertEquals($expected, $validator);
    }
}