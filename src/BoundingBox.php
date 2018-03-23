<?php
/**
 * Date: 22.03.2018
 * Time: 21:37
 */

namespace DKerner;


class BoundingBox
{
    public $xl;
    public $xr;
    public $yt;
    public $yb;

    public function __construct($xl, $xr, $yt, $yb) {

        $this->xl = $xl;
        $this->xr = $xr;
        $this->yt = $yt;
        $this->yb = $yb;
    }

    public static function createFromDimension(ImageDimension $inputDimensions)
    {
        return new BoundingBox(0, $inputDimensions->getWidth(), 0, $inputDimensions->getHeight());
    }
}