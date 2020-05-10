# sanitization
light sanitizer

# Install
```
composer require flatphp/sanitization
```

# Usage
```php
use \Flatphp\sanitization\sanitizer;

// sanitize one
$value = Sanitizer::sanitizeOne(' hello ', 'trim|upper');


// sanitize all
$data = [
    'v1' => '10.0',
    'v2' => ['a', 'b', 'c'],
    'v3' => ' hello '
];
$data = Sanitizer::sanitize($data, array(
    'v1' => 'int',
    'v2' => 'string:,|upper',
    'v3' => function($value){
        return strtoupper(trim($value));
    }
));


// just use single
$value = Sanitizer::toArray('1,2,3', ',');
```



# Custom your own validate method 加入定制自己的验证方法
* Use anonymous function like example
* Just extends sanitizer class and add your own method (继承)
* Or Just write global function (写全局函数)

# Methods 已有的方法和规则
| method | rule | note |
| --- | --- | --- |
|  | trim | php function |
|  | ltrim | php function |
|  | rtrim | php function |
| toString($value, $delimiter = null) | string |  |
| toInt($value) | int |  |
| toArray($value, $delimiter = null) | array |  |
| toJson($value) | json |  |
| toFloat($value, $scale = 2) | float |  |
| toBool($value) | bool |  |
| toLower($value) | lower |  |
| toUpper($value) | upper |  |
| toStrip($value, $chars) | strip |  |
