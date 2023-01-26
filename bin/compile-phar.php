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
$source_dir = __DIR__ . '/../';
$binary = 'bin/feed-validator.php';
$target = __DIR__ . '/google-merchant-validator.phar';

$phar = new Phar($target);
$include = '/^(?=(.*src|.*bin|.*vendor))(.*)$/i';
$phar->buildFromDirectory($source_dir, $include);
$phar->setStub($phar->createDefaultStub($binary));
$phar->compressFiles(Phar::GZ);
chmod($target, 0755);