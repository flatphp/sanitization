<?php namespace Flatphp\Sanitization;



class Sanitizer
{
    /**
     * single value:
     * sanitizeOne('test', 'upper|trim:/')
     *
     * multi values:
     * sanitize(['aa' => 22.12, 'bb' => 34.1789], ['aa' => 'trim|upper', 'bb' => 'float:3'])
     *
     * @param mixed $data
     * @param mixed $rules
     * @return bool
     */
    public static function sanitize($data, $rules)
    {
        foreach ($rules as $key => $rule) {
            if (isset($data[$key])) {
                $data[$key] = self::sanitizeOne($data[$key], $rule);
            }
        }
        return $data;
    }

    /**
     * @param mixed $value
     * @param string $rule
     * @return mixed
     */
    public static function sanitizeOne($value, $rule)
    {
        $rule = explode('|', $rule);
        foreach ($rule as $method) {
            if (strpos($method, ':')) {
                $method = explode(':', $method, 2);
                $param = $method[1];
                $method = trim($method[0]);
            } else {
                $param = null;
                $method = trim($method);
            }
            $self_method = 'to'. ucfirst($method);
            if (method_exists(get_called_class(), $self_method)) {
                $value = static::$self_method($value, $param);
            } elseif (function_exists($self_method)) {
                if (null === $param) {
                    $value = $self_method($value);
                } else {
                    $value = $self_method($value, $param);
                }
            }
        }
        return $value;
    }

    /**
     * @param mixed $value
     * @param string $delimiter
     * @return string
     */
    public static function toString($value, $delimiter = null)
    {
        if (is_string($value)) {
            return $value;
        }
        if (is_array($value)) {
            if ($delimiter) {
                return implode($delimiter, $value);
            } else {
                return self::toJson($value);
            }
        }
        return (string)$value;
    }

    /**
     * @param mixed $value
     * @return int
     */
    public static function toInt($value)
    {
        return (int)$value;
    }

    /**
     * @param mixed $value
     * @param null $delimiter
     * @return array
     */
    public static function toArray($value, $delimiter = null)
    {
        if (is_array($value)) {
            return $value;
        }
        if ($delimiter) {
            return explode($delimiter, $value);
        }
        $res = json_decode($value, true);
        if (json_last_error() == JSON_ERROR_NONE) {
            return $res;
        }
        return [$value];
    }

    /**
     * @param mixed $value
     * @return string
     */
    public static function toJson($value)
    {
        return json_encode($value, JSON_UNESCAPED_UNICODE);
    }

    /**
     * @param mixed $value
     * @param int $scale
     * @return float|array
     */
    public static function toFloat($value, $scale = 2)
    {
        return number_format($value, $scale, '.', '');
    }

    /**
     * @param mixed $value
     * @return bool
     */
    public static function toBool($value)
    {
        return (bool)$value;
    }

    /**
     * @param $value
     * @return string
     */
    public static function toLower($value)
    {
        return strtolower($value);
    }

    /**
     * @param $value
     * @return string
     */
    public static function toUpper($value)
    {
        return strtoupper($value);
    }

    /**
     * @param string $value
     * @param string|array $chars
     * @return string
     */
    public static function toStrip($value, $chars)
    {
        if (!is_array($chars)) {
            $chars = str_split($chars);
        }
        return str_replace($chars, '', $value);
    }
}