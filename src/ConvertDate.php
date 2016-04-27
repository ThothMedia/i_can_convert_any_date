<?php

namespace iCanConvertAnyDate;

use \Exception;
use iCanConvertAnyDate\local\Thai;

class ConvertDate
{
    public function convert($time_str, $local='en', $format=null)
    {
        $convertFromLocal = self::convertFromLocal($time_str, $local, $format);
        return $convertFromLocal;
    }

    private function convertFromLocal($time_str, $local, $format)
    {
        if (strtolower($local) == 'th') {
            $converter = new Thai($time_str, $format);
            return $converter->convert();
        } else {
            return strtotime($time_str);
        }
    }
}
