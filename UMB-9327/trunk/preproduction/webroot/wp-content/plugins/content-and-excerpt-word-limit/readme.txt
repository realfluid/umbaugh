=== Content and Excerpt Word Limit ===
Contributors: c.bavota
Donate Link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=1929921
Tags: excerpt,content,word limit
Requires at least: 2.7
Tested up to: 2.8
Stable tag: 1.0

Allows users to limit the number or words that are displayed when they want the excerpt or content of a post to appear. 

== Description ==

Allows users to limit the number or words that are displayed when they want the excerpt or content of a post to appear. 

Instead of the&#95;excerpt() or the&#95;content(), use &lt;?php excerpt('word-limit'); ?&gt; or &lt;?php content('word-limit'); ?&gt; within your loop to limit the words for each.

Example: &lt;?php content('25'); ?&gt;.

== Installation ==

1. Unzip the excerpt-content-word-limit.zip file.
2. Upload the `excerpt-content-word-limit` folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the 'Plugins' menu in WordPress.
4. Go to Settings=>Content and Excerpt Word Limit and customize your endings and read more link.
5. Place one the following codes in your theme within the loop:
 	&lt;?php excerpt('word-limit'); ?&gt; or &lt;?php content('word-limit'); ?&gt;

== Frequently Asked Questions == 

1) Why did you create this plugin?

I needed to find a way to limit the amount of words displayed when I called the post's excerpt. WordPress doesn't have this function so I had to create my own plugin.

== Screenshots ==

1. Content and Excerpt Word Limit admin screen

== Change Log ==

1.0 (2009-02-16)
Initial Public Release
