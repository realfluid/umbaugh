=== Plugin Name ===
Contributors: Steph
Donate link: http://www.amazon.de/exec/obidos/wishlist/3ZN17IJ7B1XW/
Tags: print, printing, style, stylesheet, css, typography
Requires at least: 2.0 (?)
Tested up to: 2.3.2
Stable tag: trunk

Inserts a link for a print stylesheet into your theme header. Provides a very simple print.css file that you probably want to improve upon, but which should do most of the job if you're using a Sandbox-based theme.

== Description ==

The plugin contains two files. `print-css.php`, which is the plugin file itself, and `print.css`, a sample print stylesheet.

A link to the print stylesheet will be placed in your theme's header, providing it uses the `wp_head()` function/hook.

An admin panel is added to the Presentations menu and it will allow you to edit the stylesheet if you make print.css writeable.

You probably want to edit the stylesheet provided to your liking, though it will hopefully do most of the job if your theme is sandbox-based.

I'm happy to include any improvements to the print stylesheet.

The print stylesheet will be used to print your blog pages, instead of the normal screen stylesheet.

== Installation ==

1. Upload `print-css` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. If you want, make the `print.css` file which is in the plugin directory writeable (chmod 777 for example) so that you can edit it through the Print CSS admin panel.

== Frequently Asked Questions ==

= Your print stylesheet sucks, don't you have a better one? =

This is a basic one that worked on the site for which I developed this plugin. Feel free to improve upon it.

= Why would I want a print stylesheet? =

When you print a web page, you probably don't want the navigation, background images, sidebars and things like that to be printed. The print stylesheet controls the display of the page when it is printed, just like a normal stylesheet controls the display of the page on the screen.

== Screenshots ==

== Future Development ==

I'd love to be able to include a complete and rich print stylesheet. One that deals well with most major themes, and which actually does take some care to get the typography right. Get in touch if you feel you can help.

