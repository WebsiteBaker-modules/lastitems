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
  Code snippet Lastitems for Website Baker v2.6.x
  The snippet is based on code posted in the Website Baker forum by fienieg and pcwacht,
  the Anynews snippet of Doc and the Anyitems snippet of Jan (Seagull)
 -----------------------------------------------------------------------------------------

 
	DEVELOPMENT HISTORY:

	 v0.6  (02/17/2013)
	 ! works with bakery 1.7 now

   v0.5  (Christoph Marti; 06/19/2009)
	 + [include.php] Various modifications and bugfixes to make lastitems compatible to Bakery v1.3.x

   v0.4  (Christoph Marti; 01/03/2009)
	 + [include.php] Adapted lastitems to Bakeries v0.9.7 new URL handling (links without either domain names or page directories)
	 + Bugfix: Removed alt attribute in the <a> tag of the thumbs (thanks to heinerle)
	 + Bugfix: Added alt attribute to the thumbs <img> tag (thanks to heinerle)
	 + Bugfix: Omit a new table row <tr></tr> when a item table is completed (thanks to heinerle)

   v0.3  (Christoph Marti; 08/27/2008)
	 + [include.php] Bugfix: To include the language file replaced function require_once() by include()
	   Prevents FATAL ERROR when language file is included second by the lastitems snippet
	 + [include.php] Bugfix: Using Bakery with a snippet like lastitems on the same page caused a notice
	   due to the in the snippet already defined constants THUMB_PREPEND, THUMB_APPEND and NEW_ROW

 -----------------------------------------------------------------------------------------
*/


$module_directory     = 'lastitems';
$module_name          = 'Bakery Lastitems';
$module_function      = 'snippet';
$module_version       = '0.6';
$module_platform      = '2.8';
$module_author        = 'Christoph Marti';
$module_license       = 'GNU General Public License';
$module_description   = 'Snippet to display the last added Bakery items on any page you want. <b>Requires Bakery &ge; v1.3</b><br />Function can be invoked from the template or a code section. Customized call: display_last_items(num_items, num_cols). The snippet is based upon code posted by fienieg and pcwacht in the Website Baker forum, the Anynews snippet by doc and the Anyitems snippet by Jan (Seagull)';
?>
