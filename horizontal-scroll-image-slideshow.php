<?php
/*
Plugin Name: Horizontal scroll image slideshow
Plugin URI: http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/
Description: Horizontal scroll image slideshow lets you showcase images in a horizontal scroll like fashion, one image at a time and in a continuous manner, with no breaks between the first and last image.  
Author: Gopi.R
Version: 8.2
Author URI: http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/
Donate link: http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
*/

function hsis_show() 
{
	$hsis_siteurl = get_option('siteurl');
	$hsis_pluginurl = $hsis_siteurl . "/wp-content/plugins/horizontal-scroll-image-slideshow/";

	$hsis_width = get_option('hsis_width');
	if(!is_numeric($hsis_width)){$hsis_width = 180;} 
	
	$hsis_height = get_option('hsis_height');
	if(!is_numeric($hsis_height)){$hsis_height = 150;} 

	$hsis_speed = get_option('hsis_speed');
	if(!is_numeric($hsis_speed)){$hsis_speed = 2000;} 

	$hsis_bgcolor = get_option('hsis_bgcolor');
	
	$doc = new DOMDocument();
	$doc->load( $hsis_pluginurl . 'gallery/widget.xml' );
	$images = $doc->getElementsByTagName( "image" );
	$vs_count = 0;
	$hsis_package = "";
	foreach( $images as $image )
	{
	  $paths = $image->getElementsByTagName( "path" );
	  $path = $paths->item(0)->nodeValue;
	  $targets = $image->getElementsByTagName( "target" );
	  $target = $targets->item(0)->nodeValue;
	  $titles = $image->getElementsByTagName( "title" );
	  $title = $titles->item(0)->nodeValue;
	  $links = $image->getElementsByTagName( "link" );
	  $link = $links->item(0)->nodeValue;
	  
	  $hsis_package = $hsis_package . "hsis_slideimages[$vs_count]='<a href=\'$link\' target=\'$target\'><img src=\'$path\' border=\'0\' title=\'$title\' alt=\'$title\'></a>'; ";
	  $vs_count++;
	}
	
	?>
    
	<script language="JavaScript1.2">
    
    var hsis_scrollerwidth='<?php echo $hsis_width ?>px'
    var hsis_scrollerheight='<?php echo $hsis_height ?>px'
    var hsis_scrollerbgcolor='<?php echo $hsis_bgcolor ?>'
    var hsis_pausebetweenimages=<?php echo $hsis_speed ?>
    
    var hsis_slideimages=new Array()
    <?php echo $hsis_package; ?>
	
    </script>
    <script language="JavaScript1.2" src="<?php echo $hsis_pluginurl; ?>/horizontal-scroll-image-slideshow.js"></script>
    <ilayer id="hsis_main" width=&{hsis_scrollerwidth}; height=&{hsis_scrollerheight}; bgColor=&{hsis_scrollerbgcolor}; visibility=hide> <layer id="first" left=1 top=0 width=&{hsis_scrollerwidth}; >
    <script language="JavaScript1.2">
    if (document.layers)
    document.write(hsis_slideimages[0])
    </script>
    </layer><layer id="second" left=0 top=0 width=&{hsis_scrollerwidth}; visibility=hide>
    <script language="JavaScript1.2">
    if (document.layers)
    document.write(hsis_slideimages[1])
    </script>
    </layer></ilayer>
    <script language="JavaScript1.2">
    if (ie||dom){
    document.writeln('<div id="hsis_main2" style="position:relative;width:'+hsis_scrollerwidth+';height:'+hsis_scrollerheight+';overflow:hidden;background-color:'+hsis_scrollerbgcolor+'">')
    document.writeln('<div style="position:absolute;width:'+hsis_scrollerwidth+';height:'+hsis_scrollerheight+';clip:rect(0 '+hsis_scrollerwidth+' '+hsis_scrollerheight+' 0);left:0px;top:0px">')
    document.writeln('<div id="hsis_first2" style="position:absolute;width:'+hsis_scrollerwidth+';left:1px;top:0px;">')
    document.write(hsis_slideimages[0])
    document.writeln('</div>')
    document.writeln('<div id="hsis_second2" style="position:absolute;width:'+hsis_scrollerwidth+';left:0px;top:0px">')
    document.write(hsis_slideimages[1])
    document.writeln('</div>')
    document.writeln('</div>')
    document.writeln('</div>')
    }
    </script>
    <?php
}

function hsis_install() 
{
	add_option('hsis_title', "Slideshow");
	add_option('hsis_width', "205");
	add_option('hsis_height', "150");
	add_option('hsis_bgcolor', "white");
	add_option('hsis_speed', "2000");
}

function hsis_widget($args) 
{
	extract($args);
	echo $before_widget . $before_title;
	echo get_option('hsis_title');
	echo $after_title;
	hsis_show();
	echo $after_widget;
}

function hsis_admin_option() 
{
	?>
	<div class="wrap">
	  <div class="form-wrap">
		<div id="icon-edit" class="icon32 icon32-posts-post"><br>
		</div>
		<h2><?php _e('Horizontal scroll image slideshow', 'horizontal-scroll-image'); ?></h2>
		<?php
		$hsis_title = get_option('hsis_title');
		$hsis_width = get_option('hsis_width');
		$hsis_height = get_option('hsis_height');
		$hsis_bgcolor = get_option('hsis_bgcolor');
		$hsis_speed = get_option('hsis_speed');
	
		if (isset($_POST['hsis_form_submit']) && $_POST['hsis_form_submit'] == 'yes')
		{
			//	Just security thingy that wordpress offers us
			check_admin_referer('hsis_form_setting');
				
			$hsis_title = stripslashes($_POST['hsis_title']);
			$hsis_width = stripslashes($_POST['hsis_width']);
			$hsis_height = stripslashes($_POST['hsis_height']);
			$hsis_bgcolor = stripslashes($_POST['hsis_bgcolor']);
			$hsis_speed = stripslashes($_POST['hsis_speed']);
			
			update_option('hsis_title', $hsis_title );
			update_option('hsis_width', $hsis_width );
			update_option('hsis_height', $hsis_height );
			update_option('hsis_bgcolor', $hsis_bgcolor );
			update_option('hsis_speed', $hsis_speed );
			
			?>
			<div class="updated fade">
				<p><strong><?php _e('Details successfully updated.', 'horizontal-scroll-image'); ?></strong></p>
			</div>
			<?php
		}
		?>
		<h3><?php _e('Plugin setting', 'horizontal-scroll-image'); ?></h3>
		<form name="hsis_form" method="post" action="#">
			
			<label for="tag-title"><?php _e('Title', 'horizontal-scroll-image'); ?></label>
			<input name="hsis_title" type="text" value="<?php echo $hsis_title; ?>"  id="hsis_title" size="70" maxlength="100">
			<p><?php _e('Please enter your widget title.', 'horizontal-scroll-image'); ?></p>
			
			<label for="tag-title"><?php _e('Width', 'horizontal-scroll-image'); ?></label>
			<input name="hsis_width" type="text" value="<?php echo $hsis_width; ?>"  id="hsis_width" maxlength="4">
			<p><?php _e('Please enter your slideshow width. <br />This width should be the largest image width in your slideshow.', 'horizontal-scroll-image'); ?> (Example: 205)</p>
			
			<label for="tag-title"><?php _e('Height', 'horizontal-scroll-image'); ?></label>
			<input name="hsis_height" type="text" value="<?php echo $hsis_height; ?>"  id="hsis_height" maxlength="4">
			<p><?php _e('Please enter your slideshow height, Only Number.', 'horizontal-scroll-image'); ?> (Example: 150)</p>
			
			<label for="tag-title"><?php _e('Bgcolor', 'horizontal-scroll-image'); ?></label>
			<input name="hsis_bgcolor" type="text" value="<?php echo $hsis_bgcolor; ?>"  id="hsis_bgcolor" maxlength="20">
			<p><?php _e('Please enter slideshow bgcolor,', 'horizontal-scroll-image'); ?> (Example: white)</p>
			
			<label for="tag-title"><?php _e('Speed', 'horizontal-scroll-image'); ?></label>
			<input name="hsis_speed" type="text" value="<?php echo $hsis_speed; ?>"  id="hsis_speed" maxlength="5">
			<p><?php _e('Please enter your slideshow speed, Only Number.', 'horizontal-scroll-image'); ?> (Example: 2000)</p>
			
			<input type="hidden" name="hsis_form_submit" value="yes"/>
			<input name="hsis_submit" id="hsis_submit" class="button" value="Submit" type="submit" />
			<a class="button" target="_blank" href="http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/"><?php _e('Help', 'horizontal-scroll-image'); ?></a>
			<?php wp_nonce_field('hsis_form_setting'); ?>
		</form>
		</div>
	<h3><?php _e('Plugin configuration option', 'horizontal-scroll-image'); ?></h3>
	<ol>
		<li><?php _e('Drag and drop the widget to your sidebar.', 'horizontal-scroll-image'); ?></li>
		<li><?php _e('Add directly in to the theme using PHP code.', 'horizontal-scroll-image'); ?></li>
	</ol>
	<p class="description"><?php _e('Check official website for more information', 'horizontal-scroll-image'); ?> 
	<a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/"><?php _e('click here', 'horizontal-scroll-image'); ?></a></p>
	</div>
	<?php
}

function hsis_control()
{
	echo '<p><b>';
	_e('Horizontal scroll image slideshow', 'horizontal-scroll-image');
	echo '.</b> ';
	_e('Check official website for more information', 'horizontal-scroll-image');
	?> <a target="_blank" href="http://www.gopiplus.com/work/2010/07/18/horizontal-scroll-image-slideshow/"><?php _e('click here', 'horizontal-scroll-image'); ?></a></p><?php
}

function hsis_widget_init()
{
	if(function_exists('wp_register_sidebar_widget')) 	
	{
		wp_register_sidebar_widget('horizontal-scroll-image-slideshow', __('Horizontal scroll image slideshow', 'horizontal-scroll-image'), 'hsis_widget');
	}
	
	if(function_exists('wp_register_widget_control')) 	
	{
		wp_register_widget_control('horizontal-scroll-image-slideshow', 
				array( __('Horizontal scroll image slideshow', 'horizontal-scroll-image'), 'widgets'), 'hsis_control');
	} 
}

function hsis_deactivation() 
{
	// No action required.
}

function hsis_add_to_menu() 
{
	if (is_admin()) 
	{
		add_options_page( __('Horizontal scroll image slideshow', 'horizontal-scroll-image'), 
				__('Horizontal scroll image slideshow', 'horizontal-scroll-image'), 'manage_options', 'horizontal-scroll-image-slideshow', 'hsis_admin_option' );
	}
}

function hsis_textdomain() 
{
	  load_plugin_textdomain( 'horizontal-scroll-image', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );
}

add_action('plugins_loaded', 'hsis_textdomain');
add_action('admin_menu', 'hsis_add_to_menu');
add_action("plugins_loaded", "hsis_widget_init");
register_activation_hook(__FILE__, 'hsis_install');
register_deactivation_hook(__FILE__, 'hsis_deactivation');
add_action('init', 'hsis_widget_init');
?>