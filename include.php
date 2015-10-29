<?php

/*
  Snippet developed for the Open Source Content Management System Website Baker (http://websitebaker.org)
  Copyright (C) 2007, Christoph Marti

  LICENCE TERMS:
  This snippet is free software. You can redistribute it and/or modify it 
  under the terms of the GNU General Public License  - version 2 or later, 
  as published by the Free Software Foundation: http://www.gnu.org/licenses/gpl.html.

  DISCLAIMER:
  This snippet is distributed in the hope that it will be useful, 
  but WITHOUT ANY WARRANTY; without even the implied warranty of 
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the 
  GNU General Public License for more details.


 -----------------------------------------------------------------------------------------
  Code snippet Lastitems for Bakery 1.7 or later and Website Baker v2.8 or later
  The snippet is based on code posted in the Website Baker forum by fienieg and pcwacht,
  the Anynews snippet of Doc and the Anyitems snippet of Jan (Seagull)
 -----------------------------------------------------------------------------------------

*/


// Function to display last added bakery items on every page via (invoke function from template or code page)
if (!function_exists('display_last_items')) {
	function display_last_items($num_items, $num_cols, $use_lightbox2 = 0) {

		// Look for language file
		if(LANGUAGE_LOADED && !isset($MOD_BAKERY)) {
			include(WB_PATH.'/languages/EN.php');
			if(file_exists(WB_PATH.'/languages/'.LANGUAGE.'.php')) {
				include(WB_PATH.'/languages/'.LANGUAGE.'.php');
			}
			include(WB_PATH.'/modules/bakery/languages/EN.php');
			if(file_exists(WB_PATH.'/modules/bakery/languages/'.LANGUAGE.'.php')) {
				include(WB_PATH.'/modules/bakery/languages/'.LANGUAGE.'.php');
			}
		}




		// MAKE YOUR MODIFICATIONS TO THE LAYOUT OF THE ITEMS DISPLAYED
		// ************************************************************
		
		// Use this html for the layout
		$setting_header = '<table cellpadding="5" cellspacing="0" border="0" width="98%"><tr>';
		
		$setting_item_loop = '<td class="mod_bakery_main_td_f">
		[THUMB]
		<br />
		<a href="[LINK]"><span class="mod_bakery_main_title_f">[TITLE]</span></a>
		<br />
		[TXT_PRICE]: [CURRENCY] [PRICE]
		<br />
		[DESCRIPTION]
		</td>';
				
		$setting_footer = '</tr></table>';
		// end layout html




		// DO NOT CHANGE ANYTHING BEYOND THIS LINE UNLESS YOU KNOW WHAT YOU ARE DOING
		// **************************************************************************
				
		global $database;

		// Look for CSS
		echo "\n<style type='text/css'>";
		include(WB_PATH .'/modules/bakery/frontend.css');
		echo "\n</style>\n";
		
		// Get settings
		$query_settings = $database->query("SELECT shop_currency FROM ".TABLE_PREFIX."mod_bakery_general_settings");
		if($query_settings->numRows() > 0) {
			$fetch_settings = $query_settings->fetchRow();
			$setting_shop_currency = stripslashes($fetch_settings['shop_currency']);
		}

		$position = 0;

		// If requested include lightbox2 (css is appended to the frontend.css stylesheet)
		if($use_lightbox2 == 1) {
			?>
			<script type="text/javascript">window.jQuery || document.write('<script src="http://localhost/wb283/modules/bakery/jquery/jquery-1.7.2.min.js"><\/script>')</script>
			<script type="text/javascript" src="http://localhost/wb283/modules/bakery/lightbox2/js/lightbox.js"></script>
			<script type="text/javascript">
			//  Lightbox2 options
			$(function () {
			    var lightbox, options;
			    options = new LightboxOptions;
		
			    options.fileLoadingImage = 'http://localhost/wb283/modules/bakery/lightbox2/images/loading.gif';
			    options.fileCloseImage   = 'http://localhost/wb283/modules/bakery/lightbox2/images/close.png';
			    options.labelImage       = 'Bild';
			    options.labelOf          = 'von';
		
			    return lightbox          = new Lightbox(options);
			});
			</script>
			<?php
		}
		
		// Get prictures
		$imgs = array();
		$query_images = $database->query("SELECT * FROM ".TABLE_PREFIX."mod_bakery_images WHERE position = '1' AND active = '1'");
		while ($img = $query_images->fetchRow()) {
			$imgs[$img['item_id']] = $img;
		}

		// Query items
		$query_items = $database->query("SELECT item_id, title, price, link, description FROM ".TABLE_PREFIX."mod_bakery_items WHERE active = '1' AND title != '' ORDER BY modified_when DESC LIMIT ".$num_items);
		
		// Print header
		echo $setting_header;

		// Loop through and show items
		if($num_items > 0) {
			$counter = 0;
			while($item = $query_items->fetchRow()) {
				$item_id = stripslashes($item['item_id']);
				$title = htmlspecialchars(stripslashes($item['title']));
				// Work-out the item link
				$item_link = WB_URL.PAGES_DIRECTORY.$item['link'].PAGE_EXTENSION;
	
				// Item thumb(s) and image(s)
				// Initialize or reset thumb(s) and image(s) befor laoding next item
				$thumb_arr = array();
				$image_arr = array();
				$thumb = "";
				$image = "";
							
				// Prepare thumb and image directory pathes and urls
				$thumb_dir = WB_PATH.MEDIA_DIRECTORY.'/bakery/thumbs/item'.$item_id.'/';
				$img_dir = WB_PATH.MEDIA_DIRECTORY.'/bakery/images/item'.$item_id.'/';
				$thumb_url = WB_URL.MEDIA_DIRECTORY.'/bakery/thumbs/item'.$item_id.'/';
				$img_url = WB_URL.MEDIA_DIRECTORY.'/bakery/images/item'.$item_id.'/';
				
				// Check if the thumb and image directories exist
				if(is_dir($thumb_dir) && is_dir($img_dir)) {
					// Open the image directory then loop through its contents
					$dir = dir($img_dir);
					while (false !== $image_file = $dir->read()) {
						// Skip index file and pointers
						if(stripos($image_file, ".php") !== false || substr($image_file, 0, 1) == ".") {
							continue;
						}
						// Thumbs use .jpg extension only
						$thumb_file = str_replace(".png", ".jpg", $image_file);
						
						// Convert filename to lightbox2 title
						$img_title = str_replace(array(".png", ".jpg"), "", $image_file);
						$img_title = str_replace("_", " ", $img_title);
	
						// Make array of all item thumbs and images
						if(file_exists($thumb_dir.$thumb_file) && file_exists($img_dir.$image_file)) {
							// If needed add lightbox2 link to the thumb/image...
							if($use_lightbox2 == 1) {
								$thumb_prepend = "<a href='".$img_url.$image_file."' rel='lightbox[image_".$item_id."]' title='".$img_title."'><img src='";
								$img_prepend = "<a href='".$img_url.$image_file."' rel='lightbox[image_".$item_id."]' title='".$img_title."'><img src='";
								$thumb_append = "' alt='".$img_title."' title='".$img_title."' class='mod_bakery_main_thumb_f' /></a>";
								$img_append = "' alt='".$img_title."' title='".$img_title."' class='mod_bakery_main_img_f' /></a>";
							// ...else add thumb/image only
							} else {
								$thumb_prepend = "<a href='".$item_link."'><img src='";
								$img_prepend = "<img src='";
								$thumb_append = "' alt='".$img_title."' title='".$img_title."' class='mod_bakery_main_thumb_f' />";
								$img_append = "' alt='".$img_title."' title='".$img_title."' class='mod_bakery_main_img_f' />";
							}
							// Check if a main thumb/image is set
							//if($image_file == $item['main_image']) {
							if (isset($imgs[$item_id])) {
								$thumb = $thumb_prepend.$thumb_url.$thumb_file.$img_append;
								$image = $thumb_prepend.$img_url.$image_file.$img_append;
								continue;
							}
							// Make array
							$thumb_arr[] = $thumb_prepend.$thumb_url.$thumb_file.$thumb_append;
							$image_arr[] = $img_prepend.$img_url.$image_file.$img_append;
						}
					}
				}
				
				// Make strings for use in the item templates
				$thumbs = implode("\n", $thumb_arr);
				$images = implode("\n", $image_arr);

				// Replace vars with values
				$vars = array('[THUMB]', '[THUMBS]', '[IMAGE]', '[IMAGES]', '[TITLE]', '[PRICE]', '[DESCRIPTION]', '[CURRENCY]', '[LINK]', '[TXT_PRICE]');
				$values = array($thumb, $thumbs, $image, $images, stripslashes($item['title']), stripslashes($item['price']), stripslashes($item['description']), $setting_shop_currency, $item_link, $MOD_BAKERY['TXT_PRICE']);
				echo str_replace($vars, $values, $setting_item_loop);
				
				// Increment counter
				$counter = $counter + 1;
				// Check if we should end this row
				if($counter % $num_cols == 0 && $counter != $num_items) {
					echo "</tr><tr>";
				}
			}
		}
		
		// Print footer
		echo $setting_footer;
	}
	
}

?>
