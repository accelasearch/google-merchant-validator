<?php
declare(strict_types=1);
use \PHPUnit\Framework\TestCase;
use \AccelaSearch\GoogleMerchantValidator\ItemReport;

final class ItemReportTest extends TestCase {
    public function testFromIdentifier() {
        $report = ItemReport::fromIdentifier('id');
        $expected = new ItemReport('id', []);
        $this->assertEquals($expected, $report);
    }

    public function testIsValidTrue() {
        $report = new ItemReport('id', []);
        $this->assertTrue($report->isValid());
    }

    public function testIsValidFalse() {
        $report = new ItemReport('id', ['error']);
        $this->assertFalse($report->isValid());
    }

    public function testGetIdentifier() {
        $report = new ItemReport('id', ['error']);
        $this->assertEquals('id', $report->getIdentifier());
    }

    public function testGetErrorsAsArray() {
        $report = new ItemReport('id', ['error']);
        $this->assertEquals(['error'], $report->getErrorsAsArray());
    }

    public function testAddError() {
        $report = new ItemReport('id', ['error']);
        $report->addError('error2');
        $this->assertEquals(['error', 'error2'], $report->getErrorsAsArray());
    }

    public function testClearErrors() {
        $report = new ItemReport('id', ['error']);
        $report->clearErrors();
        $this->assertEquals([], $report->getErrorsAsArray());
    }
}