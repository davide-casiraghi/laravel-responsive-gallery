[![Latest Stable Version](https://img.shields.io/packagist/v/davide-casiraghi/laravel-responsive-gallery.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-responsive-gallery)
<a href="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery"><img src="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery.svg" alt="Build Status"></a>
[![StyleCI](https://styleci.io/repos/175794655/shield?style=flat-square)](https://styleci.io/repos/175794655)

# Laravel Responsive Gallery
A PHP library to create responsive galleries that are organized into Pinterest like columns.   
To generate the grid is used Bricklayer.js.
To open the image in a popup is used Fancybox 3.

The library replace all the occurrences of this snippet
```
{# gallery src=[holiday_images/london] width=[400] height=[300] #}
```
With the HTML code of a responsive gallery.
```html
<div class='responsiveGallery bricklayer' id='my-bricklayer'>
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
</div>
```


## Installation

To use the package you should import it trough composer.

```bash
composer require davide-casiraghi/laravel-responsive-gallery
```

Then install Bricklayer.js  and Fancybox 3
```bash
npm install bricklayer  
npm install @fancyapps/fancybox  
```




## Load the CSS and JS files

### With Laravel

#### Publish the JS, CSS and IMAGES
It's possible to customize the scss and the js publishing them in your Laravel application.  

```php artisan vendor:publish```

This command will publish in your application this folders:
- /resources/scss/vendor/laravel-responsive-gallery/
- /resources/js/vendor/laravel-responsive-gallery/
- /public/vendor/laravel-responsive-gallery/images/

In this way it's possible for you to customize them.

#### Load the JS file

In the **resources/js/app.js** file of your application require the **Bricklayer**, **Fancybox 3** and **responsiveGallery.js** files before the Vue object get instanciated:

```
require('./bootstrap');
window.Vue = require('vue');

window.Bricklayer = require('bricklayer');
require('./vendor/laravel-responsive-gallery/responsiveGallery');
import '@fancyapps/fancybox';

window.myApp = new Vue({  
    el: '#app'
});
```

In the **resources/sass/app.scss** file of your application import the scss
```
@import 'vendor/laravel-responsive-gallery/responsiveGallery';
```

Then you can run Laravel Mix
```
npm run dev
```

## Usage

Then to replace all the occurrance of the accordion snippets:

```php
$gallery = new ResponsiveGalleryFactory();

$body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br />
         {# gallery src=[holiday_images/london] width=[400] height=[300] #}
         <br /> Etiam aliquet orci tortor. ";

$publicPath = public_path("storage");
$body = $gallery->getGallery($body, $publicPath);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://github.com/davide-casiraghi/bootstrap-accordion-integrator/blob/master/LICENSE.md)
