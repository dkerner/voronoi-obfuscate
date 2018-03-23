<?php

namespace DKerner;

class ObfuscatorConfig
{
    const FILE_NOT_FOUND = "This file was not found: ";
    const AMOUNT_LESS_THAN_TWO = "Please use an amount greater than 1";
    const WIDTH_ZERO_OR_LESS = "Please use an width greater than 0";
    const HEIGHT_ZERO_OR_LESS = "Please use an height greater than 0";

    /**
     * @var string
     */
    protected $imagePath;
    /**
     * @var string
     */
    protected $outputPath;
    /**
     * @var int
     */
    protected $cellCount;
    /**
     * @var ImageDimension
     */
    protected $outputDimension;



    /**
     * @return mixed
     */
    public function getImagePath()
    {
        return $this->imagePath;
    }

    /**
     * @param mixed $imagePath
     */
    public function setImagePath(string $imagePath)
    {
        if(!file_exists($imagePath)) {
            throw new \Exception(self::FILE_NOT_FOUND .  $imagePath);
        }
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getOutputPath()
    {
        return $this->outputPath;
    }

    /**
     * @param mixed $outputPath
     */
    public function setOutputPath(string $outputPath)
    {
        $this->outputPath = $outputPath;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getCellCount()
    {
        return $this->cellCount;
    }

    /**
     * @param mixed $cellCount
     */
    public function setCellCount(int $cellCount)
    {
        if($cellCount < 2) {
            throw new \Exception(self::AMOUNT_LESS_THAN_TWO);
        }
        $this->cellCount = $cellCount;

        return $this;
    }



    /**
     * @return ImageDimension
     */
    public function getOutputDimension()
    {
        return $this->outputDimension;
    }

    public function setOutputSize(int $newWidth,int $newHeight)
    {
        if($newWidth < 1) {
            throw new \Exception(self::WIDTH_ZERO_OR_LESS);
        }
        if($newHeight < 1) {
            throw new \Exception(self::HEIGHT_ZERO_OR_LESS);
        }

        $this->outputDimension = new ImageDimension($newWidth, $newHeight);
    }
}