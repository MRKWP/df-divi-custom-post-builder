<?php
if ($images && is_array($images)) {
    echo sprintf("<ul class='%s'>", $attrs['class_name']);

    foreach ($images as $image) {
        $url = ($attrs['use_size'] == 'on') ? $image['sizes'][$attrs['size']] : $image['url'];
        if ($image) {
            $output = '';
            $output .= "<li>";
            $shortcode =  do_shortcode(sprintf('[et_pb_image admin_label="Image" src="%s" show_in_lightbox="%s" url_new_window="off" use_overlay="on" animation="%s" sticky="off" align="center" force_fullwidth="off" always_center_on_mobile="on" use_border_color="%s" border_color="%s" border_style="solid"]
    [/et_pb_image]', $url, $attrs['show_in_lightbox'], $attrs['animation'], $attrs['use_border_color'], $attrs['border_color']));
            if ($attrs['show_in_lightbox'] == 'on') {
                // replace the lightbox image url with original size.
                $dom = new \DOMDocument();
                $dom->loadHTML($shortcode);

                $anchors = $dom->getElementsByTagName('a');
                foreach ($anchors as $a) {
                    $href = $a->getAttribute('href');

                    $a->setAttribute('href', $image['url']);
                }

                $shortcode = $dom->saveHTML();
            }
            $output .= $shortcode;
            $output .= "</li>";

            echo $output;
        }
    }

    echo "</ul>";
}
?>

<style>
    ul.<?php echo $attrs['class_name'];?> li{
        display:inline-block;
        width: <?php echo (int) (100/$attrs['items_per_row']) ?>%;
        padding: 2%;
    }
</style>