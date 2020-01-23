#Divi Custom Post Builder


###Description.
This plugin provides the ability to select a Divi Global Layout for a custom post type. 

It also provides a shortcode to output data from ACF (Advanced custom fields) using standard and user-defined custom formatters.

In addition there is a **ACF - Button** divi module while allows to output an ACF file field as button element.


###ACF Shortcode Formatter.

A standard code for the ACF shortcode is given below.

<pre>[df_acf_field field='amenities' format_as='unordered_list' class_name='property-amenities']</pre>

Attributes details for the shortcode are explained below.

* **field** : Name of the ACF field for the given post type.
* **format_as**: A formatter function, which indicates the formatting that needs to be applied to the ACF field value. There are bunch of pre-set formatters available. We also provide the ability to pass a custom formatter functions via a filter hook.
* **class_name** : CSS class name which will usually is applied to the container of the rendered output. 

####Available Formatters.
**raw**: As the name suggests, the ACF field will be outputted as is.

**unordered_list**:  Usually used for a multi-select checkbox, this formatter outputs the selected choices using the **ul** element.

**image_slider** : An ACF gallery field can be converted to an image slider using this

**image_grid** : Seperate ACF fields can be displayed as an image grid. With this formatter one needs to use additional attributes such like fields='gallery_image_1,gallery_image_2,gallery_image_3' (which takes comma-separated field name as input) and items_per_row='3' atttribute which takes the number of grid items per row.

**image** :  Render an ACF image file field as an image.

####Custom Formatter.
One can pass a custom formatter to render the ACF as per need. One would usually write the code in a custom plugin or within a child theme's function.php file.

As an example,
<pre>
add_filter('df_acf_formatter_callbacks', 'render_amenities_acf_field');

function render_amenities_acf_field($callbacks){
	$callbacks['render_amenities'] = function($amenities, $attrs){
		$html = sprintf("&lt;div class='%s'&gt;", $attrs['class_name']);

		foreach($amenities as $amenity){
			$html .= sprintf('&lt;h5&gt;%s&lt;/h5&gt;', $amenities);
		}

		$html .= "&lt;/div&gt;";

		return $html;
	};

	return $callbacks;
}
</pre>

The **add_filter** call registers a function  render_amenities_acf_field which defines a callback for the custom renderer. In your shortcode pass format_as attribute value as `render_amenities` which is the key for the callback. 




