# voronoi-obfuscate

Create an obfuscated version of a source image by using a Voronoi diagram (see. https://en.wikipedia.org/wiki/Voronoi_diagram)

## Getting Started

Maybe you feel like making "art" from your images or you just like your images obfuscated

Input (200x200px):

![input](https://raw.githubusercontent.com/dkerner/voronoi-obfuscate/master/demo-images/demo.jpg)

Results:

![result](https://raw.githubusercontent.com/dkerner/voronoi-obfuscate/master/demo-images/out.jpg)

Reduce Size to 100x100px

![result](https://raw.githubusercontent.com/dkerner/voronoi-obfuscate/master/demo-images/out_100x100.jpg)

Non proportional resize to 400x100px

![result](https://raw.githubusercontent.com/dkerner/voronoi-obfuscate/master/demo-images/out_400x100.jpg)

Non proportional resize to 100x400px

![result](https://raw.githubusercontent.com/dkerner/voronoi-obfuscate/master/demo-images/out_100x400.jpg)


### Installing

```
composer require dkerner/voronoi-obfuscate "@dev"
```

### Usage

```php
// create an obfuscated version of demo.jpg, store it as out.jpg 
// and create 500 points
VoronoiObfuscator::createFromImagePath('demo.jpg', 'out.jpg', 500);
 
// use config and resize the resulting image
$config = new ObfuscatorConfig();
$config->setImagePath('demo.jpg')
    ->setOutputPath('out.jpg')
    ->setCellCount(1000)
    ->setOutputSize(400,800);

VoronoiObfuscator::createFromConfig($config);
```

## Authors

* **Daniel Kerner** - [dkerner](https://github.com/dkerner)

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details

## Acknowledgments

* https://github.com/sroze with the sroze/PHP-Voronoi-algorithm example which was a great starting point and whose Nurbs classes are used at the moment
* https://github.com/zippex who needed the image obfuscation
