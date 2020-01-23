<?php

$shortcode = sprintf('[et_pb_image admin_label="Image" src="%s" show_in_lightbox="%s" url_new_window="off" use_overlay="off" animation="%s" sticky="off" align="center" force_fullwidth="off" always_center_on_mobile="on" use_border_color="%s" border_color="%s" border_style="solid" /]', $image['url'], $attrs['show_in_lightbox'], $attrs['animation'], $attrs['use_border_color'], $attrs['border_color']);

echo do_shortcode($shortcode);
