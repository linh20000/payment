<?php


namespace Service\Payment\Momo\Constants;


class Converter
{
    public static function arrayToObject(array $arr, $object)
    {
        try {
            $className = get_class($object);
            $methods = get_class_methods($className);

            foreach ($methods as $method) {

                preg_match(' /^(set)(.*?)$/i', $method, $results);

                $pre = $results[1] ?? '';

                $k = $results[2] ?? '';

                $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                if ($pre == 'set' && !is_null($arr[$k])) {
                    $object->$method($arr[$k]);
                }
            }
            return $object;

        } catch (\Exception $e) {
            print_r($e->getTrace());
        }
    }

    public static function objectToJsonStrNoNull($object)
    {
        $arr = Converter::objectToArray($object);
        return self::arrayToJsonStrNoNull($arr);
    }

    public static function objectToArray($object)
    {
        $arr = [];
        try {
            $className = get_class($object);
            $methods = get_class_methods($className);
            foreach ($methods as $method) {

                preg_match(' /^(get)(.*?)$/i', $method, $results);

                $pre = $results[1] ?? '';

                $k = $results[2] ?? '';

                $k = strtolower(substr($k, 0, 1)) . substr($k, 1);
                if ($pre == 'get') {
                    $arr[$k] = $object->$method();
                }
            }
        } catch (\Exception $e) {
            print_r($e->getTrace());
        }
        return $arr;
    }

    public static function arrayToJsonStrNoNull(array $arr)
    {
        return json_encode(array_filter($arr, function ($var) {
            return !is_null($var);
        }));
    }

}
