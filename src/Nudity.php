<?php

/*
 * This file is part of the YPL\Nudity package.
 *
 * (c) yplam <yplam@yplam.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace YPL\Nudity;

use Imagine\Image\ImagineInterface;
use Imagine\Image\Box;
use Imagine\Image\Point;

class Nudity 
{
    protected $imagine;

    protected $threshold;

    protected $maxSize;

    protected $debug;

    public function __construct(ImagineInterface $imagine, array $options=array())
    {
        $this->imagine = $imagine;

        $this->threshold = isset($options['threshold']) ? $options['threshold'] : 0.15;
        $maxWidth = isset($options['maxWidth']) ? (int)$options['maxWidth'] : 640;
        $maxHeight = isset($options['maxHeight']) ? (int)$options['maxHeight'] : 480;
        $this->maxSize = new Box($maxWidth, $maxHeight);
        $this->debug = isset($options['debug']) ? $options['debug'] : false;
    }

    public function detect($filepath)
    {
        $image = $this->imagine->open($filepath);
        $thumbnail = $image->thumbnail($this->maxSize);
        $imageSize = $thumbnail->getSize();
        $width = $imageSize->getWidth();
        $height = $imageSize->getHeight();
        $skinMap = array_fill(0, $width, array_fill(0, $height, 0));
        $white = 250;
        $black = 5;
        $total = 0;
        $count = 0;
        for($x=0; $x<$width; $x++){
            for($y=0; $y<$height; $y++){
                $color = $thumbnail->getColorAt(new Point($x, $y));
                $r = $color->getRed();
                $g = $color->getGreen();
                $b = $color->getBlue();
                if((($r > $white) && ($g > $white) && ($b > $white)) ||
                    (($r < $black) && ($g < $black) && ($b < $black))) 
                    continue;
                //$Y = 16 + 0.2568*$r + 0.5041*$g + 0.0979*$b;
                $Cb = 128 - 0.1482*$r - 0.291*$g + 0.4392*$b;
                $Cr = 128 + (0.4392 * $r) + (-0.3678 * $g) + (-0.0714 * $b);
                if(($Cb >= 80) && ($Cb <= 120) && ($Cr >= 133) && ($Cr <= 173)){
                    $skinMap[$x][$y] = 1;
                    $count++;
                }
                $total++;
            }
        }
        $this->dump(($count / $total));
        if(($count / $total) < $this->threshold){
            return false;
        }
        // todo: apply border following to detect regions
        return true;
    }

    private function dump($string){
        if($this->debug){
            print($string."\n");
        }
    }

}