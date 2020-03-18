# sanitization
light sanitizer

# Install
```
composer require flatphp/sanitization
```

# Usage
```php
use \Flatphp\sanitization\sanitizer;

// one
$value = Sanitizer::sanitizeOne(' hello ', 'trim|upper');

// data
$data = [
    'v1' => '10.0',
    'v2' => ['a', 'b', 'c']
];
$data = Sanitizer::sanitize($data, array(
    'v1' => 'int',
    'v2' => 'string:,|upper'
));

// simple
$value = Sanitizer::toArray('1,2,3', ',');
```



# How to custom your own validate method 加入定制自己的验证方法
* Just extends sanitizer class and add your own method (继承)
* Or Just write global function (写全局函数)
*notes:*
method|function should be like toXxx($value) or toXxx($value, $params), example:   
方法或函数格式必须是这样的，参考以下：
```php
function toTest($value)
{
    return $value . ' test';
}

function toHello($value, $param)
{
    return $value .' '. $param;
}
```

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
