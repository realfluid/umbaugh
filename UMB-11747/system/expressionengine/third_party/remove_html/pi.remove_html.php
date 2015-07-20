<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Memberlist Class
 *
 * @package		ExpressionEngine
 * @category	Plugin
 * @author		Elliot Lewis
 * @copyright	Copyright (c) No Two The Samw 2012, Elliot Lewis
 * @link		http://notwothesame.com/products/
 */

$plugin_info = array(
  'pi_name'         => 'Remove HTML',
  'pi_version'      => '1.0',
  'pi_author'       => 'Elliot Lewis',
  'pi_author_url'   => 'http://www.notwothesame.com/',
  'pi_description'  => 'Removes HTML Tags',
  'pi_usage'        => Remove_html::usage()
);

class Remove_html
{

    public $return_data = "";

    // --------------------------------------------------------------------

    /**
     * Remove_html
     *
     *  Purpose: If a field is stored as XHTML can reformat to plain text.
     *	Handy to use in form fields.
     *
     * @access  public
     * @return  string
     */
    public function __construct()
    {
        $this->EE =& get_instance();
		
		if (empty($str))
		{
			$str = $this->EE->TMPL->tagdata;
		}
		
		$str = preg_replace("/\r|\n/", "", $str);					// remove all returns from text
		$str = preg_replace("/<br \/>|<br>/", "\r\n", $str);		// convert soft returns
		$str = preg_replace("/<\/p>/", "\r\n\r\n", $str);			// convert paragraphs returns
		$str = preg_replace('/<[^>]*>/', '', $str);					// remove all tags
		$this->return_data = trim($str);
    }

    // --------------------------------------------------------------------

    /**
     * Usage
     *
     * This function describes how the plugin is used.
     *
     * @access  public
     * @return  string
     */
    public static function usage()
    {
        ob_start();  ?>

This plugin removes any text in the format <tag> or </tag>, therefore HTML. Important to note that any text in this format will be removed even if it's not a valid HTML tag.

{exp:remove_html}

text you want processed most likely an existing custom field tag, eg. {my_field}

{/exp:remove_html}


    <?php
        $buffer = ob_get_contents();
        ob_end_clean();

        return $buffer;
    }
    // END
}
/* End of file pi.remove_html.php */
/* Location: ./system/expressionengine/third_party/remove_html/pi.remove_html.php */