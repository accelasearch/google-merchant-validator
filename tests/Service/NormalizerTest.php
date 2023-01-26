<?php
declare(strict_types=1);
use \RuntimeException;
use \PHPUnit\Framework\TestCase;
use \AccelaSearch\GoogleMerchantValidator\Service\Normalizer;

final class NormalizerTest extends TestCase {
    public function testFromDefault() {
        $normalizer = Normalizer::fromDefault();
        $expected = new Normalizer();
        $this->assertEquals($expected, $normalizer);
    }
}