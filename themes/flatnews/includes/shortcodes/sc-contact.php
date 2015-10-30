<?php
	add_shortcode('contact', 'contact_handler');

	function contact_handler($atts, $content=null, $code="") {
		$RES_HTML = '';
		
		extract(shortcode_atts(array(
			'target_email' => ''), $atts));
		
		$mail_to = get_option( 'admin_email' ); 
		if ($target_email) {
			$mail_to = $target_email;
		}
		
		$website = '';
		$email = '';
		$u_name = '';
		$message = '';
		if(isset($_POST["website"])){
			$website=remove_html_slashes($_POST["website"]);
		}
		if(isset($_POST["email"])){
			$email=remove_html_slashes($_POST["email"]);
		}
		if(isset($_POST["u_name"])){
			$u_name=remove_html_slashes($_POST["u_name"]);
		}
		if(isset($_POST["message"])){
			$message=remove_html_slashes($_POST["message"]);
		}
		
		$ip = $_SERVER['REMOTE_ADDR'];


		$error="";
		if(isset($_POST["addnew"])){
			$addnew=$_POST["addnew"];
			
			// show error message when submit form
			if($addnew)
			{
				$before="<tr><td colspan=\"2\"><div class=\"top-error-message\">";
				$after="</div></td></tr>";
				
				if(!$u_name) {
					$error.=$before.( __( 'Please enter your name!' , THEME_DOMAIN )).$after;
				}
				if(!$email) {
					$error.=$before.( __( 'Please enter your e-mail!' , THEME_DOMAIN )).$after;
				}
				if($email && !preg_match("/@/i", "$email")) {
					$error.=$before.( __( 'Please enter a valid e-mail!' , THEME_DOMAIN )).$after;
				}
				if(!$message) {
					$error.=$before.( __( 'Please enter your message!' , THEME_DOMAIN )).$after;
				}
			}
		}
	
		
		// is submit message and has no error, then send email
		if((isset($addnew) && !$error)) :

			$subject = ( __( 'From' , THEME_DOMAIN ))." ".get_bloginfo('name')." ".( __( 'Contact Page' , THEME_DOMAIN ));
			
			$eol="\n";
			$mime_boundary=md5(time());
			$headers = "From: ".$email." <".$email.">".$eol;
			//$headers .= "Reply-To: ".$email."<".$email.">".$eol;
			$headers .= "Message-ID: <".time()."-".$email.">".$eol;
			$headers .= "X-Mailer: PHP v".phpversion().$eol;
			$headers .= 'MIME-Version: 1.0'.$eol;
			$headers .= "Content-Type: text/html; charset=UTF-8; boundary=\"".$mime_boundary."\"".$eol.$eol;
			


			ob_start(); 
	?>
<?php printf ( __( 'Message:' , THEME_DOMAIN ));?> <?php echo $message;?>
<div style="padding-top:100px;">
<?php printf ( __( 'Name:' , THEME_DOMAIN ));?> <?php echo $u_name;?><br/>
<?php printf ( __( 'Website:' , THEME_DOMAIN ));?> <?php echo $website;?><br/>
<?php printf ( __( 'E-mail:' , THEME_DOMAIN ));?> <?php echo $email;?><br/>
<?php printf ( __( 'IP Address:' , THEME_DOMAIN ));?> <?php echo $ip;?><br/>
</div>
		<?php
			$message = ob_get_clean();
			wp_mail($mail_to,$subject,$message,$headers);
			
			
		endif;// check add new && error
			
		?>

<?php // javascript for validate form ?>

<?php 

$RES_HTML = '
<script language = "Javascript">
		
	function Validate() 
	{

		var errors = "";
		var reason_name = "";
		var reason_mail = "";
		var reason_message = "";


		reason_name += validateName(document.getElementById("contact-form").u_name);
		reason_mail += validateEmail(document.getElementById("contact-form").email);
		reason_message += validateMessage(document.getElementById("contact-form").message);



		if (reason_name != "") 
		{
			jQuery("#name_error").text(reason_name).fadeIn(1000);
			jQuery("#name_input").addClass("input-error-1");
			document.getElementById("name_error").style.display = "block";
			errors = "Error";
		}
		else{
			jQuery("#name_input").removeClass("input-text-1-error");
			document.getElementById("name_error").style.display = "none";
		}


		if (reason_mail != "") 
		{
			jQuery("#mail_error").text(reason_mail).fadeIn(1000);
			jQuery("#mail_input").addClass("input-error-1");
			document.getElementById("mail_error").style.display = "block";
			errors = "Error";
		}
		else{
			jQuery("#mail_input").removeClass("input-text-1-error");
			document.getElementById("mail_error").style.display = "none";
		}
		
		if (reason_message != "") 
		{
			jQuery("#message_error").text(reason_message).fadeIn(1000);
			jQuery("#message_input").addClass("input-error-1");
			document.getElementById("message_error").style.display = "block";
			errors = "Error";
		}
		else{
			jQuery("#message_input").removeClass("input-text-1-error");
			document.getElementById("message_error").style.display = "none";
		}
		
		if (errors != ""){
			return false;
		}
		
		document.getElementById("contact-form").submit(); return false;
	}
	
		function validateName(fld) 
	{

		var error = "";
		
		if (fld.value == "")
		{
			error = "'. __( "You didn't enter your name." , THEME_DOMAIN ) .'\n";
		}
		else if ((fld.value.length < 2) || (fld.value.length > 50))
		{
			error = "'. __( "Name has a wrong length." , THEME_DOMAIN ) .'\n";
		}


		return error;
	}
	
		function validateEmail(fld) 
	{

		var error="";
		var illegalChars = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
		
		if (fld.value == ""){
			error = "'. __( "You didn't enter email address." , THEME_DOMAIN ) .'\n";
		}
		else if ( fld.value.match( illegalChars ) == null){
			error = "'. __( "The email address contains illegal characters." , THEME_DOMAIN ).'\n";
		}


		return error;

	}
	
	function validateMessage(fld) 
	{

		var error = "";
		
		if (fld.value == "")
		{
			error = "'. __( "You didn't enter message." , THEME_DOMAIN ).'\n";
		}
		else if (fld.value.length<3)
		{
			error = "'. __( "The message is to short." , THEME_DOMAIN ).'\n";
		}


		return error;
	}

		
	</script>';
	
?>

	<?php if($mail_to) : ?>
					
		<?php if(!isset($addnew) || $error) :?>
		
		<?php
		
		$RES_HTML .= '
		<form method="post" class="contact-form" id="contact-form" name="contact-form" action="">
			<input type="hidden"  name="addnew" value="yes" />
			<table>	
				'. $error.'
				<tr>
					<td class="label">'. __( 'Name' , THEME_DOMAIN ).'</td>
					<td>
						<input type="text" name="u_name" value="'. $u_name.'" class="input-text-1" id="name_input" />
						<div class="input-error-1-label" id="name_error" style="display: none;"></div>

					</td>
				</tr>
				<tr><td class="spacer-1" colspan="2"></td></tr>
				<tr>
					<td class="label">'. __( 'E-mail' , THEME_DOMAIN ).'</td>
					<td>
						<input type="text" name="email" value="'. $email.'" class="input-text-1" id="mail_input"/>
						<div class="input-error-1-label" id="mail_error" style="display: none;"></div>
					</td>
				</tr>
				<tr><td class="spacer-1" colspan="2"></td></tr>
				<tr>
					<td class="label">'. __( 'Website' , THEME_DOMAIN ).'</td>
					<td>
						<input type="text" name="website" value="'. $website.'" class="input-text-1"/>
					</td>
				</tr>
				<tr><td class="spacer-1" colspan="2"></td></tr>
				<tr>
					<td class="label">'. __( 'Comment' , THEME_DOMAIN ).'</td>
					<td>
						<textarea name="message" id="message_input" class="text-area-1">'. $message.'</textarea>
						<div class="input-error-1-label" id="message_error" style="display: none;"></div>
					</td>
				</tr>
				<tr><td class="spacer-1" colspan="2"></td></tr>
				<tr>
					<td></td>
					<td> 
						<p class="show-all"><a href="javascript:{}" onclick="return Validate(); submitform();" class="btn-1 btn-1-color-default"><span>'. __( 'Send contact form' , THEME_DOMAIN ).'</span></a></p>
					</td>
				</tr>
			</table>
		</form>'; 
		
		?>
		
		<?php endif;//addnew_error ?>	
		
		<?php if(isset($addnew) && !$error) : ?>
			<?php
			$RES_HTML .= '<div class="contact-success">
				<p><span>'. __( 'Thanks!' , THEME_DOMAIN ).'</span></p>
				<p>'. __( 'Your message has been sent!' , THEME_DOMAIN ).'</p>
			</div>'; 
			
			?>
		<?php endif; // addnew_error ?>
	<?php endif; // mail_to ?>													

<?php 
	return $RES_HTML;
} // end function ?>
