<?php
/*
 * Template name: Article Forms
 */
get_header();

if ( have_posts() ) while ( have_posts() ) : the_post();

	
	if($_POST['form'] == "newsletter-email" OR $_POST['form'] == "newsletter-feedback") {
	
		/**
		 * Include Zend Framework
		 */
		set_include_path(get_include_path() . PATH_SEPARATOR . 'library/');
		require_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
	
		$file = 'wp-includes/mails/' . $_POST['form'] . '-' . time() . '.txt';
   		$fileStream = fopen($file, 'w+') or die("couldn't open file ");
			
	    $table = '<table>';
	
	    foreach($_POST as $key => $value)
	    {
	        if($key != 'redirect' || $key != 'submit') {
	            $name = explode('-',$key);
	            $table .=
	                '<tr>
	                    <td>
	                       ' . ucfirst(implode(' ', $name)) . '
	                    </td>
	                    <td>
	                       ' . $value .
	                    '</td>
	                </tr>';
	            fwrite($fileStream, ucfirst(implode(' ', $name)) . ': ' . $value . '\n');
	        }
	    }
	
	    $table .= '</table>';
	
	
		$post = get_post($_POST['articleId']);
		$authorData = get_userdata($post->post_author);
		//Zend_Debug::dump($authorData); die();
    	fclose($fileStream);
		
		$mail = new Zend_Mail();
		if($_POST['form'] == "newsletter-email") $mail->addTo($authorData->user_email);
		$mail->addTo('webmanager@quinlanmarketing.com');
		$mail->addTo('footnotes@umbaugh.com');
		$mail->addTo('koen@go-online.be');
	    $mail->setFrom('no-reply@umbaugh.com');
	    $mail->setSubject('Feedback on: ' . $post->post_title);
	    $mail->setBodyHtml($table);
	    if($mail->send()) { ?>

	<div class="interior-content"> 
        <div id="mainColumn" class="wide"> 
 
							<h1>Thank you</h1> 
				<p>Thank you for your form submission. We will be in contact with you shortly.</p> 
			
		</div> 
 
	</div> 

<?php    }
	}

//Zend_Debug::dump($_POST); die();

endwhile;

get_footer(); ?>
