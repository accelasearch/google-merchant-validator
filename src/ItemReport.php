<?php
/*
 * This file is part of the AccelaSearch/GoogleMerchantValidator package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 */
namespace AccelaSearch\GoogleMerchantValidator;

/**
 * Report about a single item
 * 
 * This class follows the Static Factory Method design pattern.
 * 
 * @author Marco Zanella <marco.zanella@accelasearch.com>
 * @package AccelaSearch\GoogleMerchantValidator
 */
class ItemReport {
    /**
     * Identifier of item
     * @var string $identifier
     */
    private $identifier;

    /**
     * Set of errors
     * @var string[] $errors
     */
    private $errors;

    /**
     * Constructor
     * 
     * @param string $identifier Identifier
     * @param string[] $errors Set of errors
     */
    public function __construct(string $identifier, array $errors) {
        $this->identifier = $identifier;
        $this->errors = $errors;
    }

    /**
     * Creates a report from the identifier of an item
     * 
     * This is a Static Factory Method.
     * 
     * @param string $identifier Identifier of the item
     * @return self A new report
     */
    public static function fromIdentifier(string $identifier): self {
        return new ItemReport($identifier, []);
    }

    /**
     * Tells whether an item is valid
     * 
     * @return bool Whether item is valid
     */
    public function isValid(): bool {
        return empty($this->errors);
    }

    /**
     * Returns identifier of item
     * 
     * @return string Identifier of item
     */
    public function getIdentifier(): string {
        return $this->identifier;
    }

    /**
     * Returns set of errors
     * 
     * @return string[] Set of errors
     */
    public function getErrorsAsArray(): array {
        return $this->errors;
    }

    /**
     * Adds an error
     * 
     * @param string $error Error
     * @return $this This report
     */
    public function addError(string $error): self {
        $this->errors[] = $error;
        return $this;
    }

    /**
     * Removes every error
     * 
     * @return $this This report
     */
    public function clearErrors(): self {
        $this->errors = [];
        return $this;
    }
}