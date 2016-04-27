<?php

namespace iCanConvertAnyDate\local;

use \Exception;
use \DateTime;
use \DateTimeZone;
use \DateInterval;

class Thai
{
    private $time_str;

    private $remove_character = [",", "เวลา"];

    private $thai_month = [
        'January' => ['มกราคม', 'ม.ค.', 'ม.ค', 'มค.'],
        'February' => ['กุมภาพันธ์', 'ก.พ.', 'ก.พ', 'กพ.'],
        'March' => ['มีนาคม', 'มี.ค.', 'มี.ค', 'มีค.'],
        'April' => ['เมษายน', 'เม.ย.', 'เมย.'],
        'May' => ['พฤษภาคม', 'พ.ค.', 'พค.'],
        'June' => ['มิถุนายน', 'มิ.ย.', 'มิย.'],
        'July' => ['กรกฎาคม', 'ก.ค.', 'กค.'],
        'August' => ['สิงหาคม', 'ส.ค.', 'สค.'],
        'September' => ['กันยายน', 'ก.ย.', 'กย.'],
        'October' => ['ตุลาคม', 'ต.ค.', 'ตค.'],
        'November' => ['พฤศจิกายน', 'พ.ย.', 'พย.'],
        'December' => ['ธันวาคม', 'ธ.ค.', 'ธค.'],
    ];

    private $thai_date = [
        "Monday" => "จันทร์",
        "Tuesday" => "อังคาร",
        "Wednesday" => "พุธ",
        "Thursday" => "พฤหัสบดี",
        "Friday" => "ศุกร์",
        "Saturday" => "เสาร์",
        "Sunday" => "อาทิตย์",
    ];

    public function __construct($time_str, $format)
    {
        $this->time_str = strtolower($time_str);
        $this->format = $format;
    }

    public function convert()
    {
        self::convertThaiMonthToEnglish();
        self::convertThaiDateToEnglish();
        self::replaceSpecialCharactor();
        self::convertSpecialKeyword();

        if ($this->format == null) {
            $unixtime = strtotime($this->time_str);

            // If can convert time to unixtime
            // Subtract (3600 * 7)
            if ($unixtime !== false) {
                return $unixtime - (3600 * 7);
            }

            $parseDate['hour'] = 0;
            $parseDate['minute'] = 0;
            $parseDate['second'] = 0;
            $parseDate = date_parse($this->time_str);
            if ($parseDate['year'] !== false && $parseDate['month'] !== false && $parseDate['day'] !== false) {
                // Subtract (3600 * 7)
                return strtotime($parseDate['year']."-".$parseDate['month']."-".$parseDate['day']." ".$parseDate['hour'].":".$parseDate['minute'].":".$parseDate['minute']) - (3600 * 7);
            }

            throw new Exception("I can't convert you date string");
        } else {
            $date = DateTime::createFromFormat($this->format, $this->time_str, new DateTimeZone('Asia/Bangkok'));
            $unixtime = $date->getTimestamp();
            return $unixtime;
        }
    }

    private function getTodayYmd()
    {
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone('Asia/Bangkok'));
        return $date->format('Y-m-d');
    }

    private function getYesterdayYmd()
    {
        $date = new DateTime();
        $date->setTimeZone(new DateTimeZone('Asia/Bangkok'));
        $date->add(DateInterval::createFromDateString('yesterday'));
        return $date->format('Y-m-d');
    }

    private function convertThaiMonthToEnglish()
    {
        foreach ($this->thai_month as $key => $value) {
            $this->time_str = str_replace($value, $key, $this->time_str);
        }
    }

    private function convertThaiDateToEnglish()
    {
        foreach ($this->thai_date as $key => $value) {
            $this->time_str = str_replace($value, $key, $this->time_str);
        }
    }

    private function replaceSpecialCharactor()
    {
        $this->time_str = str_replace($this->remove_character, "", $this->time_str);
    }

    private function convertSpecialKeyword()
    {
        $special_keyword = self::createSpecialKeyword();

        foreach ($special_keyword as $key => $value) {
            $this->time_str = str_replace($value, $key, $this->time_str);
        }
    }

    private function createSpecialKeyword()
    {
        $special_keyword = [];
        $today = self::getTodayYmd();
        $yesterday = self::getYesterdayYmd();
        $special_keyword[$today] = ['วันนี้'];
        $special_keyword[$yesterday] = ['เมื่อวาน', 'เมื่อวานนี้'];

        return $special_keyword;
    }
}
