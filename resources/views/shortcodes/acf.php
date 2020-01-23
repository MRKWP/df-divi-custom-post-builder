<?php
global $post;
$fieldValue =  get_field($attrs['field'], $post->ID);
// var_dump($fieldValue);
echo $this->container['acf_shortcode']->formatField($fieldValue, $attrs);
