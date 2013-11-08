<?php
/*
Plugin Name: Author Category
Plugin URI: http://en.bainternet.info
Description: simple plugin limit authors to post just in one category.
Version: 0.3
Author: Bainternet
Author URI: http://en.bainternet.info
*/
/*
        *   Copyright (C) 2012  Ohad Raz
        *   http://en.bainternet.info
        *   admin@bainternet.info

        This program is free software; you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation; either version 2 of the License, or
        (at your option) any later version.

        This program is distributed in the hope that it will be useful,
        but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.

        You should have received a copy of the GNU General Public License
        along with this program; if not, write to the Free Software
        Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

/* Disallow direct access to the plugin file */
if (basename($_SERVER['PHP_SELF']) == basename (__FILE__)) {
    die('Sorry, but you cannot access this page directly.');
}

if (!class_exists('author_category')){
    class author_category{

        /**
         * class constractor
         * @author Ohad Raz
         * @since 0.1
         */
        public function __construct(){
            add_action( 'add_meta_boxes', array( &$this, 'add_meta_box' ) );
            // save user field
            add_action( 'personal_options_update', array( &$this,'save_extra_user_profile_fields' ));
            add_action( 'edit_user_profile_update', array( &$this,'save_extra_user_profile_fields' ));
            // add user field
            add_action( 'show_user_profile', array( &$this,'extra_user_profile_fields' ));
            add_action( 'edit_user_profile', array( &$this,'extra_user_profile_fields' ));

            //xmlrpc post insert hook and quickpress
            add_filter('xmlrpc_wp_insert_post_data', array(&$this, 'user_default_category'),2);
            add_filter('pre_option_default_category',array(&$this, 'user_default_category_option'));
            //plugin links row
            add_filter( 'plugin_row_meta', array($this,'_my_plugin_links'), 10, 2 );
            //remove quick and bulk edit
            global $pagenow;
            if (is_admin() && 'edit.php' == $pagenow)
                add_action('admin_print_styles',array(&$this,'remove_quick_edit'));

        }

        /**
         * user_default_category_option
         * 
         * function to overwrite the defult category option per user
         * 
         * @author Ohad   Raz
         * @since 0.3
         * 
         * @param  boolea $false 
         * @return mixed category id if user as a category set and false if he doesn't
         */
        public function user_default_category_option($false){
            $cat = $this->get_user_cat();
            if (!empty($cat) && $cat > 0){
                return $cat;
            }
            return false;
        }

        /**
         * user_default_category
         * 
         * function to handle XMLRPC calls
         * 
         * @author Ohad   Raz
         * @since 0.3
         * 
         * @param  array $post_data  post data
         * @param  array $con_stactu xmlrpc post data
         * @return array 
         */
        public function user_default_category($post_data,$con_stactu){
            $cat = $this->get_user_cat($post_data['post_author']);
            if (!empty($cat) && $cat > 0){
                $post_data['tax_input']['category'] = array($cat);
            }
            return $post_data;
        }

        /**
         * remove_quick_edit
         * @author Ohad   Raz
         * @since 0.1
         * @return void
         */
        public function remove_quick_edit(){
           global $current_user;
            get_currentuserinfo();
            $cat = $this->get_user_cat($current_user->ID);
            if (!empty($cat) && $cat > 0){
                echo '<style>.inline-edit-categories{display: none !important;}</style>';
            }
        }

        /**
         * Adds the meta box container
         * @author Ohad Raz
         * @since 0.1
         */
        public function add_meta_box(){

            global $current_user;
            get_currentuserinfo();

            //get author categories
            $cat = $this->get_user_cat($current_user->ID);
            if (!empty($cat) && $cat > 0){
                //remove default metabox
                remove_meta_box('categorydiv', 'post', 'side');
                add_meta_box( 
                     'author_cat'
                    ,__( 'author category','author_cat' )
                    ,array( &$this, 'render_meta_box_content' )
                    ,'post' 
                    ,'side'
                    ,'low'
                );
            }
        }


        /**
         * Render Meta Box content
         * @author Ohad   Raz
         * @since 0.1
         * @return Void
         */
        public function render_meta_box_content(){
            global $current_user;
            get_currentuserinfo();
            $cat = get_user_meta($current_user->ID,'_author_cat',true);
            // Use nonce for verification
            wp_nonce_field( plugin_basename( __FILE__ ), 'author_cat_noncename' );
            if (!empty($cat) && $cat > 0){
                $c = get_category($cat);
                echo __('this will be posted in: <strong>','author_cat') . $c->name .__('</strong> Category');
                echo '<input name="post_category[]" type="hidden" value="'.$c->term_id.'">';
            }
        }

        /**
         * This will generate the category field on the users profile
         * @author Ohad   Raz
         * @since 0.1
         * @param  (object) $user 
         * @return void
         */
         public function extra_user_profile_fields( $user ){ 
            //only admin can see and save the categories
            if ( !current_user_can( 'manage_options' ) ) { return false; }
            global $current_user;
            get_currentuserinfo();
            if ($current_user->ID == $user->ID) { return false; }
            echo '<h3>'.__('Author Category', 'author_cat').'</h3>
            <table class="form-table">
                <tr>
                    <th><label for="author_cat">'.__('Category').'</label></th>
                    <td>
                        '.wp_dropdown_categories(array(
                            'show_count' => 0,
                            'hierarchical' => 1,
                            'hide_empty' => 0,
                            'echo' => 0,
                            'name' => 'author_cat',
                            'selected' => get_user_meta($user->ID, '_author_cat', true ))).'
                        <br />
                    <span class="description">'.__('select a category to limit an author to post just in that category.','author_cat').'</span>
                    </td>
                </tr>
            </table>';
        }


        /**
         * This will save category field on the users profile
         * @author Ohad   Raz
         * @since 0.1
         * @param  (int) $user_id 
         * @return VOID
         */
        public function save_extra_user_profile_fields( $user_id ) {
            //only admin can see and save the categories
            if ( !current_user_can( 'manage_options') ) { return false; }

            update_user_meta( $user_id, '_author_cat', intval($_POST['author_cat']) );
        }

        /**
         * save category on post 
         * @author Ohad   Raz
         * @since 0.1
         * @deprecated 0.3
         * @param  (int) $post_id 
         * @return Void
         */
        public function author_cat_save_meta( $post_id ) {
        }

        public function get_user_cat($user_id = null){
            if ($user_id === null){
                global $current_user;
                get_currentuserinfo();
                $user_id = $current_user->ID;
            }
            $cat = get_user_meta($user_id,'_author_cat',true);
            if (empty($cat))
                return 0;
            else
                return $cat;

        }

        /**
         * _my_plugin_links 
         * 
         * adds links to plugin row 
         * 
         * @author Ohad Raz <admin@bainternet.info>
         * @since 0.3
         * 
         * @param  array $links 
         * @param  string $file
         * @return array
         */
        public function _my_plugin_links($links, $file) { 
            $plugin = plugin_basename(__FILE__);  
            if ($file == $plugin) // only for this plugin 
                return array_merge( $links, 
                    array( '<a href="http://en.bainternet.info/category/plugins">' . __('Other Plugins by this author' ) . '</a>' ), 
                    array( '<a href="http://wordpress.org/support/plugin/author-category">' . __('Plugin Support') . '</a>' ), 
                    array( '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=K4MMGF5X3TM5L" target="_blank">' . __('Donate') . '</a>' ) 
                ); 
            return $links;
        }

    }//end class
}
//initiate the class on admin pages only
if (is_admin()){
    $ac = new author_category();
}