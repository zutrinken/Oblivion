# Oblivion

Yet another wordpress theme.

* Author: [Peter Amende](http://zutrinken.com/)
* License: GNU General Public License v2 or later

## Screenshot

![preview](screenshot.png)

## Credits

Font **PoliticsHeadBold** by [Fred Bordfeld](http://kaklotter.de/)  
Font **Awesome** by [Dave Gandy](https://github.com/FortAwesome/Font-Awesome)  
Script **Highlight.js** by [Ivan Sagalaev](https://github.com/isagalaev/highlight.js)  
Script **FitVids** by [Dave Rupert](https://github.com/davatron5000/FitVids.js)  

## How to

* Required Wordpress 3.5 or higher
* For blurred background images in single and page posts your server needs a "bundled Version" of the PHP DG Library
* Featured images must be at least 560px wide and 480px high
* Regenerate your images with the [Regenerate Thumbnails](http://wordpress.org/plugins/regenerate-thumbnails/) Plugin
* Set a logo-icon and a full logo in the theme options
* Display videos like post images by using the custom field ```video``` with your embedded ```<iframe>``` code
* Use shortcodes to format your pages width columns

## Shortcodes

### Buttons

A default button is rectangled, gray and has a normal size. It only contains an attribute for your url and can be extended by the following attributes:

| Attribute | Shortcode |
| --- | --- |
| Default | ````[button link="http://yourdomain.com"]Text[/button]```` |
| Rounded | ````[button link="http://yourdomain.com" form="round"]Text[/button]```` |
| Colour | ````[button link="http://yourdomain.com" color="blue"]Text[/button]````<br />"orange, blue, red, green" |
| Size | ````[button link="http://yourdomain.com" size="large"]Text[/button]````<br />"xsmall, small, large, xlarge" |
