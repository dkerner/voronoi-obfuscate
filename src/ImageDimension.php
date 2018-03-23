<?php

namespace DKerner;


class ImageDimension
{
    protected $height;
    protected $width;

    public function __construct(int $width,int $height) {

        $this->width = $width;
        $this->height = $height;
    }

    public static function fromFile(string $filePath)
    {
        list($width, $height) = getimagesize($filePath);
        return new ImageDimension($width, $height);
    }

    /**
     * @return mixed
     */
    public function getWidth()
    {
        return $this->width;
    }

    /**
     * @return mixed
     */
    public function getHeight()
    {
        return $this->height;
    }
}