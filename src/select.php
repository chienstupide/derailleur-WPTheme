<label for="<?= $name; ?>"> <?= $label; ?> </label>
<select name="<?= $name; ?>" id="<?= $name; ?>" class="postbox">
    <?php
    foreach($field['option'] as $option){
       echo '<option value="'.$option.'" '.selected( $value, $option, false ).'>'.$option.'</option>';
        }
    ?>
</select>