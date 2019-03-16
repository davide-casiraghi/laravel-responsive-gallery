[![Latest Stable Version](https://img.shields.io/packagist/v/davide-casiraghi/laravel-responsive-gallery.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-responsive-gallery)
<a href="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery"><img src="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery.svg" alt="Build Status"></a>
[![StyleCI](https://styleci.io/repos/175794655/shield?style=flat-square)](https://styleci.io/repos/175794655)
[![GitHub last commit](https://img.shields.io/github/last-commit/davide-casiraghi/laravel-responsive-gallery.svg)](https://github.com/davide-casiraghi/laravel-responsive-gallery) 

# Laravel Responsive Gallery
A PHP library to create responsive galleries that are organized into Pinterest like columns.   
To generate the grid is used [Bricklayer.js](http://bricklayer.js.org/).
To open the image in a popup is used [Fancybox 3](https://fancyapps.com/fancybox/3/).

The library replace all the occurrences of this kind of snippet
```
{# gallery src=[holiday_images/london] column_width=[250] gutter=[20] #}
```
With the HTML code of a responsive gallery.
```html
<div class='responsiveGallery bricklayer' data-column-width="250" data-gutter="20">
    <div class='box'>
        <a href='gallery/holidays/IMG_1584.jpg' data-fancybox='images' data-caption=''>
            <img src='gallery/holidays/thumb/IMG_1584.jpg' />
        </a>
    </div>
    <div class='box'>
        <a href='gallery/holidays/IMG_1244.jpg' data-fancybox='images' data-caption=''>
            <img src='gallery/holidays/thumb/IMG_1244.jpg' />
        </a>
    </div>
    ...
</div>
```

## How to use it
[Read Tutorial and Documentation →](https://github.com/davide-casiraghi/laravel-responsive-gallery/wiki)


## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://github.com/davide-casiraghi/bootstrap-accordion-integrator/blob/master/LICENSE.md)
