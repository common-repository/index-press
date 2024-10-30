<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * css.php - View for the css tab.
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
          <?php _e('Custom CSS', 'index-press'); ?>
     </h3>
     <div class="table">
          <table class="form-table">
               <tr align="top">
                    <td><textarea rows="10" cols="50" name="<?php echo $this->optionsName; ?>[custom-css]" id="index_press_custom_css"><?php echo $this->options['custom-css']; ?></textarea></td>
               </tr>
          </table>
     </div>
</div>