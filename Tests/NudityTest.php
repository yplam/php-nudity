<?php
namespace YPL\Nudity\Tests;

use YPL\Nudity\Nudity;
use Imagine\Gd\Imagine;

class NudityTest extends \PHPUnit_Framework_TestCase
{
    function testNudity()
    {
        $imagine = new Imagine();
        $nudity = new Nudity(array('debug'=>true));
        
        $yesFiles = glob(__DIR__.'/img/yes/*.jpg');
        if(!empty($yesFiles)){
            foreach($yesFiles as $file){
                $image = $imagine->open($file);
                $this->assertTrue($nudity->detect($image));
            }
        }
        $noFiles = glob(__DIR__.'/img/no/*.jpg');
        if(!empty($noFiles)){
            foreach($noFiles as $file){
                $image = $imagine->open($file);
                $this->assertFalse($nudity->detect($image));
            }
        }

    }
}