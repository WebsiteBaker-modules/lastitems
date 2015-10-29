
USE THE SNIPPET THIS WAY:
*************************

In order to make use of the snippet "Lastitems" you must have installed the module Bakery.
You can use this snippet either in a code page or in your template.


1. In a code page:

display_last_items(number_of_items, number_of_columns, use_lightbox2);

where:
number_of_items = number of last added items to display
number_of_columns = number of columns to display ( 1 = vertical and > 1 = horizontal)
use_lightbox2 (optional) = set 1 for using Lightbox2 to show the item images, default = 0

e.g.:  display_last_items(4, 1);


2. In your template:

<?php display_last_items(4, 1); ?>



have fun


