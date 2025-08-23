<?php

namespace PhpFit\SourceGenerator;

use Closure;
use ReflectionFunction;

class Generator
{
    public static function array(array $array, int $space = 0): string
    {
        $space_chr = self::getSpace($space);
        $indexed = array_keys($array) === range(0, count($array)-1);
        $nl = PHP_EOL;
        $tx = '';

        $here_space = $space + 4;
        $here_space_chr = self::getSpace($here_space);

        foreach ($array as $key => $value) {
            $tx .= $here_space_chr;

            if (!$indexed) {
                $tx .= self::toSource($key) . ' => ';
            }
            $tx .= self::toSource($value, $here_space);
            $tx .= ',';
            $tx .= $nl;
        }

        $tx = chop($tx, "\n,");

        if ($tx) {
            $tx = '[' . $nl . $tx . $nl . $space_chr . ']';
        } else {
            return '[]';
        }

        return $tx;
    }

    public static function func(Closure $func): string
    {
        // TODO
        return '*FUNCTION*';
    }

    public static function getSpace(int $space): string
    {
        return str_repeat(' ', $space);
    }

    public static function object(object $object): string
    {
        return '*OBJECT*';
    }

    public static function toSource(mixed $data, int $space = 0): string
    {
        $tx = '';

        if (is_string($data)) {
            $data = addslashes($data);
            $data = str_replace('\\"', '"', $data);
            return '\'' . $data . '\'';
        }

        if (is_numeric($data)) {
            return "$data";
        }

        if (is_bool($data)) {
            return $data ? 'true' : 'false';
        }

        if (is_null($data)) {
            return 'null';
        }

        if (is_resource($data)) {
            return '\'*RESOURCE*\'';
        }

        if (is_object($data)) {
            if ($data instanceof Closure) {
                return self::func($data);
            }

            $cls_name = get_class($data);

            if ($cls_name == 'stdClass') {
                return '(object)' . self::array((array)$data, $space);
            }

            return self::object($data);
        }

        if (is_array($data)) {
            return self::array($data, $space);
        }

        return var_export($data, true);
    }
}
