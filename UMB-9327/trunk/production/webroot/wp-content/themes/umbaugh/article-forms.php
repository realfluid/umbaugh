<?php
/*
 * Template name: Article Forms
 */
get_header();

if ( have_posts() ) while ( have_posts() ) : the_post();

	
	if($_POST['form'] == "newsletter-email") {
	
		/**
		 * Include Zend Framework
		 */
		set_include_path(get_include_path() . PATH_SEPARATOR . 'library/');
		require_once 'Zend/Loader/Autoloader.php';
		$autoloader = Zend_Loader_Autoloader::getInstance();
	
	
	
	
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
	        }
	    }
	
	    $table .= '</table>';
	
	
		$post = get_post($_POST['articleId']);
		$authorData = get_userdata($post->post_author);
		//Zend_Debug::dump($authorData);
		
		$mail = new Zend_Mail();
		//$mail->addTo($authorData->user_email);
		$mail->addTo('webmanager@quinlanmarketing.com');
		//$mail->addTo('footnotes@umbaugh.com');
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
