<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * words.php - View for the words tab.
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
          <?php _e('Words to Hide', 'index-press'); ?>
     </h3>
     <div class="table">
          <table class="form-table">
               <tr align="top">
                    <td id="word_list">
                         <?php
                         $this->update_index();
                         printf(__('The following words were located within the %1$s pages on your site using the settings on the defaults tab. Check the words you want to hide in your indexes.', 'index-press'), $this->pagesFound);
                         ?>
                         <div class="cleared"></div>
                         <?php
                         $words = get_option('index-press-words');
                         //print_r($words);
                         foreach ( $words as $word => $data ) : ?>
                              <label class="index-press-hide-word"><input class="index-press-checkbox" type="checkbox" name="<?php echo $this->optionsName; ?>[blocked_words][]" value="<?php echo $word; ?>" <?php checked(in_array($word, $this->options['blocked_words']), 1); ?> /> <?php echo $word; ?></label>
                         <?php endforeach; ?>

                         </td>
                    </tr>
                    <tr align="top">
                         <td>
                              <label class="index-press-hide-word"><input type="checkbox" name="index-press-check-all" id="index_press_check_all" onclick="index_press_check('all');"><?php _e('Check All', 'index-press'); ?></label>
                              <label class="index-press-hide-word"><input type="checkbox" name="index-press-check-none" id="index_press_check_none" onclick="index_press_check('none');"><?php _e('Check None', 'index-press'); ?></label>
                              <label class="index-press-hide-word"><input type="checkbox" name="index-press-check-invert" id="index_press_check_invert" onclick="index_press_check('invert');"><?php _e('Invert Checks', 'index-press'); ?></label>
                    </td>
               </tr>
          </table>
     </div>
</div>