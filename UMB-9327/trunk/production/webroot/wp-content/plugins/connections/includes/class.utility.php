<?php

class cnCounter
{
     private $step;
     private $count; 

     public function getcount() {
          return $this->count;
     }
 
     public function getstep() {
          return $this->step;
     }

     public function changestep($newval) {
          if(is_integer($newval))
          $this->step = $newval;
     }

     public function step() {
          $this->count += $this->step;
     }

     public function reset() {
          $this->count = 0;
          $this->step = 1;
     }
}

class cnFormatting
{
	/**
	 * Sanitize the input string. HTML tags can be permitted.
	 * The permitted tags can be suppled in an array.
	 * 
	 * @TODO: Finish the code needed to support the $permittedTags array.
	 * 
	 * @param string $string
	 * @param bool $allowHTML [optional]
	 * @param array $permittedTags [optional]
	 * @return string
	 */
	public function sanitizeString($string, $allowHTML = FALSE, $permittedTags = NULL)
	{
		// Strip all tags except the permitted.
		if (!$allowHTML)
		{
			// Ensure all tags are closed. Uses WordPress method balanceTags().
			$balancedText = balanceTags($string, TRUE);
			
			$strippedText = strip_tags($balancedText);
			
			// Strip all script and style tags.
			$strippedText = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $strippedText );
			
			// Escape text using the WordPress method and then strip slashes.
			$escapedText = stripslashes(esc_attr($strippedText));
			
			// Remove line breaks and trim white space.
			$escapedText = preg_replace('/[\r\n\t ]+/', ' ', $escapedText);
			
			return trim($escapedText);
		}
		else
		{
			// Strip all script and style tags.
			$strippedText = preg_replace( '@<(script|style)[^>]*?>.*?</\\1>@si', '', $string );
			$strippedText = preg_replace( '/&lt;(script|style).*?&gt;.*?&lt;\/\\1&gt;/si', '', stripslashes($strippedText) );
			
			/*
			 * Use WordPress method make_clickable() to make links clickable and
			 * use kses for filtering.
			 * 
			 * http://ottopress.com/2010/wp-quickie-kses/
			 */
			return make_clickable( wp_kses_post($strippedText) );
		}
		
	}
	
	/**
	 * Uses WordPress function to sanitize the input string.
	 * 
	 * Limits the output to alphanumeric characters, underscore (_) and dash (-).
	 * Whitespace becomes a dash.
	 * 
	 * @param string $string
	 * @return string
	 */
	public function sanitizeStringStrong($string)
	{
		$string = sanitize_title_with_dashes($string);
		return $string;
	}
	
	/**
	 * Strips all numeric characters from the supplied string and returns the string.
	 * 
	 * @param string $string
	 * @return string
	 */
	public function stripNonNumeric($string)
	{
		return preg_replace('/[^0-9]/', '', $string);
	}
	
	/**
	 * Converts the following strings: yes/no; true/false and 0/1 to boolean values.
	 * If the supplied string does not match one of those values the method will return NULL.
	 * 
	 * @param string $value
	 * @return boolean
	 */
	public function toBoolean($value)
	{
		switch ($value) 
		{
			case 'yes':
				$value = TRUE;
			break;
			
			case 'no':
				$value = FALSE;
			break;
			
			case 'true':
				$value = TRUE;
			break;
			
			case 'false':
				$value = FALSE;
			break;
			
			case '1':
				$value = TRUE;
			break;
			
			case '0':
				$value = FALSE;
			break;
			
			default:
				$value = NULL;
			break;
		}
		
		return $value;
	}
}

class cnValidate
{
	public function attributesArray($defaults, $untrusted)
	{
		$intersect = array_intersect_key($untrusted, $defaults); // Get data for which is in the valid fields.
		$difference = array_diff_key($defaults, $untrusted); // Get default data which is not supplied.
		return array_merge($intersect, $difference); // Merge the results. Contains only valid fields of all defaults.
	}
	
	public function url()
	{
		
	}
	
	public function email()
	{
		
	}
}
?>