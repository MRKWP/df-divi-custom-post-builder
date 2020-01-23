<?php

$sliderOptionsFlattened = array();
foreach ($sliderOptions as $key => $value) {
    $sliderOptionsFlattened[] = sprintf('%s="%s"', $key, $value);
}


$shortcode = array();

$shortcode[] = sprintf('[et_pb_slider %s]', implode(' ', $sliderOptionsFlattened));

foreach ($images as $image) {
    $shortcode[] = sprintf('[et_pb_slide background_position="center" background_size="cover" background_color="#ffffff" use_bg_overlay="off" use_text_overlay="off" alignment="center" background_layout="dark" allow_player_pause="off" text_border_radius="3" header_font_select="default" header_font="||||" body_font_select="default" body_font="||||" custom_button="off" button_font_select="default" button_font="||||" button_use_icon="default" button_icon_placement="right" button_on_hover="on" background_image="%s"]
[/et_pb_slide]', $image['url']);
}


$shortcode[] = '[/et_pb_slider]';

echo do_shortcode(implode('', $shortcode));
