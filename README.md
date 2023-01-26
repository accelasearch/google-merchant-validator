# Google Merchant Validator
Command-line validator for Google Merchant product feed.

## Installation
Recommended installation is through Composer:

```bash
composer require accelasearch/google-merchant-validator
```

Manual installation is possible by cloning or downloading this repository:

```bash
git clone https://github.com/accelasearch/sdk-php.git
```

```bash
wget https://github.com/accelasearch/sdk-php/archive/refs/heads/main.zip
```

## Usage
To check whether an XML file is a valid Google Merchant product feed run:
```bash
php bin/feed-validator.php path-to-xml-feed.xml
```

You will get an output similar to the one shown below, with additional information about items which are not valid:
```
Normalizing XML file at /home/marco/Scrivania/google-shopping-feed.xml... done in 0.037 seconds.
Validating content of file /home/marco/Scrivania/google-shopping-feed.xml... done in 0.069 seconds.
Found 547 items (invalid: 0).
```

By default report is shown only for invalid items. It is possible to force report for every item by running:
```bash
php bin/feed-validator.php path-to-xml-feed.xm
Normalizing XML file at /home/marco/Scrivania/google-shopping-feed.xml... done in 0.037 seconds.
Validating content of file /home/marco/Scrivania/google-shopping-feed.xml... done in 0.069 seconds.
Found 547 items (invalid: 0).
               1: valid
               2: valid
               ...
```

### Generating a PHAR File
It is possible to generate a PHAR archive by running:
```bash
php bin/compile-phar.php
```
which will produce a file named `bin/google-merchant-validator.phar` that can be distributed.

**Note**: when using a PHAR file path to the XML file must be provided as an absolute path:
```bash
php google-merchant-validator.phar /absolute/path/to/xml-feed.xml
```