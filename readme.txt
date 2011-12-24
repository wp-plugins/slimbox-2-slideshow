=== Slimbox2 with Slideshow ===
Contributors: thydzik
Homepage link: http://thydzik.com/category/slimbox2-slideshow/
Tags: Slimbox2, jQuery, Lightbox, Slideshow, auto, resize
Requires at least: 2.8
Tested up to: 3.3
Stable tag: 1.2.2
Donate link: http://thydzik.com/category/slimbox2-slideshow/

Slimbox2 Slideshow is a WordPress plugin used to display Lightbox effects on images.

== Description ==


*Slimbox2 Slideshow* is a WordPress plugin used to display Lightbox effects on images. It supports image resizing to fit images in the browser window and automatic slideshow. With advantages over other existing Lightbox plugins being;

   1. Slideshow can show entire WordPress images from multiple posts.
   1. Automatically resizes images to fit in browser window.
   1. Support for WordPress galleries with captions and Image Maps.
   1. No need to modify exisiting image html, and can directly substitute existing plugins that use rel="lightbox".
   1. Uses jQuery library, which means faster initial load.

See the real advantage of Slimbox 2 Slideshow navigate to
[sonyaandtravis.com/#slide](http://sonyaandtravis.com/#slide)
   
[Official  Homepage](http://thydzik.com/category/slimbox2-slideshow/) (with lots of examples)

== Installation ==

1. Upload folder 'thydzik-slimbox2-slideshow' to the  '/wp-content/plugins/' directory.
1. Activate the plugin through the 'Plugins' menu in WordPress.
1. Under 'Plugins' > 'Slimbox2 Slideshow', you will find the 'Slimbox2 Slideshow Options' page. Various options can be set here.

**Use**

*Automatic Image Link Tagging:*

enabled - no need to do anything, images will automatically be shown in a Lightbox when clicked.
disabled (advanced) - rel='lightbox' attribute will need to be manually added to the image 'a' element after the 'href' attribute.

Add a 'title' attribute after the 'href' attribute to show a caption on the image i.e. title="this is a caption"

*Slideshow of **all** blog images:*

Simply create a link to url "#slideshow" (or even just "#slide"), i.e. href="#slide". On click a full slideshow of all your images will start.
[Example here](sonyaandtravis.com/#slideshow).

== Screenshots ==

1. Slimbox2 Slideshow Options
1. Example Slimbox effect
1. Example of a link to enable slideshow of all images

== Frequently Asked Questions ==

= Slimbox2 Slideshow is not working or experiencing problems? =

Post a comment on the [Slimbox2 Slideshow homepage](http://thydzik.com/category/slimbox2-slideshow/) and be sure to accurately describe the problem and please include a link to your post with the Slimbox2 Slideshow problem.

= I have feedback or comments how do I contact the developer? =

Comments and feedback is welcome, Post a comment on the [Slimbox2 Slideshow homepage](http://thydzik.com/category/slimbox2-slideshow/).

== Changelog ==
= 1.2 =
* Added support for WordPress Gallery Captions
* Added option to enable for mobile devices
* Improved rel=lightbox tagging

= 1.1 =
* Added support for WordPress Gallery

= 1.0.4 =
* images.xml was being deleted and not regenerated on plugin upgrade
* Resolved minor CSS issue

= 1.0.3 =
* Changed CSS references to unique names to minimise incompatibilities with other Slimbox plugins

= 1.0.2 =
* Resolved error when writing to images.xml in plugin directory

= 1.0.1 =
* Resolved invlaid html with Image Maps

= 1.0 =
* Initial Release


== Upgrade Notice ==
= 1.2 =
* Upgrade through WordPress Admin page

= 1.1 =
* Upgrade through WordPress Admin page

= 1.0.4 =
* Upgrade through WordPress Admin page

= 1.0.3 =
* Upgrade through WordPress Admin page

= 1.0.2 =
* Upgrade through WordPress Admin page

= 1.0.1 =
* Upgrade through WordPress Admin page

= 1.0 =
* Initial Release
