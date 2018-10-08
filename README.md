# php-nudity
A PHP implementation of a nudity scanner based on approaches from research papers.

Please note that this lib is not performance optimized and may really slow.

## Installation
The best way to install JSendResponse is to use a [Composer](https://getcomposer.org/download):

    php composer.phar require yplam/php-nudity

## Examples

```php
use YPL\Nudity\Nudity;
use Imagine\Imagick\Imagine; #or Imagine\Gd\Imagine; 


$imagine = new Imagine();

$image = $imagine->open($file_name); #load from file
# or
$image = $imagine->load($string); #load from string
# or
$image = $imagine->read($resource); #load from stream


$options = [
	'threshold' => 0.15, #optional
	'maxWidth' => 640, #optional
	'maxHeight' => 480, #optional
	'debug' => false, #optional
];

$nudity = new Nudity($options);


$is_nudity = $nudity->detect($image);

```


## REFERENCES

[Imagine documentation](https://imagine.readthedocs.io/en/latest/)

[Explicit Image Detection using YCbCr Space Color Model as Skin Detection](http://www.wseas.us/e-library/conferences/2011/Mexico/CEMATH/CEMATH-20.pdf)

[An Algorithm for Nudity Detection](https://sites.google.com/a/dcs.upd.edu.ph/csp-proceedings/Home/pcsc-2005/AI4.pdf?attredirects=0)
