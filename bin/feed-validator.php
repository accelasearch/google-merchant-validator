#!/usr/bin/env php
<?php
/*
 * This file is part of the AccelaSearch/GoogleMerchantValidator package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 */
use \AccelaSearch\GoogleMerchantValidator\Service\Normalizer;
use \AccelaSearch\GoogleMerchantValidator\Service\Validator;
ini_set('memory_limit', '2048M');


////////////////////////////////////////////////////////////////////////
// Includes autoloader
foreach ([
    'vendor/autoload.php',
    __DIR__ . '/../../autoload.php',
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/vendor/autoload.php'
    ] as $file) {
    if (file_exists($file)) {
        require $file;
        break;
    }
}


////////////////////////////////////////////////////////////////////////
// Sanity check
if ($argc < 2) {
    die(
        "Usage:" . PHP_EOL
      . "\t " . $argv[0] . " <path> [<only-invalid>]" . PHP_EOL
      . "Where:" . PHP_EOL
      . "\tpath:          Path to XML file" . PHP_EOL
      . "\tonly-invalid:  Whether to show only invalid items {true, false} (default: true)" . PHP_EOL
    );
}
$path = trim($argv[1]);
if (!is_readable($path)) {
    die('Cannot read XML feed file in "' . $argv[1] . '".' . PHP_EOL);
}
$only_invalid = count($argv) > 2 ? $argv[2] !== 'false' : true;
$temporary_path = 'tmp.xml';


////////////////////////////////////////////////////////////////////////
// Execution
printf("Normalizing XML file at $path...");
$start_time = microtime(true);
$normalizer = Normalizer::fromDefault();
try {
    $normalizer($path, $temporary_path);
}
catch (Exception $e) {
    die("Cannot process file at $path: " . $e->getMessage());
}
$end_time = microtime(true);
printf(" done in %.3f seconds." . PHP_EOL, $end_time - $start_time);

printf("Validating content of file $path...");
$start_time = microtime(true);
$validator = Validator::fromDefault();
$reports = $validator->validate($temporary_path);
$end_time = microtime(true);
unlink($temporary_path);
printf(" done in %.3f seconds."  . PHP_EOL, $end_time - $start_time);

printf(
    "Found %d items (invalid: %d)." . PHP_EOL,
    count($reports),
    count(array_filter($reports, fn ($report) => !$report->isValid()))
);
foreach ($reports as $report) {
    if ($report->isValid() && $only_invalid) {
        continue;
    }
    printf(
        "%16s: %s" . PHP_EOL,
        $report->getIdentifier(),
        empty($report->getErrorsAsArray()) ? 'valid' : implode(', ', $report->getErrorsAsArray())
    );
}