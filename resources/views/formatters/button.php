<?php

if ($file && is_array($file) && isset($file['url'])) {
    echo sprintf('<a target="%s" class="et_pb_button et_pb_module et_pb_bg_layout_light %s" href="%s">%s</a>', $attrs['button_target'], $attrs['class_name'], $file['url'], $attrs['button_label']);
}
