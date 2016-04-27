<?php
use iCanConvertAnyDate\ConvertDate;

class iCanConvertAnyDateTest extends PHPUnit_Framework_TestCase
{

    protected function setUp()
    {
        $this->converter = new ConvertDate();
    }

    public function testConvertStandardFormatWithFirstExample()
    {
        // d F, Y, h:i:s a
        $input = "16 เมษายน, 2015, 02:37:44 PM";
        $expect = 1429169864;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    public function testConvertStandardFormatWithSecondExample()
    {
        // l d F Y h:m a
        $input = "จันทร์ 13 ต.ค. 2014 5:16 pm";
        $expect = 1413195360;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    public function testConvertStandardFormatWithThirdExample()
    {
        // F, d, Y, h:i:s a
        $input = "เมษายน 20, 2016, 08:06:39 am";
        $expect = 1461114399;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    public function testConvertStandardFormatWithForthExample()
    {
        // y-m-d H:i
        $input = "14-01-22 14:22";
        $expect = 1390375320;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    // With format specify
    public function testConvertStandardFormatWithFifthExample()
    {
        // d-m-y H:i
        $input = "06-03-09 10:12";
        $expect = 1236309120;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th", $format="d-m-y H:i"));
    }

    public function testConvertStandardFormatWithSixthExample()
    {
        // Y-m-d h:i:s a
        $input = "วันนี้ เวลา 12:48:09 PM";
        $expect = 1461736089;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    public function testConvertStandardFormatWithSeventhExample()
    {
        // Y-m-d h:i:s a
        $input = "เมื่อวานนี้ เวลา 04:16:16 PM";
        $expect = 1461662176;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }

    public function testConvertStandardFormatWithEighthExample()
    {
        // F d, Y, h:i:s a
        $input = "เมษายน 25, 2016, 05:16:16 PM";
        $expect = 1461579376;
        $this->assertEquals($expect, $this->converter->convert($input, $local="th"));
    }
}
