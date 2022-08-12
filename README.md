GumWrapper
===

A lightweight wrapper around [Gum](https://github.com/charmbracelet/gum): A tool for glamorous shell scripts. See the [Gum documentation](https://github.com/charmbracelet/gum) for more documentation on the underlying features.

# Getting Started

Install with composer:

```sh
composer install adamgaskins/gumwrapper
```

Usage:

```php
$gum = new Gum();
$gum->choose([ 'apple', 'banana', 'pear' ])
```

The following platforms are currently supported. Please make a PR to `BinManager.php` to add support for [other platforms Gum supports](https://github.com/charmbracelet/gum/releases/tag/v0.4.0)!
- Apple M1
- Apple Intel
- Windows i386
- Windows x86_64

# Reference

### [Choose](https://github.com/charmbracelet/gum#choose)
```php
$result = $gum->choose([ 'apple', 'banana', 'pear', 'orange' ]);
// example: "apple"
```

```php
$gum->choose(
    $options = [ 'apple', 'banana', 'pear', 'orange' ],
    $limit = 2, // enable multiselect
    $height = 10 // scroll if more than 10 items
);
```

### [Confirm](https://github.com/charmbracelet/gum#confirm)
```php
$result = $gum->confirm();
// example: true
```

```php
$gum->confirm(
    $prompt = 'Are you sure?',
    $affirmativeText = 'Yeah!',
    $negativeText = 'Actually, no',
    $default = false // default to "no" option
);
```

### [Input](https://github.com/charmbracelet/gum#input)
```php
$result = $gum->input('What is your name?');
// example: "Adam"
```

```php
$gum->input(
    $placeholder = 'Password',
    $prompt = '> ',
    $initialValue = null,
    $charLimit = 400,
    $width = 10,
    $password = true
);
```

### [Spin](https://github.com/charmbracelet/gum#spin)

Note: Do not write any output or call any other Gum commands before `->terminate()`-ing the spinner, or errors may occur.

```php
$spinner = $gum->spin();
sleep(10); // do some long task
$spinner->terminate();
```

```php
$gum->spin(
    $title = 'Downloading files...',
    $spinner = 'pulse'
);
```
