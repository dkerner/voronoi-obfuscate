<?php

namespace DKerner;


use Nurbs_Point;
use Voronoi;

class VoronoiObfuscator
{
    protected $inputDimensions;
    protected $boundingBox;
    protected $points;
    protected $outputImage;
    protected $diagram;


    public static function createFromImagePath(string $imagePath, string $outputPath, int $cellCount = 400)
    {
        $config = new ObfuscatorConfig();
        $config->setImagePath($imagePath)
            ->setOutputPath($outputPath)
            ->setCellCount($cellCount)
            ->setOutputSize(500,800);

        return new VoronoiObfuscator($config);
    }

    public static function createFromConfig(ObfuscatorConfig $config)
    {
        return new VoronoiObfuscator($config);
    }

    public function __construct(ObfuscatorConfig $config)
    {
        $this->config = $config;

        $this->inputImage = $this->getImageReference();
        $this->inputDimensions = $this->getImageDimensions();
        
        if($this->config->getOutputDimension()) {
            $image_p = imagecreatetruecolor($this->config->getOutputDimension()->getWidth(), $this->config->getOutputDimension()->getHeight());
            imagecopyresampled(
                $image_p, $this->inputImage,
                0, 0, 0, 0,
                $this->config->getOutputDimension()->getWidth(), $this->config->getOutputDimension()->getHeight(),
                $this->inputDimensions->getWidth(), $this->inputDimensions->getHeight()
            );
            $this->inputImage = $image_p;
            $this->inputDimensions = $this->config->getOutputDimension();

        }
        
        
        $this->boundingBox = $this->getBoundingBox();

// Generate random points
        $this->points = $this->generatePoints();

// Compute the diagram
        $this->diagram = $this->generateVoronoiDiagram();

        // Create image using GD
        $this->outputImage = imagecreatetruecolor($this->inputDimensions->getWidth(), $this->inputDimensions->getHeight());

// Draw polygons
        $this->drawPolygons();

// Display image
        imagejpeg($this->outputImage, $this->config->getOutputPath());
    }

    public function getImageReference()
    {
        return imagecreatefromjpeg($this->config->getImagePath());
    }

    public function getImageDimensions()
    {
        return ImageDimension::fromFile($this->config->getImagePath());
    }

    public function getBoundingBox()
    {
        return BoundingBox::createFromDimension($this->inputDimensions);
    }

    public function generatePoints()
    {
        $points = [];
        for ($i = 0; $i < $this->config->getCellCount(); ++$i) {
            $points[] = new Nurbs_Point(
                rand($this->boundingBox->xl, $this->boundingBox->xr),
                rand($this->boundingBox->yt, $this->boundingBox->yb)
            );
        }
        return $points;
    }

    public function generateVoronoiDiagram()
    {
        return (new Voronoi())->compute($this->points, $this->boundingBox);
    }

    public function drawPolygons()
    {
        foreach ($this->diagram['cells'] as $cell) {
            $points = [];

            if (count($cell->_halfedges) > 0) {
                $v = $cell->_halfedges[0]->getStartPoint();
                if ($v) {
                    $points[] = $v->x;
                    $points[] = $v->y;
                }

                for ($i = 0; $i < count($cell->_halfedges); $i++) {
                    $halfedge = $cell->_halfedges[$i];

                    $v = $halfedge->getEndPoint();
                    if ($v) {
                        $points[] = $v->x;
                        $points[] = $v->y;
                    }
                }
            }

            // Create polygon with a color picked from cell centre
            $xColorPos = min($this->inputDimensions->getWidth() - 1, max(0, $cell->_site->x));
            $yColorPos = min($this->inputDimensions->getHeight() - 1, max(0, $cell->_site->y));
            imagefilledpolygon($this->outputImage, $points, count($points) / 2, imagecolorat($this->inputImage, $xColorPos, $yColorPos));
        };
    }
}