<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * features.php - View for the features tab.
 *
 * @package Index Press
 * @subpackage includes/settings
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.6
 */
?>
<div class="postbox">
     <h3 class="handl" style="margin:0;padding:3px;cursor:default;">
          <?php _e('Default Display Settings', 'index-press'); ?>
     </h3>
     <div class="table">
          <table class="form-table">
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_title"><?php _e('Default Title', 'index-press'); ?></label></th>
                    <td ><input  name="<?php echo $this->optionsName; ?>[title]" type="text" id="<?php echo $this->optionsName; ?>_title" value="<?php echo $this->options['title']; ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_title_tag"><?php _e('HTML tag for title', 'index-press'); ?></label></th>
                    <td ><input name="<?php echo $this->optionsName; ?>[title_tag]" type="text" id="<?php echo $this->optionsName; ?>_title_tag" value="<?php echo $this->options['title_tag']; ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_hide_title"><?php _e('Hide Title on Index?', 'index-press'); ?></label></th>
                    <td ><input name="<?php echo $this->optionsName; ?>[hide_title]" type="checkbox" id="<?php echo $this->optionsName; ?>_hide_title" value="1" <?php checked($this->options['hide_title'], 1); ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_highlight_word"><?php _e('Highlight Word', 'index-press'); ?></label></th>
                    <td >
                         <select name="<?php echo $this->optionsName; ?>[highlight_tag]" id="<?php echo $this->optionsName; ?>highlight_tag">
                              <option value="none" <?php selected($this->options['highlight_tag'], 'none'); ?>><?php _e('None', 'index-press'); ?></option>
                              <option value="strong" <?php selected($this->options['highlight_tag'], 'strong'); ?>><?php _e('Bold', 'index-press'); ?></option>
                              <option value="em" <?php selected($this->options['highlight_tag'], 'em'); ?>><?php _e('Italic', 'index-press'); ?></option>
                         </select>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_min_count"><?php _e('Minimum count for index', 'index-press'); ?></label></th>
                    <td ><input name="<?php echo $this->optionsName; ?>[min_count]" type="text" id="<?php echo $this->optionsName; ?>_min_count" value="<?php echo $this->options['min_count']; ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_word_length"><?php _e('Shortest word to index', 'index-press'); ?></label></th>
                    <td ><input name="<?php echo $this->optionsName; ?>[word_length]" type="text" id="<?php echo $this->optionsName; ?>_word_length" value="<?php echo $this->options['word_length']; ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_columns"><?php _e('Number of columns to display', 'index-press'); ?></label></th>
                    <td ><input name="<?php echo $this->optionsName; ?>[columns]" type="text" id="<?php echo $this->optionsName; ?>_columns" value="<?php echo $this->options['columns']; ?>" /></td>
               </tr>
               <tr align="top">
                    <th scope="row"><label for="<?php echo $this->optionsName; ?>_post_types"><?php _e('Post Types to Include', 'index-press'); ?></label></th>
                    <td>
                         <?php
                         if ( function_exists('get_post_types') ) {
                              $types = get_post_types(array('public' => true));
                         } else {
                              $types = array('post', 'page');
                         }
                         ?>

                         <?php foreach ( $types as $type ) : ?>
                              <label class="index-press-post-type"><input type="checkbox" name="<?php echo $this->optionsName; ?>[post_types][]" value="<?php echo $type; ?>" <?php checked(in_array($type, $this->options['post_types']), 1); ?> /> <?php echo ucfirst($type); ?></label>
                              <?php endforeach; ?>

                    </td>
               </tr>
          </table>
     </div>
</div>