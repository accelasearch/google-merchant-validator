<?php
/*
 * This file is part of the AccelaSearch/GoogleMerchantValidator package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 */
namespace AccelaSearch\GoogleMerchantValidator\Service;
use \Exception;
use \AccelaSearch\ProductMapper\Converter\GoogleShopping\Item as Converter;
use \AccelaSearch\GoogleMerchantValidator\ItemReport;

/**
 * Validates a Google Merchant products feed
 * 
 * This class follows the Static Factory Method design pattern.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 * @package AccelaSearch\GoogleMerchantValidator
 */
class Validator {
    /**
     * Item converter
     * @var Converter $converter
     */
    private $converter;

    /**
     * Constructor
     * 
     * @param Converter $converter Converter
     */
    public function __construct(Converter $converter) {
        $this->converter = $converter;
    }

    /**
     * Creates a validator from default values
     * 
     * @return self A new validator
     */
    public static function fromDefault(): self {
        return new Validator(Converter::fromDefault());
    }

    /**
     * Returns converter
     * 
     * @return Converter Converter
     */
    public function getConverter(): Converter {
        return $this->converter;
    }

    /**
     * Validates a feed and generates a report for each item
     * 
     * @param string $path Path to XML feed
     * @return ItemReport[] Set of reports
     */
    public function validate(string $path): array {
        $reports = [];
        $fh = fopen($path, 'r');
        while (($row = fgets($fh)) !== false) {
            if (strpos($row, '<item') !== 0) {
                continue;
            }
            $reports[] = $this->analyzeItem($row);
        }
        fclose($fh);
        return $reports;
    }

    /**
     * Analyzes an item and generates a report
     * 
     * @param string $item XML content for the item
     */
    private function analyzeItem(string $item): ItemReport {
        $result = preg_match('/<g:id>(.*)<\/g:id>/', $item, $matches);
        if ($result !== 1) {
            return new ItemReport('unknown', ['Cannot parse data']);
        }
        $identifier = $matches[1];
        $report = ItemReport::fromIdentifier($identifier);
        try {
            $item = str_replace('<item>', '<item xmlns:g="http://base.google.com/ns/1.0" version="2.0">', $item);
            $xml = simplexml_load_string($item);
            if ($xml === false) {
                foreach (libxml_get_errors() as $error) {
                    $report->addError((string) $error);
                }
                return $report;
            }
            $item = $this->converter->toObject($xml);
        }
        catch (Exception $e) {
            $report->addError($e->getMessage());
        }
        return $report;
    }
}