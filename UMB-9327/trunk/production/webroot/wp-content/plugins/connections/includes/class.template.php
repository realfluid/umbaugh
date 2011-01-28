<?php
class cnTemplate
{
	/**
	 * Template Name.
	 * @var string
	 */
	public $name;
	
	/**
	 * Template slug [template directory]
	 * @var string
	 */
	public $slug;
	
	/**
	 * Template URL
	 * @var string
	 */
	public $url;
	
	/**
	 * The template author's uri.
	 * @var
	 */
	public $uri;
	
	/**
	 * Template version.
	 * @var string
	 */
	public $version;
	
	/**
	 * Tamplate's author's name.
	 * @var string
	 */
	public $author;
	
	/**
	 * Template description.
	 * @var string
	 */
	public $description;
	
	/**
	 * Set TRUE if the template should use the legacy output from cnOutput.
	 * @var bool
	 */
	public $legacy;
	
	/**
	 * TRUE if the template is in the custom template directory.
	 * @var
	 */
	public $custom;
	
	/**
	 * Path to the template.php file.
	 * @var string
	 */
	public $file;
	
	/**
	 * The path to the template's CSS file.
	 * @var string
	 */
	public $cssPath;
	
	/**
	 * The URL to the template's CSS file.
	 * @var string
	 */
	public $cssURL;
	
	/**
	 * The path to the template's Javascript file.
	 * @var string
	 */
	public $jsPath;
	
	/**
	 * The template base path.
	 * @var string
	 */
	public $path;
	
	/**
	 * Stores the catalog of available templates when cnTemplate::buildCtalog() is called.
	 * 
	 * @var object
	 */
	private $catalog;
	
	/**
	 * Builds a catalog of all the available templates from
	 * the supplied and the custom template directories.
	 * 
	 * @return array
	 */
	public function buildCatalog()
	{
		/**
		 * --> START <-- Find the available templates
		 */
		$templatePaths = array(CN_TEMPLATE_PATH, CN_CUSTOM_TEMPLATE_PATH);
		$templates = new stdClass();
		
		foreach ($templatePaths as $templatePath)
		{
			if ( !is_dir($templatePath . '/') && !is_readable($templatePath . '/') ) continue;
			
			$templateDirectories = opendir($templatePath);
			
			while ( ( $templateDirectory = readdir($templateDirectories) ) !== FALSE )
			{
				if ( is_dir($templatePath . '/' . $templateDirectory) && is_readable($templatePath . '/' . $templateDirectory) )
				{
					if ( file_exists($templatePath . '/' . $templateDirectory . '/meta.php') &&
						 file_exists($templatePath . '/' . $templateDirectory . '/template.php') 
						)
					{
						$template = new stdClass();
						include($templatePath . '/' . $templateDirectory . '/meta.php');
						$template->slug = $templateDirectory;
						
						// Load the template metadate from the meta.php file
						
						if ( !isset($template->type) ) $template->type = 'all';
						
						$templates->{$template->type}->{$template->slug}->name = $template->name;
						$templates->{$template->type}->{$template->slug}->version = $template->version;
						$templates->{$template->type}->{$template->slug}->uri = 'http://' . $template->uri;
						$templates->{$template->type}->{$template->slug}->author = $template->author;
						$templates->{$template->type}->{$template->slug}->description = $template->description;
						
						( !isset($template->legacy) ) ? $templates->{$template->type}->{$template->slug}->legacy = TRUE : $templates->{$template->type}->{$template->slug}->legacy = $template->legacy;
						$templates->{$template->type}->{$template->slug}->slug = $template->slug;
						$templates->{$template->type}->{$template->slug}->custom = ( $templatePath === CN_TEMPLATE_PATH ) ? FALSE : TRUE;
						$templates->{$template->type}->{$template->slug}->path = $templatePath . '/' . $templateDirectory;
						$templates->{$template->type}->{$template->slug}->url = ( $templatePath === CN_TEMPLATE_PATH ) ? CN_TEMPLATE_URL . '/' . $template->slug : CN_CUSTOM_TEMPLATE_URL . '/' . $template->slug;
						$templates->{$template->type}->{$template->slug}->file = $templatePath . '/' . $templateDirectory . '/template.php';
						
						if ( file_exists( $templates->{$template->type}->{$template->slug}->path . '/' . 'styles.css' ) )
						{
							$templates->{$template->type}->{$template->slug}->cssPath = $templates->{$template->type}->{$template->slug}->path . '/' . 'styles.css';
						}
						
						if ( file_exists( $templates->{$template->type}->{$template->slug}->path . '/' . 'template.js' ) )
						{
							$templates->{$template->type}->{$template->slug}->jsPath = $templates->{$template->type}->{$template->slug}->path . '/' . 'template.js';
						}
						
						if ( file_exists( $templates->{$template->type}->{$template->slug}->path . '/' . 'functions.php' ) )
						{
							$templates->{$template->type}->{$template->slug}->phpPath = $templates->{$template->type}->{$template->slug}->path . '/' . 'functions.php';
						}
						
						if ( file_exists( $templates->{$template->type}->{$template->slug}->path . '/' . 'thumbnail.png' ) )
						{
							$templates->{$template->type}->{$template->slug}->thumbnailPath = $templates->{$template->type}->{$template->slug}->path . '/' . 'thumbnail.png';
							$templates->{$template->type}->{$template->slug}->thumbnailURL = $templates->{$template->type}->{$template->slug}->url . '/' . 'thumbnail.png';
						}
					}
				}
			}
			
			closedir($templateDirectories);
		}
		/**
		 * --> END <-- Find the available templates
		 */
		$this->catalog = $templates;
		
		return $templates;
	}
	
	/**
	 * Returns the catalog of templates by the supplied type.
	 * 
	 * @param string $type
	 * @return object
	 */
	public function getCatalog($type)
	{
		if ($type !== 'all')
		{
			return (object) array_merge( (array) $this->catalog->all, (array) $this->catalog->$type);
		}
		else
		{
			return $this->catalog->$type;
		}
	}
	
	/**
	 * Loads the template based on the supplied directory name [$slug].
	 * This will search the both the default templates directory and
	 * the connections_templates directory in wp_content.
	 * 
	 * @param string $slug
	 */	
	public function load($slug)
	{
		$templatePaths = array(CN_CUSTOM_TEMPLATE_PATH, CN_TEMPLATE_PATH);
		
		foreach ($templatePaths as $templatePath)
		{
			if ( is_dir($templatePath . '/' .  $slug) && is_readable($templatePath . '/' .  $slug) )
			{
				if ( file_exists($templatePath . '/' . $slug . '/meta.php') &&
					 file_exists($templatePath . '/' . $slug . '/template.php' )
					)
				{
					$this->slug = $slug;
					$this->path = $templatePath . '/' .  $slug;
					$this->url = ( $templatePath === CN_TEMPLATE_PATH ) ? CN_TEMPLATE_URL . '/' . $this->slug : CN_CUSTOM_TEMPLATE_URL . '/' . $this->slug;
					$this->file = $this->path . '/template.php';
					
					include_once( $this->path . '/meta.php' );
		
					$this->name = $template->name;
					$this->uri = $template->uri;
					$this->version = $template->version;
					$this->author = $template->author;
					$this->description = $template->description;
					$this->legacy = $template->legacy;
					
					$this->custom = ( $templatePath === CN_TEMPLATE_PATH ) ? FALSE : TRUE;
					if ( file_exists( $this->path . '/' . 'styles.css') ) $this->cssPath = $this->path . '/' . 'styles.css';
					if ( file_exists( $this->path . '/' . 'template.js') ) $this->jsPath = $this->path . '/' . 'template.js';
					if ( file_exists( $this->path . '/' . 'functions.php') ) $this->phpPath = $this->path . '/' . 'functions.php';
					
					break;
				}
			}
		}
		
	}
	
	/**
	 * Initialize the class with a template object.
	 * 
	 * @param object $template
	 */
	public function init($template)
	{
		$this->name = $template->name;
		$this->slug = $template->slug;
		$this->url = $template->url;
		$this->uri = $template->uri;
		$this->version = $template->version;
		$this->author = $template->author;
		$this->description = $template->description;
		$this->legacy = $template->legacy;
		$this->custom = $template->custom;
		$this->file = $template->file;
		$this->cssPath = $template->cssPath;
		$this->jsPath = $template->jsPath;
		$this->phpPath = $template->phpPath;
		$this->path = $template->path;
	}
	
	/**
	 * Loads the CSS file while replacing %%PATH%% with the URL
	 * to the template.
	 * 
	 * @return string
	 */
	public function printCSS()
	{
		if ( !isset($this->cssPath) ) return NULL;
		
		$contents = file_get_contents( $this->cssPath );
		
		// Loads the CSS style in the body, valid HTML5 when set with the 'scoped' attribute.
		$out = '<style type="text/css" scoped>' . "\n";
		$out .= str_replace('%%PATH%%', $this->url, $contents);
		$out .= '</style>' . "\n";
		
		return $out;
	}
	
	/**
	 * Prints the template's JS in the theme's footer.
	 */
	public function printJS()
	{
		// Prints the javascript tag in the footer if $template->js path is set
		if ( isset($this->jsPath) )
		{
			global $connections;
			$connections->printJS = TRUE;
			$connections->printJSURL = $this->url . '/template.js';
			
			function cnPrintTemplateJS()
			{
				global $connections;
				
				if ( $connections->printJS === TRUE )
				{
					wp_register_script('cn_template_js', $connections->printJSURL, array(), CN_CURRENT_VERSION, TRUE);
					wp_print_scripts('cn_template_js');
				}
			}
			
			add_action( 'wp_footer', 'cnPrintTemplateJS' );
		}
	}
	
	public function includeFunctions()
	{
		if (  isset($this->phpPath) )
		{
			include_once($this->phpPath);
		}
	}
}
?>