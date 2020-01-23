<?php if (isset($attrs['title']) && $attrs['title']) : ?>
    <strong><?php echo $attrs['title'] ?></strong>
<?php endif; ?>
<ul class='<?php echo $attrs['class_name'] ?>'>
    <?php foreach ($options as $item) : ?>
        <li>
            <?php
            if (isset($attrs['is_post']) && ($attrs['is_post'] == 'true')) {
                echo $item->post_title;
            } else {
                echo $item;
            }
                ?>
            </li>
    <?php endforeach; ?>
    
</ul>