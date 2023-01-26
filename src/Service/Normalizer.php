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
use \RuntimeException;

/**
 * Normalizes an XML feed
 * 
 * This class follows the Static Factory Method design pattern.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 * @package AccelaSearch\GoogleMerchantValidator
 */
class Normalizer {
    /**
     * Creates a normalizer from default values
     * 
     * @return self A new normalizer
     */
    public static function fromDefault(): self {
        return new Normalizer();
    }

    /**
     * Normalizes an XML feed
     * 
     * @param string $source Path to the original file
     * @param string $destination Path to destination file
     * @return $this This normalizer
     */
    public function __invoke(string $source, string $destination): self {
        $command = sprintf(
            'xmllint --c14n %s | tr -d "\n" | sed "s/<item>/\n<item>/g" | sed "s/<\/channel>/\n<\/channel>/g" > %s',
            $source,
            $destination
        );
        $has_normalized = system($command);
        if ($has_normalized === false) {
            throw new RuntimeException("Could not normalize XML file");
        }
        return $this;
    }
}