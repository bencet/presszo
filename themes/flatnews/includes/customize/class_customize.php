<?php 
/*new class for customize*/
global $Google_Font_List;
$Google_Font_List = array(
/* --- Start of system font --- */	
	"Arial",				
	"'Courier New'",
	"Georgia",
	"Impact",
	"'Times New Roman'",
	"'Trebuchet MS'",
	"Verdana",
/* --- Start of webfont --- */	
	"Allerta",
	"Allerta Stencil",
	"Arimo",
	"Arvo",
	"Bentham",
	"Bree Serif",
	"Cabin",
	"Calibri",
	"Calligraffitti",
	"Cambria",
	"Cantarell",
	"Cardo",
	"Cherry Cream Soda",
	"Chewy",
	"Coming Soon",
	"Consolas",
	"Copse",
	"Corsiva",
	"Cousine",
	"Covered By Your Grace",
	"Crafty Girls",
	"Crimson Text",
	"Crushed",
	"Cuprum",
	"Dancing Script",
	"Droid Sans",
	"Droid Sans Mono",
	"Droid Serif",
	"Fontdiner Swanky",
	"GFS Didot",
	"GFS Neohellenic",
	"Geo",
	"Gruppo",
	"Hanuman",
	"Homemade Apple",
	"Inconsolata",
	"Indie Flower",
	"Josefin Sans",
	"Josefin Slab",
	"Just Another Hand",
	"Kenia",
	"Kranky",
	"Lato",
	"Lobster",
	"Lobster Two",
	"Lora",
	"Luckiest Guy",
	"Merriweather",
	"Molengo",
	"Mountains of Christmas",
	"Neucha",
	"Neuton",
	"Nobile",
	"Old Standard TT",
	"Open Sans",
	"Oswald",
	"Pacifico",
	"Patua One",
	"Paytone One",
	"Permanent Marker",
	"Philosopher",
	"Play",
	"Poly",
	"PT Sans",
	"PT Sans Caption",
	"PT Sans Narrow",
	"Puritan",
	"Reenie Beanie",
	"Rock Salt",
	"Schoolbell",
	"Slackey",
	"Sorts Mill Goudy",
	"Source Sans Pro",
	"Sue Ellen Francisco",
	"Sunshiney",
	"Syncopate",
	"Tinos",
	"UnifrakturMaguntia",
	"Unkempt",
	"Varela Round",
	"Vollkorn",
	"Walter Turncoat",
	"Yanone Kaffeesatz"
);



// check to prevent define class on front-pages
if ( class_exists( 'WP_Customize_Control' ) ) :

class GoogleFontPicker extends WP_Customize_Control { 
	public function render_content() {
		global $Google_Font_List;
		
		
	?>


<!-- dynamic load google font -->
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
<script src="http://ajax.googleapis.com/ajax/libs/webfont/1/webfont.js"></script>
<script type="text/javascript">
	<?php 
		for ($i = 0; $i < count($Google_Font_List); $i++) {
			if ($i > 6) {
				echo 'WebFont.load({google: {families: ["'.$Google_Font_List[$i].'"]}});';
			}
		}
	?>
	
</script>

<!-- style with google fonts -->
<style type="text/css">
.font-style {
    display: block;
    height: 2em;
	font-size: 16px;
}
.font-style input {
    margin: 4px 5px 0 0;
}
.font-hr {
    background: #f0f0f0;
    padding: 5px;
    font-style: italic;
    color: #999;
    margin: 10px 0 5px 0;
}
.font-container {
    position: relative;
    height: 200px;
    overflow: auto;
    background: #fbfbfb;
    padding: 0 10px;
	border: 2px solid #ccc;
}
	<?php 
		for ($i = 0; $i < count($Google_Font_List); $i++) {
			echo '.font-style-'.$i.' {font-family: '.$Google_Font_List[$i].';}';
		}
		
		// get custom font list
		$cufont = array();
		$the_query = new WP_Query( array( 
			'post_status' => 'any', 
			'post_type' => 'attachment',
			'post_mime_type' => 'font/opentype') );

		// The Loop
		if ( $the_query->have_posts() ) :
			$index = count($Google_Font_List);
			while ( $the_query->have_posts() ) : $the_query->the_post();
				$fid = get_the_ID();
				$fname = get_the_title();
				$fguid = get_the_guid();
				echo '@font-face {
  font-family: \''.$fname.'\';
  src: url('.$fguid.') format(\'woff\');
}';
				echo '.font-style-'.$index.' {font-family: '.$fname.';}';
				$index++;
				
				$cufont['cufont-'.$fid] = $fname;
			endwhile;
		endif;

		/* Restore original Post Data */
		wp_reset_postdata();
	?>
</style>

	
<span class="customize-control-title"><?php echo $this->label; ?></span>
<!-- output radio for fonts -->
<?php
		$value = $this->value;
		if (!$value) {
			$value = 'font-62';
		}
		
		echo '<div class="font-container">';
		
		for ($i = 0; $i < count($Google_Font_List); $i++) {
			if ($i == 0) {
				echo '<div class="font-hr">System fonts</div>';
			}
			if ($i == 7) {
				echo '<div class="font-hr">Webfonts</div>';
			}
			
			echo '<label class="font-style font-style-'.$i.'"><input type="radio" value="font-'.$i.'" name="'.$this->id.'" '.$this->get_link().' '.(($value == ('font-'.$i))?'checked':'').'/>'.$Google_Font_List[$i].'<br/></label>' ;
		}
		if (!empty($cufont)) {
			echo '<div class="font-hr">Uploaded Fonts</div>';
			$index = count($Google_Font_List);
			foreach ($cufont as $key => $name) {
				echo '<label class="font-style font-style-'.$index.'"><input type="radio" value="'.$key.'" name="'.$this->id.'" '.$this->get_link().' '.(($value == $key)?'checked':'').'/>'.$name.'<br/></label>' ;
				$index++;
			}
		}
		
		
		echo '</div>';
		
		
	}
	
}   

endif;/*check WP class*/
?>