<?php

/*
Plugin Name: Horizontal scroll image slideshow
Plugin URI: http://gopi.coolpage.biz/demo/2009/10/27/horizontal-scroll-image-slideshow/
Description: This plug-in will create the Horizontal scroll image slideshow gallery at side sidebar widget see live demo.  
Author: Gopi.R
Version: 1.0
Author URI: http://gopi.coolpage.biz/demo/about/
Donate link: http://gopi.coolpage.biz/demo/2009/10/27/horizontal-scroll-image-slideshow/
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
    <script language="JavaScript1.2" src="<?php echo $hsis_pluginurl; ?>horizontal-scroll-image-slideshow.js"></script>
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
	add_option('hsis_width', "180");
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
	echo "<div class='wrap'>";
	echo "<h2>"; 
	echo wp_specialchars( "horizontal scroll image slideshow" ) ;
	echo "</h2>";
    
	$hsis_title = get_option('hsis_title');
	$hsis_width = get_option('hsis_width');
	$hsis_height = get_option('hsis_height');
	$hsis_bgcolor = get_option('hsis_bgcolor');
	$hsis_speed = get_option('hsis_speed');
	
	if ($_POST['hsis_submit']) 
	{
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
	}
	?>
	<form name="hsis_form" method="post" action="">
	<table width="100%" border="0" cellspacing="0" cellpadding="3"><tr><td align="left">
	<?php
	echo '<p>Title:<br><input  style="width: 450px;" maxlength="200" type="text" value="';
	echo $hsis_title . '" name="hsis_title" id="hsis_title" /></p>';
	
	echo '<p>Width:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $hsis_width . '" name="hsis_width" id="hsis_width" />Only Number (This width should be the LARGEST image width in your slideshow!)</p>';
	
	echo '<p>Height:<br><input  style="width: 100px;" maxlength="4" type="text" value="';
	echo $hsis_height . '" name="hsis_height" id="hsis_height" />Only Number</p>';
	
	echo '<p>Bgcolor:<br><input maxlength="10" style="width: 100px;" type="text" value="';
	echo $hsis_bgcolor . '" name="hsis_bgcolor" id="hsis_bgcolor" /></p>';
	
	echo '<p>Speed:<br><input maxlength="5" style="width: 100px;" type="text" value="';
	echo $hsis_speed . '" name="hsis_speed" id="hsis_speed" />Only Number</p>';
	
	echo '<input name="hsis_submit" id="hsis_submit" class="button-primary" value="Submit" type="submit" />';
	?>
	</td><td align="center" valign="middle"> <?php //if (function_exists (timepass)) timepass(); ?> </td></tr></table>
	</form>
    <hr />
    We can use this plug-in in two different way.<br />
	1.	Go to widget menu and drag and drop the "horizontal scroll image slideshow" widget to your sidebar location. or <br />
	2.	Copy and past the below mentioned code to your desired template location.

    <h2><?php echo wp_specialchars( 'Paste the below code to your desired template location!' ); ?></h2>
    <div style="padding-top:7px;padding-bottom:7px;">
    <code style="padding:7px;">
    &lt;?php if (function_exists (hsis_show)) hsis_show(); ?&gt;
    </code></div>
    <h2><?php echo wp_specialchars( 'About Plugin' ); ?></h2>
    Plug-in created by <a target="_blank" href='http://gopi.coolpage.biz/demo/about/'>Gopi</a>. <br> 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/10/27/horizontal-scroll-image-slideshow/'>click here</a> To post suggestion or comments or how to improve this plugin. <br> 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/10/27/horizontal-scroll-image-slideshow/'>click here</a> To see LIVE demo. <br> 
    <a target="_blank" href='http://gopi.coolpage.biz/demo/2009/10/27/horizontal-scroll-image-slideshow/'>click here</a> To download my other plugins. <br> 
    </p>
    <h2><?php echo wp_specialchars( 'Paypal Donate' ); ?></h2>
    <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
    <input type="hidden" name="cmd" value="_s-xclick">
    <input type="hidden" name="hosted_button_id" value="6780953">
    <input type="image" src="https://www.paypal.com/en_US/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
    <img alt="" border="0" src="https://www.paypal.com/en_US/i/scr/pixel.gif" width="1" height="1">
    </form>
    
	<?php
	echo "</div>";
}

function hsis_control()
{
	echo '<p>horizontal scroll image slideshow.<br> To change the setting goto horizontal scroll image slideshow link under SETTING tab.';
	echo ' <a href="options-general.php?page=horizontal-scroll-image-slideshow/horizontal-scroll-image-slideshow.php">';
	echo 'click here</a></p>';
}

function hsis_widget_init() 
{
  	register_sidebar_widget(__('horizontal scroll image slideshow'), 'hsis_widget');   
	
	if(function_exists('register_sidebar_widget')) 	
	{
		register_sidebar_widget('horizontal scroll image slideshow', 'hsis_widget');
	}
	
	if(function_exists('register_widget_control')) 	
	{
		register_widget_control(array('horizontal scroll image slideshow', 'widgets'), 'hsis_control');
	} 
}

function hsis_deactivation() 
{
	delete_option('hsis_title');
	delete_option('hsis_width');
	delete_option('hsis_height');
	delete_option('hsis_bgcolor');
	delete_option('hsis_speed');
}

function hsis_add_to_menu() 
{
	add_options_page('horizontal scroll image slideshow', 'horizontal scroll image slideshow', 7, __FILE__, 'hsis_admin_option' );
}

add_action('admin_menu', 'hsis_add_to_menu');
add_action("plugins_loaded", "hsis_widget_init");
register_activation_hook(__FILE__, 'hsis_install');
register_deactivation_hook(__FILE__, 'hsis_deactivation');
add_action('init', 'hsis_widget_init');
?>
