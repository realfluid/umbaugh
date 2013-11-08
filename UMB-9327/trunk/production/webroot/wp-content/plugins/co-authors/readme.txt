=== Co-Authors ===
Contributors: gilzow, westonruter
Tags: authors, users
Tested up to: 2.6.2
Requires at least: 2.3
Stable tag: trunk

Allows multiple authors to be assigned to a post. Co-authored posts appear on a co-author's posts page and feed. New template tags list co-authors. Editors may assign co-authors via the 'Post Author(s)' box.

== Description ==

*Notice: This plugin is not being actively maintained. Other priorities have arisen which have forced development to discontinue. Being open source and free, you are of course free to take the code and improve upon it; if you are a developer and would like to be added as a commiter to this plugin, please [contact me](http://weston.ruter.net/contact/).*

Allows multiple authors to be associated with a post. Co-authored posts appear on a co-author's posts page and feed.
Additionally, co-authors may edit the posts they are associated with,
and co-authors who are contributors may only edit posts if they have not been published (as is usual).
Editors may easily add co-authors via the 'Post Author(s)' or 'Page Author(s)' boxes on the post/page writing page (see screenshots).
New template tags enable listing of co-authors:

*   <code>coauthors()</code>
*   <code>coauthors_posts_links()</code>
*   <code>coauthors_firstnames()</code>
*   <code>coauthors_lastnames()</code>
*   <code>coauthors_nicknames()</code>
*   <code>coauthors_links()</code>
*   <code>coauthors_IDs()</code>

These template tags correspond to their "<code>the_author*</code>" equivalents; take special note of the pluralization.
Each of these template tags accept four optional arguments:

1.   <code>between</code>: default ", "
1.   <code>betweenLast</code>: default " and "
1.   <code>before</code>: default ""
1.   <code>after</code>: default ""

To use them, simply modify the code surrounding all instances of <code>the_author*()</code> to something like as follows:

    if(function_exists('coauthors_posts_links'))
        coauthors_posts_links();
    else
        the_author_posts_link();

The result of this would be formatted like "John Smith, Jane Doe and Joe Public".

Note that as of this writing, WordPress does provide a means of extending <code>wp_list_authors()</code>, so
included in this plugin is the function <code>coauthors_wp_list_authors()</code> modified
to take into account co-authored posts; the same arguments are accepted.

Sometimes you may need fine-graned control over the display of a posts's authors, and in this case you may use
the <code>CoAuthorsIterator</code> class. This class may be instantiated anywhere you may place <code>the_author()</code>
or everywhere if the post ID is provided to the constructor. The instantiated class has the following methods:

1.   <code>iterate()</code>: advances <code>$authordata</code> to the next co-author; returns <code>false</code> and restores the original <code>$authordata</code> if there are no more authors to iterate. 
1.   <code>get_position()</code>: returns the zero-based index of the current author; returns -1 if the iterator is invalid
1.   <code>is_last()</code>: returns <code>true</code> if the current author is the last
1.   <code>is_first()</code>: returns <code>true</code> if the current author is the first
1.   <code>count()</code>: returns the total number of authors
1.   <code>get_all()</code>: returns an array of all of the authors' user data


For example:

    $i = new CoAuthorsIterator();
    print $i->count() == 1 ? 'Author: ' : 'Authors: ';
    $i->iterate();
    the_author();
    while($i->iterate()){
    	print $i->is_last() ? ' and ' : ', ';
    	the_author();
    }

When a user is deleted from WordPress, they will be removed from all of posts for which they are co-authors, and if a replacement user is provided, their co-authored posts will
instead be co-attributed to another user.

Inspired by 'Multiple Authors' plugin by Mark Jaquith (2005).

If you value this plugin, *please donate* to ensure that it may continue to be maintained and improved.

= Changelog =

*2009-07-02: 1.0 (beta 6)*

* Fixed trivial jQuery selector error (thanks bshoff).

*2008-09-29: 1.0 (beta 5)*

* Fixed error which occures when a user is deleted.

*2008-09-29: 1.0 (beta 4)*

* When deleting a user: disabled the logic behind trying to change `_coauthor` post meta to a selected replacement user. This was causing big problems in 2.6 (probably related to post revision functionality).

*2008-09-29: 1.0 (beta 3)*

* Making multiple authors assignable in the page admin UI as well.

*2008-06-16: 1.0 (beta 2)*

* Removed requirement to deactivate/activate newest version.

*2008-06-16: 1.0 (beta)*

* Finally, anyone who is associated as a co-author may edit a post.
* Changed postmeta key from "coauthor" to "_coauthor".

*2008-06-15: 0.8.3*

* Added support for WordPress 2.5.1

*2008-01-06: 0.8.2*

* Added support for localization. Localization files should be placed in the "localization" subdirectory under the plugin directory.

*2008-01-06: 0.8.1*

* When working with a page, the author box now says "Page Author(s)" instead of "Post Author(s)".
* Fixed trivial JavaScript error raised when working with a post or page that doesn't have any post meta.

*2007-12-30: 0.8*

* Initial release.

== Screenshots ==
1.  "Post Author(s)" box with one author
2.  "Post Author(s)" box with multiple authors
