<?php
/*
Plugin Name: Connections
Plugin URI: http://connections-pro.com/
Description: A business directory and address book manager.
Version: 0.7.1.3
Author: Steven A. Zahm
Author URI: http://connections-pro.com/

Connections is based on Little Black Book  1.1.2 by Gerald S. Fuller
Little Black Book is based on Addressbook 0.7 by Sam Wilson

Update Notice in plugin admin inspired by Changelogger 1.2.8 by Oliver Schlöbe

	Copyright 2009  Steven A. Zahm  (email : shazahm1@hotmail.com)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA

*/

/**
 * @TODO: Add support for SSL using the CN_PLUGIN_URL constant throughout.
 */


if (!class_exists('connectionsLoad'))
{
	class connectionsLoad
	{
		public $currentUser;
		public $options;
		public $retrieve;
		public $term;
		
		/**
		 * Holds the string values returned from the add_menu_page & add_submenu_page functions
		 * @var object
		 */
		public $pageHook;
		
		public $errorMessages;
		public $successMessages;
		
		public function __construct()
		{
			$this->loadConstants();
			$this->loadDependencies();
			$this->initDependencies();
			
			if ( is_admin() )
			{
				// Initiate admin messages.
				$this->initErrorMessages();
				$this->initSuccessMessages();
				
				// Calls the method to load the admin menus.
				add_action('admin_menu', array (&$this, 'loadAdminMenus'));
				
				// Activation/Deactivation hooks
				register_activation_hook( dirname(__FILE__) . '/connections.php', array(&$this, 'activate') );
				register_deactivation_hook( dirname(__FILE__) . '/connections.php', array(&$this, 'deactivate') );
			}
			
			//@TODO: Create uninstall method to remove options and tables.
			// register_uninstall_hook( dirname(__FILE__) . '/connections.php', array('connectionsLoad', 'uninstall') );
			
			// Start this plug-in once all other plugins are fully loaded
			add_action( 'plugins_loaded', array(&$this, 'start') );
		}
		
		public function start()
		{
			global $wpdb, $connections, $current_user;
		
			get_currentuserinfo();
			$connections->currentUser->setID($current_user->ID);
			
			if ( is_admin() )
			{
				// Calls the methods to load the admin scripts and CSS.
				add_action('admin_print_scripts', array(&$this, 'loadAdminScripts') );
				add_action('admin_print_styles', array(&$this, 'loadAdminStyles') );
				
				// Add Settings link to the plugin actions
				add_action('plugin_action_links_' . plugin_basename(__FILE__), array(&$this, 'addActionLinks'));
				
				// Add FAQ, Support and Donate links
				add_filter('plugin_row_meta', array(&$this, 'addMetaLinks'), 10, 2);
				
				// Add the Add Entry item to the favorites dropdown.
				add_filter('favorite_actions', array(&$this, 'addEntryFavorite') );
				
				// Process any action done in the admin.
				$this->controllers();
				
				// Add Changelog table row in the Manage Plugins admin page.
				add_action('after_plugin_row_' . plugin_basename(__FILE__), array(&$this, 'displayUpgradeNotice'), 1, 0);
				// Maybe should use this action hook instead: in_plugin_update_message-{$file}
			}
			else
			{
				// Register all valid query variables.
				add_filter('query_vars', array(&$this, 'registerQueryVariables') );
				
				// Calls the methods to load the frontend scripts and CSS.
				add_action('wp_print_scripts', array(&$this, 'loadScripts') );
				add_action('wp_print_styles', array(&$this, 'loadStyles') );
				
				// Add a version number to the header
				add_action('wp_head', create_function('', 'echo "\n<meta name=\'Connections\' content=\'' . $this->options->getVersion() . '\' />\n";') );
				
				// Parse front end queryies.
				//add_action('parse_request', '');
			}
		}
		
		private function loadConstants()
		{
			global $wpdb;
			
			define('CN_CURRENT_VERSION', '0.7.1.3');
			define('CN_DB_VERSION', '0.1.4');
			define('CN_IMAGE_PATH', WP_CONTENT_DIR . '/connection_images/');
			define('CN_IMAGE_BASE_URL', WP_CONTENT_URL . '/connection_images/');
			define('CN_ENTRY_TABLE', $wpdb->prefix . 'connections');
			define('CN_TERMS_TABLE', $wpdb->prefix . 'connections_terms');
			define('CN_TERM_TAXONOMY_TABLE', $wpdb->prefix . 'connections_term_taxonomy');
			define('CN_TERM_RELATIONSHIP_TABLE', $wpdb->prefix . 'connections_term_relationships');
			define('CN_BASE_NAME', plugin_basename( dirname(__FILE__)) );
			define('CN_BASE_PATH', WP_PLUGIN_DIR . '/' . CN_BASE_NAME);
			define('CN_BASE_URL', WP_PLUGIN_URL . '/' . CN_BASE_NAME);
			define('CN_TEMPLATE_PATH', CN_BASE_PATH . '/templates');
			define('CN_TEMPLATE_URL', CN_BASE_URL . '/templates');
			define('CN_CUSTOM_TEMPLATE_PATH', WP_CONTENT_DIR . '/connections_templates');
			define('CN_CUSTOM_TEMPLATE_URL', WP_CONTENT_URL . '/connections_templates');
			
			$siteURL = get_option('siteurl');
			if(is_ssl())
			{
				$siteURL = str_replace("http://", "https://", $siteURL);
			}
			
			/**
			 * Defines the URL to the plugin folder setting.
			 * @author: Ben Klocek
			 */
			define('CN_PLUGIN_URL', $siteURL.'/wp-content/plugins/' . CN_BASE_NAME);
		}
		
		private function loadDependencies()
		{
			/**
			 * @TODO: Load dependencies as needed. For example load only classes
			 * needed in the admin and frontend
			 */
			//Current User objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.user.php'); // Required for activation
			//Terms Objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.terms.php'); // Required for activation
			//Category Objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.category.php'); // Required for activation, entry list
			//Retrieve objects from the db.
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.retrieve.php'); // Required for activation
			//HTML FORM objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.form.php'); // Required for activation
			//date objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.date.php'); // Required for activation, entry list, add entry
			//entry objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.entry.php'); // Required for activation, entry list
			//plugin option objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.options.php'); // Required for activation
			//plugin utility objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.utility.php'); // Required for activation, entry list
			//plugin template objects
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.output.php'); // Required for activation, entry list
			//builds vCard
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.vcard.php'); // Required for front end
			
			//shortcodes
			require_once(WP_PLUGIN_DIR . '/connections/includes/inc.shortcodes.php'); // Required for front end
			
			//templates
			require_once(WP_PLUGIN_DIR . '/connections/includes/class.template.php'); // Required for the front end template processing
		}
		
		private function initDependencies()
		{
			$this->options = new cnOptions();
			$this->currentUser = new cnUser();
			$this->retrieve = new cnRetrieve();
			$this->term = new cnTerms();
		}
		
		/**
		 * During install this will initiate the options.
		 */
		private function initOptions()
		{
			if ($this->options->getAllowPublic() === NULL) $this->options->setAllowPublic(TRUE);
			if ($this->options->getAllowPublicOverride() === NULL) $this->options->setAllowPublicOverride(FALSE);
			
			if ($this->options->getAllowPrivateOverride() === NULL) $this->options->setAllowPrivateOverride(FALSE);
			
			if ($this->options->getImgThumbQuality() === NULL) $this->options->setImgThumbQuality(80);
			if ($this->options->getImgThumbX() === NULL) $this->options->setImgThumbX(80);
			if ($this->options->getImgThumbY() === NULL) $this->options->setImgThumbY(54);
			if ($this->options->getImgThumbCrop() === NULL) $this->options->setImgThumbCrop('crop');
			
			if ($this->options->getImgEntryQuality() === NULL) $this->options->setImgEntryQuality(80);
			if ($this->options->getImgEntryX() === NULL) $this->options->setImgEntryX(225);
			if ($this->options->getImgEntryY() === NULL) $this->options->setImgEntryY(150);
			if ($this->options->getImgEntryCrop() === NULL) $this->options->setImgEntryCrop('crop');
			
			if ($this->options->getImgProfileQuality() === NULL) $this->options->setImgProfileQuality(80);
			if ($this->options->getImgProfileX() === NULL) $this->options->setImgProfileX(300);
			if ($this->options->getImgProfileY() === NULL) $this->options->setImgProfileY(225);
			if ($this->options->getImgProfileCrop() === NULL) $this->options->setImgProfileCrop('crop');
			
			if ($this->options->getImgLogoQuality() === NULL) $this->options->setImgLogoQuality(80);
			if ($this->options->getImgLogoX() === NULL) $this->options->setImgLogoX(225);
			if ($this->options->getImgLogoY() === NULL) $this->options->setImgLogoY(150);
			if ($this->options->getImgLogoCrop() === NULL) $this->options->setImgLogoCrop('crop');
			
			if ($this->options->getDefaultTemplatesSet() === NULL) $this->options->setDefaultTemplates();
			
			$this->options->setDefaultCapabilities();
			
			if ( $this->options->getVersion() === NULL ) $this->options->setVersion(CN_CURRENT_VERSION);
			if ( $this->options->getDBVersion() === NULL ) $this->options->setDBVersion(CN_DB_VERSION);
			
			
			$this->options->saveOptions();
		}
		
		public function registerQueryVariables($query)
		{
			$query[] = 'cncatid';
			return $query;
		}
		
		public function displayMessages()
		{
			// Exit the method if $_GET['display_messages'] isn't set.
			if ( !isset($_GET['display_messages']) ) return;
			
			global $connections;
			$output = NULL;
			
			$messages = $connections->currentUser->getMessages();
			
			if ( !empty($messages) )
			{
				foreach ($messages as $message)
				{
					foreach($message as $type => $code)
					{
						switch ($type)
						{
							case 'error':
								$output .= '<div id="message" class="error"><p><strong>ERROR: </strong>' . $this->errorMessages->get_error_message($code) . '</p></div>';
							break;
							
							case 'success':
								$output .= '<div id="message" class="updated fade"><p><strong>SUCCESS: </strong>' . $this->successMessages->get_error_message($code) . '</p></div>';
							break;
						}
					}
				}
			}
			
			if ($_GET['display_messages'] === 'true') $connections->currentUser->resetMessages();
			
			echo $output;
		}
		
		/**
		 * Initiate the error messages for Connections using the WP_Error class.
		 */
		private function initErrorMessages()
		{
			$this->errorMessages = new WP_Error();
			
			$this->errorMessages->add('session_path_does_not_exist', 'The $_SESSION save path does not exist.');
			$this->errorMessages->add('session_path_not_writable', 'The $_SESSION save path is not writable.');
			
			$this->errorMessages->add('form_token_mismatch', 'Token mismatch.');
			$this->errorMessages->add('form_no_entry_id', 'No entry ID.');
			$this->errorMessages->add('form_no_entry_token', 'No entry token.');
			$this->errorMessages->add('form_no_session_token', 'No session token.');
			$this->errorMessages->add('form_no_token', 'No form token.');
			
			$this->errorMessages->add('capability_view_entry_list', 'You are not authorized to view the entry list. Please contact the admin if you received this message in error.');
			
			$this->errorMessages->add('capability_add', 'You are not authorized to add entries. Please contact the admin if you received this message in error.');
			$this->errorMessages->add('capability_delete', 'You are not authorized to delete entries. Please contact the admin if you received this message in error.');
			$this->errorMessages->add('capability_edit', 'You are not authorized to edit entries. Please contact the admin if you received this message in error.');
			$this->errorMessages->add('capability_categories', 'You are not authorized to edit the categories. Please contact the admin if you received this message in error.');
			$this->errorMessages->add('capability_settings', 'You are not authorized to edit the settings. Please contact the admin if you received this message in error.');
			$this->errorMessages->add('capability_roles', 'You are not authorized to edit role capabilities. Please contact the admin if you received this message in error.');
			
			$this->errorMessages->add('category_duplicate_name', 'The category you are trying to create already exists.');
			$this->errorMessages->add('category_self_parent', 'Category can not be a parent of itself.');
			$this->errorMessages->add('category_delete_uncategorized', 'The Uncategorized category can not be deleted.');
			$this->errorMessages->add('category_update_uncategorized', 'The Uncategorized category can not be altered.');
			$this->errorMessages->add('category_add_uncategorized', 'The Uncategorized category already exists.');
			$this->errorMessages->add('category_add_failed', 'Failed to add category.');
			$this->errorMessages->add('category_update_failed', 'Failed to update category.');
			$this->errorMessages->add('category_delete_failed', 'Failed to delete category.');
			
			$this->errorMessages->add('entry_added_failed', 'Entry could not be added.');
			$this->errorMessages->add('entry_updated_failed', 'Entry could not be updated.');
			
			$this->errorMessages->add('image_upload_failed', 'Image upload failed.');
			$this->errorMessages->add('image_uploaded_failed', 'Uploaded image could not be saved to the destination folder.');
			$this->errorMessages->add('image_profile_failed', 'Profile image could not be created and/or saved to the destination folder.');
			$this->errorMessages->add('image_entry_failed', 'Entry image could not be created and/or saved to the destination folder.');
			$this->errorMessages->add('image_thumbnail_failed', 'Thumbnail image could not be created and/or saved to the destination folder.');
			
			$this->errorMessages->add('template_install_failed', 'The template installation has failed.');
			$this->errorMessages->add('template_delete_failed', 'The template could not be deleted.');
		}
		
		/**
		 * Returns one of the predefined Connections error messages.
		 * @return HTML div with error message.
		 * @param string
		 */
		public function getErrorMessage($errorMessage)
		{
			return '<div id="message" class="error"><p><strong>ERROR: </strong>' . $this->errorMessages->get_error_message($errorMessage) . '</p></div>';
		}
		
		/**
		 * Stores a predefined error messages in the user meta.
		 * @param string
		 */
		public function setErrorMessage($errorMessage)
		{
			global $connections;
			$messages = $connections->currentUser->getMessages();
			// If the success message is slready stored, no need to store it twice.
			if (!in_array(array('error' => $errorMessage), $messages))
			{
				$connections->currentUser->setMessage(array('error' => $errorMessage));
			}
		}
		
		/**
		 * Initiates the success messages for Connections using the WP_Error class.
		 */
		private function initSuccessMessages()
		{
			$this->successMessages = new WP_Error();
			
			$this->successMessages->add('form_entry_delete', 'The entry has been deleted.');
			$this->successMessages->add('form_entry_delete_bulk', 'Entry(ies) have been deleted.');
			$this->successMessages->add('form_entry_visibility_bulk', 'Entry(ies) visibility have been updated.');
			
			$this->successMessages->add('category_deleted', 'Category(ies) have been deleted.');
			$this->successMessages->add('category_updated', 'Category has been updated.');
			$this->successMessages->add('category_added', 'Category has been added.');
			
			$this->successMessages->add('entry_added', 'Entry has been added.');
			$this->successMessages->add('entry_updated', 'Entry has been updated.');
			
			$this->successMessages->add('image_uploaded', 'Uploaded image saved.');
			$this->successMessages->add('image_profile', 'Profile image created and saved.');
			$this->successMessages->add('image_entry', 'Entry image created and saved.');
			$this->successMessages->add('image_thumbnail', 'Thumbnail image created and saved.');
			
			$this->successMessages->add('settings_updated', 'Settings have been updated.');
			$this->successMessages->add('role_settings_updated', 'Role capabilities have been updated.');
			
			$this->successMessages->add('template_change_active', 'The default active template has been changed.');
			$this->successMessages->add('template_installed', 'A new template has been installed.');
			$this->successMessages->add('template_deleted', 'The template has been deleted.');
		}
		
		/**
		 * Returns one of the predefined Connections success messages.
		 * @return HTML div with error message.
		 * @param string
		 */
		public function getSuccessMessage($successMessage)
		{
			return '<div id="message" class="updated fade"><p><strong>SUCCESS: </strong>' . $this->successMessages->get_error_message($successMessage) . '</p></div>';
		}
		
		/**
		 * Stores a predefined success messages in the user meta.
		 * @param string
		 */
		public function setSuccessMessage($successMessage)
		{
			global $connections;
			
			$messages = $connections->currentUser->getMessages();
			// If the success message is slready stored, no need to store it twice.
			if (!in_array(array('success' => $successMessage), $messages))
			{
				$connections->currentUser->setMessage(array('success' => $successMessage));
			}
		}
						
		/**
		 * Called when activating Connections via the activation hook.
		 */
		public function activate()
		{
			global $wpdb, $connections;
			require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
			
			$charsetCollate = '';
			
			if ( ! empty($wpdb->charset) ) $charsetCollate = "DEFAULT CHARACTER SET $wpdb->charset";
			if ( ! empty($wpdb->collate) ) $charsetCollate .= " COLLATE $wpdb->collate";

			
			if ($wpdb->get_var("SHOW TABLES LIKE '" . CN_ENTRY_TABLE . "'") != CN_ENTRY_TABLE)
			{
				$entryTable = "CREATE TABLE " . CN_ENTRY_TABLE . " (
			        id bigint(20) NOT NULL AUTO_INCREMENT,
			        ts TIMESTAMP,
					date_added tinytext NOT NULL,
			        entry_type tinytext NOT NULL,
					visibility tinytext NOT NULL,
					family_name tinytext NOT NULL,
					honorific_prefix tinytext NOT NULL,
					first_name tinytext NOT NULL,
					middle_name tinytext NOT NULL,
			        last_name tinytext NOT NULL,
					honorific_suffix tinytext NOT NULL,
					title tinytext NOT NULL,
					organization tinytext NOT NULL,
					department tinytext NOT NULL,
					contact_first_name tinytext NOT NULL,
					contact_last_name tinytext NOT NULL,
					addresses longtext NOT NULL,
					phone_numbers longtext NOT NULL,
					email longtext NOT NULL,
					im longtext NOT NULL,
					social longtext NOT NULL,
					websites longtext NOT NULL,
					birthday tinytext NOT NULL,
					anniversary tinytext NOT NULL,
					bio longtext NOT NULL,
			        notes longtext NOT NULL,
					options longtext NOT NULL,
					added_by bigint(20) NOT NULL,
					edited_by bigint(20) NOT NULL,
					owner bigint(20) NOT NULL,
					status varchar(20) NOT NULL,
			        PRIMARY KEY  (id)
			    ) $charsetCollate;";
			    
			    dbDelta($entryTable);
			}
			
			if ($wpdb->get_var("SHOW TABLES LIKE '" . CN_TERMS_TABLE . "'") != CN_TERMS_TABLE)
			{
				$termsTable = "CREATE TABLE " . CN_TERMS_TABLE . " (
			        term_id bigint(20) NOT NULL AUTO_INCREMENT,
					name varchar(200) NOT NULL,
					slug varchar(200) NOT NULL,
					term_group bigint(10) NOT NULL,
			        PRIMARY KEY  (term_id),
					UNIQUE KEY slug (slug),
					INDEX name (name)
			    ) $charsetCollate;";
			    
			    dbDelta($termsTable);
			}
			
			if ($wpdb->get_var("SHOW TABLES LIKE '" . CN_TERM_TAXONOMY_TABLE . "'") != CN_TERM_TAXONOMY_TABLE)
			{
				$termTaxonomyTable = "CREATE TABLE " . CN_TERM_TAXONOMY_TABLE . " (
			        term_taxonomy_id bigint(20) NOT NULL AUTO_INCREMENT,
					term_id bigint(20) NOT NULL,
					taxonomy varchar(32) NOT NULL,
					description longtext NOT NULL,
					parent bigint(20) NOT NULL,
					count bigint(20) NOT NULL,
			        PRIMARY KEY  (term_taxonomy_id),
					UNIQUE KEY term_id_taxonomy (term_id, taxonomy),
					INDEX taxonomy (taxonomy)
			    ) $charsetCollate;";
			    
			    dbDelta($termTaxonomyTable);
			}
			
			if ($wpdb->get_var("SHOW TABLES LIKE '" . CN_TERM_RELATIONSHIP_TABLE . "'") != CN_TERM_RELATIONSHIP_TABLE)
			{
				$termTermRelationshipTable = "CREATE TABLE " . CN_TERM_RELATIONSHIP_TABLE . " (
			        entry_id bigint(20) NOT NULL,
					term_taxonomy_id bigint(20) NOT NULL,
					term_order int(11) NOT NULL,
			        PRIMARY KEY (entry_id,term_taxonomy_id),
					KEY term_taxonomy_id (term_taxonomy_id)
			    ) $charsetCollate;";
			    
			    dbDelta($termTermRelationshipTable);
			}
			
			
			// Check if the Uncategorized term exists and if it doesn't create it.
			$term = $connections->term->getTermBy('slug', 'uncategorized', 'category');
			
			if ( empty($term) )
			{
				$attributes['slug'] = '';
				$attributes['parent'] = 0;
				$attributes['description'] = 'Entries not assigned to a category will automatically be assigned to this category and deleting a category which has been assigned to an entry will reassign that entry to this category. This category can not be edited or deleted.';
				
				$connections->term->addTerm('Uncategorized', 'category', $attributes);
			}
			
			if (!file_exists(ABSPATH . 'download.vCard.php'))
			{
				copy(WP_PLUGIN_DIR . '/connections/includes/download.vCard.php', ABSPATH . 'download.vCard.php');
			}
			
			$this->initOptions();
			
			//update_option('connections_activated', 'The Connections plug-in version ' . $this->options->getVersion() . ' has been activated.');
		}
		
		/**
		 * Called when deactivating Connections via the deactivation hook.
		 */
		public function deactivate()
		{
			global $options;
			
			/* This should be occur in the unistall hook
			$this->options->removeDefaultCapabilities();
			*/
			
			//  DROP TABLE `cnpfresh_connections`, `cnpfresh_connections_terms`, `cnpfresh_connections_term_relationships`, `cnpfresh_connections_term_taxonomy`;
			//  DELETE FROM `nhonline_freshcnpro`.`cnpfresh_options` WHERE `cnpfresh_options`.`option_name` = 'connections_options'
		}
		
		/**
		 * Register the admin menus for Connections
		 */	
		public function loadAdminMenus()
		{
			global $connections;
			
			// If the Connections CSV plugin is activated load the object
			if ( class_exists('connectionsCSVLoad') ) global $connectionsCSV;
			
			// Register the top level menu item.
			$pageHook->topLevel = add_menu_page('Connections : Administration', 'Connections', 'connections_manage', CN_BASE_NAME, array (&$this, 'showPage'), WP_PLUGIN_URL . '/connections/images/menu.png');
			
			// Register the sub menu items.
			$pageHook->manage = add_submenu_page(CN_BASE_NAME, 'Connections : Manage', 'Manage', 'connections_manage', CN_BASE_NAME, array (&$this, 'showPage'));
			$pageHook->add = add_submenu_page(CN_BASE_NAME, 'Connections : Add Entry','Add Entry', 'connections_add_entry', 'connections&action=add_new', array (&$this, 'showPage'));
			$pageHook->categories = add_submenu_page(CN_BASE_NAME, 'Connections : Categories','Categories', 'connections_edit_categories', 'connections_categories', array (&$this, 'showPage'));
			
			// Show the Connections Import CSV menu item
			if ( isset($connectionsCSV) ) $pageHook->csv = add_submenu_page(CN_BASE_NAME, 'Connections : Import CSV','Import CSV', 'connections_add_entry', 'connections_csv', array ($connectionsCSV, 'showPage'));
			
			$pageHook->templates = add_submenu_page(CN_BASE_NAME, 'Connections : Templates','Templates', 'connections_manage_template', 'connections_templates', array (&$this, 'showPage'));
			$pageHook->settings = add_submenu_page(CN_BASE_NAME, 'Connections : Settings','Settings', 'connections_change_settings', 'connections_settings', array (&$this, 'showPage'));
			$pageHook->roles = add_submenu_page(CN_BASE_NAME, 'Connections : Roles &amp; Capabilites','Roles', 'connections_change_roles', 'connections_roles', array (&$this, 'showPage'));
			$pageHook->help = add_submenu_page(CN_BASE_NAME, 'Connections : Help','Help', 'connections_view_help', 'connections_help', array (&$this, 'showPage'));
			
			// Register the edit metaboxes.
			if ( isset($_GET['action']) && !empty($_GET['action']) ) add_action('load-' . $pageHook->manage, array(&$this, 'registerEditMetaboxes'));
			
			$connections->pageHook = $pageHook;
		}
		
		/**
		 * Register the metaboxes.
		 */
		public function registerEditMetaboxes()
		{
			$form = new cnFormObjects();
			$form->registerEditMetaboxes();
			
			add_filter('screen_layout_columns', array(&$this, 'screenLayout'), 10, 2);
		}
		
		public function screenLayout($columns, $screen)
		{
			$columns['toplevel_page_connections'] = 2;
			
			return $columns;
		}
		
		/**
		 * Loads the Connections javascripts only on required admin pages.
		 */
		public function loadAdminScripts()
		{
			// Exit the method if $_GET['page'] isn't set.
			if ( !isset($_GET['page']) ) return;
			
			$allPages = array( 'connections', 'connections_add', 'connections_categories', 'connections_settings', 'connections_templates', 'connections_roles', 'connections_csv', 'connections_help' );
			
			if ( in_array($_GET['page'], $allPages) )
			{
				wp_enqueue_script('load_ui_js', WP_PLUGIN_URL . '/connections/js/ui.js', array('jquery'), CN_CURRENT_VERSION, TRUE);
			}
			
			/*
			 * TinyMCE in WordPress Plugins
			 * http://www.keighl.com/2010/01/tinymce-in-wordpress-plugins/
			 * 
			 * Load the tinyMCE scripts on these pages.
			 */
			$editorPages = array( 'connections' );
			
			if ( in_array( $_GET['page'], $editorPages ) )
			{
				wp_tiny_mce( 	FALSE , // true makes the editor "teeny"
								array
								(
									'editor_selector' => 'tinymce',
									'theme_advanced_buttons1' => 'bold, italic, underline, |, bullist, numlist, |, justifyleft, justifycenter, justifyright, |, link, unlink, |, pastetext, pasteword, removeformat, |, undo, redo',
									'theme_advanced_buttons2' => '',
									'inline_styles' => TRUE,
								)
							);
			}
			
			// Load the core JavaScripts required for meta boxe UI.
			$metaBoxPages = array( 'connections' );
			
			if ( in_array( $_GET['page'], $metaBoxPages ) )
			{
				wp_enqueue_script('common');
				wp_enqueue_script('wp-lists');
				wp_enqueue_script('postbox');
			}
		}
		
		/**
		 * Loads the Connections javascripts on the WordPress frontend.
		 */
		public function loadScripts()
		{
			/*
			 * http://beerpla.net/2010/01/13/wordpress-plugin-development-how-to-include-css-and-javascript-conditionally-and-only-when-needed-by-the-posts/
			 * http://beerpla.net/2010/01/15/follow-up-to-loading-css-and-js-conditionally/
			 * http://scribu.net/wordpress/optimal-script-loading.html
			 */
			
			wp_enqueue_script('jquery');
			
			// Commented out for now because it's not needed.
			//wp_enqueue_script('thickbox');
			
			/**
			 * @TODO: Move this javascript to the templates directory.
			 */
			//wp_register_script('contactpreview', WP_PLUGIN_URL . '/connections/js/jquery.contactpreview.js', array('jquery'), CN_CURRENT_VERSION);
			//wp_enqueue_script( 'contactpreview' );
		}
		
		/**
		 * Loads the Connections CSS only on required admin pages.
		 */
		public function loadAdminStyles()
		{
			// Exit the method if $_GET['page'] isn't set.
			if ( !isset($_GET['page']) ) return;
			
			/*
			 * Load styles only on the Connections plug-in admin pages.
			 */
			switch ($_GET['page'])
			{
				case 'connections':
				case 'connections_add':
				case 'connections_categories':
				case 'connections_settings':
				case 'connections_templates':
				case 'connections_roles':
				case 'connections_csv':
				case 'connections_help':
					wp_enqueue_style('load_jwysiwyg_css', WP_PLUGIN_URL . '/connections/js/jwysiwyg/jwysiwyg/jquery.wysiwyg.css', array(), '0.6');
					wp_enqueue_style('load_admin_css', WP_PLUGIN_URL . '/connections/css-admin.css', array(), CN_CURRENT_VERSION);
				break;
			}
		}
		
		/**
		 * Loads the Connections CSS on the WordPress frontend.
		 */
		public function loadStyles()
		{
			/**
			 * @TODO: Move this CSS to the templates directory.
			 */
			//wp_register_style('member_template_styles', WP_PLUGIN_URL . '/connections/templates/member_template.css', array(), CN_CURRENT_VERSION);
			//wp_enqueue_style( 'member_template_styles' );
		}
		
		/*
		 * Add items to the favorites drop down.
		 */
		public function addEntryFavorite($actions)
		{
			// Exit the method if $_GET['page'] isn't set.
			if ( !isset($_GET['page']) ) return $actions;
			
			switch ($_GET['page'])
			{
				
				case 'connections_add':
					$cnActions = array( 'admin.php?page=connections_categories' => array('Add Category', 'connections_edit_categories') );
				break;
				
				case 'connections_categories':
					$cnActions = array( 'admin.php?page=connections&action=add_new' => array('Add Entry', 'connections_add_entry') );
				break;
				
				case 'connections_templates':
				case 'connections_settings':
				case 'connections_roles':
				case 'connections_csv':
				case 'connections_help':
				case 'connections':
					$cnActions = array( 'admin.php?page=connections&action=add_new' => array('Add Entry', 'connections_add_entry'),
										'admin.php?page=connections_categories' => array('Add Category<div class="favorite-action"><hr /></div>', 'connections_edit_categories')
									   );
				break;
			}
			
			return array_merge( (array) $cnActions, $actions);
		}
		
		// Add settings option
		public function addActionLinks($links) {
			$new_links = array();
			
			$new_links[] = '<a href="admin.php?page=connections_settings">Settings</a>';
			
			return array_merge($new_links, $links);
		}
		
		// Add FAQ and support information
		public function addMetaLinks($links, $file)
		{
			if ( $file == plugin_basename(__FILE__) )
			{
				$links[] = '<a href="admin.php?page=connections_help" target="_blank">Help</a>';
				$links[] = '<a href="http://connections-pro.com/help-desk" target="_blank">Support</a>';
				$links[] = '<a href="https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=5070255" target="_blank">Donate</a>';
			}
			
			return $links;
		}
		
		/**
		 * Add the changelog as a table row on the Manage Plugin admin screen.
		 * Code based on Changelogger.
		 */
		public function displayUpgradeNotice()
		{
			include_once( ABSPATH . 'wp-admin/includes/plugin-install.php' );
			//echo "<tr><td colspan='5'>TEST</td></tr>";
			//$api = plugins_api('plugin_information', array('slug' => 'connections', 'fields' => array('tested' => true, 'requires' => false, 'rating' => false, 'downloaded' => false, 'downloadlink' => false, 'last_updated' => false, 'homepage' => false, 'tags' => false, 'sections' => true) ));
			//print_r($api);
			
			if( CLOSMINWP30 )
			    $current = get_option( '_site_transient_update_plugins' );
			elseif( CLOSMINWP28 )
			    $current = get_transient( 'update_plugins' );
			else
			    $current = get_option( 'update_plugins' );
				
			//print_r($current);
			
			if ( !isset($current->response[ plugin_basename(__FILE__) ]) ) return NULL;
			
			$r = $current->response[ plugin_basename(__FILE__) ]; // response should contain the slug and upgrade_notice within an array.
			//print_r($r);
			
			if ( isset($r->upgrade_notice) )
			{
				$columns = CLOSMINWP28 ? 3 : 5;
				
				$output .= '<tr class="plugin-update-tr"><td class="plugin-update" colspan="' . $columns . '"><div class="update-message" style="font-weight: normal;">';
				$output .= '<strong>Upgrade notice for version: ' . $r->new_version . '</strong>';
				$output .= '<ul style="list-style-type: square; margin-left:20px;"><li>' . $r->upgrade_notice . '</li></ul>';
				$output .= '</div></td></tr>';
			
				echo $output;
			}
			
			
			/*stdClass Object
			(
			    [id] => 5801
			    [slug] => connections
			    [new_version] => 0.7.0.0
			    [upgrade_notice] => Upgrading to this version might break custom templates.
			    [url] => http://wordpress.org/extend/plugins/connections/
			    [package] => http://downloads.wordpress.org/plugin/connections.0.7.0.0.zip
			)*/
		}
		
		/**
		 * This is the registered function calls for the Connections admin pages as registered
		 * using the add_menu_page() and add_submenu_page() WordPress functions.
		 */
		public function showPage()
		{
			if  ( $this->options->getVersion() < CN_CURRENT_VERSION )
			{
				//echo $this->options->getVersion() . '<div id="message" class="error"><p><strong>ERROR: </strong>The version of Connections installed is newer than the version last activated. Please deactive and then reactivate Connections.</p></div>';
				//return;
				$this->initOptions();
				$this->options->setVersion(CN_CURRENT_VERSION);
			}
			
			if ($this->options->getDBVersion() < CN_DB_VERSION)
			{
				include_once ( dirname (__FILE__) . '/includes/inc.upgrade.php' );
				connectionsShowUpgradePage();
				return;
			}
			
			//if ( get_option('connections_activated') )
			//{
				//echo '<div id="message" class="updated fade"><p><strong>' . get_option('connections_activated') . '</strong></p></div>';
				// Remove the admin install message set during activation.
				//delete_option('connections_installed');
			//}
			
			
			switch ($_GET['page'])
			{
				case 'connections':
					include_once ( dirname (__FILE__) . '/submenus/view.php' );
					connectionsShowViewPage();
				break;
				
				//case 'connections&action=add_new':
					//include_once ( dirname (__FILE__) . '/submenus/view.php' );
					//connectionsShowAddPage();
					//connectionsShowViewPage();
				//break;
				
				case 'connections_categories':
					include_once ( dirname (__FILE__) . '/submenus/categories.php' );
					connectionsShowCategoriesPage();
				break;
				
				case 'connections_settings':
					include_once ( dirname (__FILE__) . '/submenus/settings.php' );
					connectionsShowSettingsPage();
				break;
				
				case 'connections_templates':
					include_once ( dirname (__FILE__) . '/submenus/templates.php' );
					connectionsShowTemplatesPage();
				break;
				
				case 'connections_roles':
					include_once ( dirname (__FILE__) . '/submenus/roles.php' );
					connectionsShowRolesPage();
				break;
				
				case 'connections_help':
					include_once ( dirname (__FILE__) . '/submenus/help.php' );
					connectionsShowHelpPage();
				break;
			}
			
		}
		
		/**
		 * Veryfy and process requested actions in the admin.
		 */
		private function controllers()
		{
			// Exit the method if $_GET['page'] isn't set.
			if ( !isset($_GET['page']) ) return;
			if ( !isset($_GET['action']) ) return;
			
			global $connections;
			
			include_once ( dirname (__FILE__) . '/includes/inc.processes.php' );
			$form = new cnFormObjects();
			
			switch ($_GET['page'])
			{
				case 'connections':
					if ($_GET['action'])
					{
						switch ($_GET['action']) {
							case 'add':
								/*
								 * Check whether the current user can add an entry.
								 */
								if (current_user_can('connections_add_entry'))
								{
									check_admin_referer($form->getNonce('add_entry'), '_cn_wpnonce');
									processEntry($_POST, 'add');
									wp_redirect('admin.php?page=connections&action=add_new&display_messages=true');
								}
								else
								{
									$connections->setErrorMessage('capability_add');
								}
							break;
							
							case 'update':
								/*
								 * Check whether the current user can edit an entry.
								 */
								if (current_user_can('connections_edit_entry'))
								{
									check_admin_referer($form->getNonce('update_entry'), '_cn_wpnonce');
									processEntry($_POST, 'update');;
									wp_redirect('admin.php?page=connections&display_messages=true');
								}
								else
								{
									$connections->setErrorMessage('capability_edit');
								}
							break;
							
							case 'delete':
								/*
								 * Check whether the current user delete an entry.
								 */
								if (current_user_can('connections_delete_entry'))
								{
									processDeleteEntry();
									wp_redirect('admin.php?page=connections&display_messages=true');
								}
								else
								{
									$connections->setErrorMessage('capability_delete');
								}
							break;
							
							case 'filter':
								check_admin_referer('filter');
								processSetUserFilter();
							break;
							
							case 'do':
								switch ($_POST['action'])
								{
									case 'delete':
										/*
										 * Check whether the current user delete an entry.
										 */
										if (current_user_can('connections_delete_entry'))
										{
											check_admin_referer($form->getNonce('bulk_action'), '_cn_wpnonce');
											processDeleteEntries();
											wp_redirect('admin.php?page=connections&display_messages=true');
										}
										else
										{
											$connections->setErrorMessage('capability_delete');
										}
									break;
									
									case 'public':
									case 'private':
									case 'unlisted':
										/*
										 * Check whether the current user can edit entries.
										 */
										if (current_user_can('connections_edit_entry'))
										{
											check_admin_referer($form->getNonce('bulk_action'), '_cn_wpnonce');
											processSetEntryVisibility();
											wp_redirect('admin.php?page=connections&display_messages=true');
										}
										else
										{
											$connections->setErrorMessage('capability_edit');
										}
									break;
								}
								
								if ( isset($_POST['filter']) )
								{
									check_admin_referer($form->getNonce('bulk_action'), '_cn_wpnonce');
									processSetUserFilter();
									wp_redirect('admin.php?page=connections&display_messages=true');
								}
								
							break;
						}
					}
					
				break;
				
				case 'connections_add':
					/*
					 * Check whether user can add entries
					 */
					if (current_user_can('connections_add_entry'))
					{
						if ($_POST['save'] && $_GET['action'] === 'add')
						{
							check_admin_referer($form->getNonce('add_entry'), '_cn_wpnonce');
							processEntry($_POST, 'add');
							wp_redirect('admin.php?page=connections_add&display_messages=true');
						}
					}
					else
					{
						$connections->setErrorMessage('capability_add');
					}
				break;
				
				case 'connections_categories':
					/*
					 * Check whether user can edit Settings
					 */
					if (current_user_can('connections_edit_categories'))
					{
						if ($_GET['action'])
						{
							switch ($_GET['action']) {
								case 'add':
									check_admin_referer($form->getNonce('add_category'), '_cn_wpnonce');
									processAddCategory();
									wp_redirect('admin.php?page=connections_categories&display_messages=true');
								break;
								
								case 'update':
									check_admin_referer($form->getNonce('update_category'), '_cn_wpnonce');
									processUpdateCategory();
									wp_redirect('admin.php?page=connections_categories&display_messages=true');
								break;
								
								case 'delete':
									processDeleteCategory('delete');
									wp_redirect('admin.php?page=connections_categories&display_messages=true');
								break;
								
								case 'bulk_delete':
									check_admin_referer($form->getNonce('bulk_delete_category'), '_cn_wpnonce');
									processDeleteCategory('bulk_delete');
									wp_redirect('admin.php?page=connections_categories&display_messages=true');
								break;
							}
						}
					}
					else
					{
						$connections->setErrorMessage('capability_categories');
					}
				break;
				
				case 'connections_settings':
					/*
					 * Check whether user can edit Settings
					 */
					if (current_user_can('connections_change_settings'))
					{
						if ($_POST['save'] && $_GET['action'] === 'update_settings')
						{
							check_admin_referer($form->getNonce('update_settings'), '_cn_wpnonce');
							updateSettings();
							wp_redirect('admin.php?page=connections_settings&display_messages=true');
						}
					}
					else
					{
						$connections->setErrorMessage('capability_settings');
					}
				break;
				
				case 'connections_templates':
					/*
					 * Check whether user can manage Templates
					 */
					if (current_user_can('connections_manage_template'))
					{
						if ($_GET['action'])
						{
							switch ($_GET['action']) {
								case 'activate':
									processActivateTemplate();
									
									( !isset($_GET['type']) ) ? $tab = 'all' : $tab = esc_attr($_GET['type']);
									wp_redirect('admin.php?page=connections_templates&type=' . $tab . '&display_messages=true');
								break;
								
								case 'install':
									check_admin_referer($form->getNonce('install_template'), '_cn_wpnonce');
									processInstallTemplate();
									
									( !isset($_GET['type']) ) ? $tab = 'all' : $tab = esc_attr($_GET['type']);
									wp_redirect('admin.php?page=connections_templates&type=' . $tab . '&display_messages=true');
								break;
								
								case 'delete':
									processDeleteTemplate();
									
									( !isset($_GET['type']) ) ? $tab = 'all' : $tab = esc_attr($_GET['type']);
									wp_redirect('admin.php?page=connections_templates&type=' . $tab . '&display_messages=true');
								break;
							}
						}
					}
					else
					{
						// @TODO: Create template specific error message.
						$connections->setErrorMessage('capability_settings');
					}
				break;
				
				case 'connections_roles':
					/*
					 * Check whether user can edit roles
					 */
					if (current_user_can('connections_change_roles'))
					{
						if ($_POST['save'] && $_GET['action'] === 'update_role_settings')
						{
							check_admin_referer($form->getNonce('update_role_settings'), '_cn_wpnonce');
							updateRoleSettings();
							wp_redirect('admin.php?page=connections_roles&display_messages=true');
						}
					}
					else
					{
						$connections->setErrorMessage('capability_roles');
					}
				break;
			}
		}
		
	}
	
	/*
	 * Checks for PHP 5 or greater as required by Connections and display an error message
	 * rather that havinh PHP thru an error.
	 */
	if (version_compare(PHP_VERSION, '5.0.0', '>'))
	{
		/*
		 * Initiate the plug-in.
		 */
		global $connections;
		$connections = new connectionsLoad();
	}
	else
	{
		add_action( 'admin_notices', create_function('', 'echo \'<div id="message" class="error"><p><strong>Connections requires at least PHP5. You are using version: ' . PHP_VERSION . '</strong></p></div>\';') );
	}
	
}