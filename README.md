# EntityGenerator

EntityGenerator will help you to create the models/entities that you require for your application. 
If your IDE is not supportive enough, you can simply copy paste your table columns in here.

### Installation

```sh
composer require driessenstijn/EntityGenerator/
```

## Why use EntityGenerator?

Well, if your IDE is not supportive enough you must have something else to do the dirty work.

## How to use

It's simple:
- Type: EXPLAIN <table> in your MySQL Workbench
- Copy the columns of name and type to your clipboard
- Paste your clipboard and enter your table name in the form
- Enjoy the file content that needs to be created

## Usage example

```php
require_once __DIR__ . '/../vendor/autoload.php';

use EntityGenerator\EntityGenerator;

```