<label>
	<span class="customize-control-title"><?php echo esc_html($this->label); ?></span>
    <select <?php $this->link(); ?>>
        <?php
        while ($latest->have_posts()) {
            $latest->the_post();
            echo "<option " . selected($this->value(), get_the_ID()) . " value='" . get_the_ID() . "'>" . the_title('', '', false) . "</option>";
        }
        ?>
    </select>
</label>