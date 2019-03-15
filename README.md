# Laravel Responsive Gallery
A PHP library to create responsive galleries that are organized into Pinterest like columns. 
To generate the grid is used Bricklayer.js.

[![Latest Stable Version](https://img.shields.io/packagist/v/davide-casiraghi/laravel-responsive-gallery.svg?style=flat-square)](https://packagist.org/packages/davide-casiraghi/laravel-responsive-gallery)
<a href="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery"><img src="https://travis-ci.org/davide-casiraghi/laravel-responsive-gallery.svg" alt="Build Status"></a>
[![StyleCI](https://styleci.io/repos/175794655/shield?style=flat-square)](https://styleci.io/repos/175794655)


The library replace all the occurrences of this snippet
```
{# gallery src=[holiday_images/london] width=[400] height=[300] #}
```
With the HTML code of a responsive gallery.
```html
example code here
```


## Installation

To use the package you should import it trough composer.

```bash
composer require davide-casiraghi/laravel-responsive-gallery
```

Then install Bricklayer.js  
```bash
npm install bricklayer --save
```
https://github.com/ademilter/bricklayer/wiki/Quick-Start#1-install-bricklayer



## Load the CSS and JS files

### With Laravel

#### Publish the JS, CSS and IMAGES
It's possible to customize the scss and the js publishing them in your Laravel application.  

```php artisan vendor:publish```

This command will publish in your application this folders:
- /resources/scss/vendor/laravel-responsive-gallery/
- /resources/js/vendor/laravel-responsive-gallery/
- /public/vendor/laravel-responsive-gallery/images/

#### Load the JS file
In your app.js file you can require the bricklayer and responsiveGallery.js files before the Vue object get instanciated:

```
require('./bootstrap');
window.Vue = require('vue');

window.Bricklayer = require('bricklayer');
require('./vendor/laravel-responsive-gallery/responsiveGallery');

window.myApp = new Vue({  
    el: '#app'
});
```


## Usage

Import from the vendor folder of the package the SCSS and the JS.

Then to replace all the occurrance of the accordion snippets:

```php
$gallery = new ResponsiveGalleryFactory();
$body = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. <br />
{# gallery src=[holiday_images/london] width=[400] height=[300] #}
<br /> Etiam aliquet orci tortor. ";
$body = $accordion->replace_accordion_strings_with_template($body);
```

## Contributing
Pull requests are welcome. For major changes, please open an issue first to discuss what you would like to change.

Please make sure to update tests as appropriate.

## License
[MIT](https://github.com/davide-casiraghi/bootstrap-accordion-integrator/blob/master/LICENSE.md)
