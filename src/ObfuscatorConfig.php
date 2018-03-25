<?php

namespace DKerner;

class ObfuscatorConfig
{
    const FILE_NOT_FOUND = "This file was not found: ";
    const AMOUNT_LESS_THAN_TWO = "Please use an amount greater than 1";
    const WIDTH_ZERO_OR_LESS = "Please use an width greater than 0";
    const HEIGHT_ZERO_OR_LESS = "Please use an height greater than 0";
    const MULTIPLE_INPUT_OPTIONS = "Multiple Inputs provided. Use input resource or input path";
    const NO_INPUT_RESOURCE_GIVEN = "Creating from resource but none given";
    const INPUT_RESOURCE_NOT_OF_TYPE_GD = "Please provide a valid gd resource";

    /**
     * @var string
     */
    protected $inputPath;
    /**
     * @var resource
     */
    protected $inputResource;
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
     * @var ImageDimension
     */
    protected $inputDimension;


    /**
     * @return mixed
     */
    public function getInputPath()
    {
        return $this->inputPath;
    }

    /**
     * @param mixed $inputPath
     */
    public function setInputPath(string $inputPath)
    {
        if (!file_exists($inputPath)) {
            throw new \Exception(self::FILE_NOT_FOUND . $inputPath);
        }
        $this->inputPath = $inputPath;
        $this->checkInputs();
        $this->setInputDimension();

        return $this;
    }

    /**
     * @return resource
     */
    public function getInputResource()
    {
        return $this->inputResource;
    }

    /**
     * @param $inputResource
     */
    public function setInputResource( $inputResource )
    {
        if (get_resource_type($inputResource) !== 'gd') {
            throw new \Exception(self::WIDTH_ZERO_OR_LESS);
        }

        $this->inputResource = $inputResource;
        $this->checkInputs();
        $this->setInputDimension();

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
        if ($cellCount < 2) {
            throw new \Exception(self::AMOUNT_LESS_THAN_TWO);
        }
        $this->cellCount = $cellCount;

        return $this;
    }


    /**
     * @return ImageDimension
     */
    public function getInputDimension()
    {
        return $this->inputDimension;
    }

    /**
     * @return ImageDimension
     */
    public function getOutputDimension()
    {
        return $this->outputDimension;
    }

    public function setOutputSize(int $newWidth, int $newHeight)
    {
        if ($newWidth < 1) {
            throw new \Exception(self::WIDTH_ZERO_OR_LESS);
        }
        if ($newHeight < 1) {
            throw new \Exception(self::HEIGHT_ZERO_OR_LESS);
        }

        $this->outputDimension = new ImageDimension($newWidth, $newHeight);
    }

    protected function setInputDimension()
    {
        $this->inputDimension = ImageDimension::fromResource($this->getImage());
    }

    protected function checkInputs()
    {
        if ($this->getInputPath() && $this->getInputResource()){
            throw new \Exception(self::MULTIPLE_INPUT_OPTIONS);
        }
    }

    public function getImage()
    {
        if($this->getInputResource()) {
            return $this->getInputResource();
        }else{
            return imagecreatefromjpeg($this->getImagePath());
        }
    }

    public function returnResource()
    {
        print_r($this->getOutputPath());
        return $this->getOutputPath() ? false : true;
    }
}