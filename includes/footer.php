<?php
if ( preg_match('#' . basename(__FILE__) . '#', $_SERVER['PHP_SELF']) ) {
     die('You are not allowed to call this page directly.');
}
/**
 * footer.php - View for the footer on all plugin pages.
 *
 * @package Index Press
 * @subpackage includes
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.1
 */
?>

<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;">
          <?php _e('Plugin Information', 'index-press'); ?>
     </h3>
     <div style="padding:5px;">
          <p><?php _e('This page sets the defaults for the plugin. Each of these settings can be overridden when you add an index to your page.', 'index-press'); ?></p>
          <p><span><?php _e('You are using', 'index-press'); ?> <strong> <a href="http://plugins.grandslambert.com/plugins/index-press.html" target="_blank"><?php echo $this->pluginName; ?> <?php echo $this->version; ?></a></strong> by <a href="http://grandslambert.com" target="_blank">GrandSlambert</a>.</span> </p>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;">
          <?php _e('Usage', 'index-press'); ?>
     </h3>
     <div style="padding:5px;">
          <p><?php printf(__('After setting the defaults, you can add indexes to your pages using the [index-press] shortcode. Each of the defaults to the left can be overridden for each individual instance. See the %2s for this plugin for more details.'),
                  '<a href="http://docs.grandslambert.com/wiki/Index_Press" target="_blank">' . __('Short Code Settings', 'index-press') . '</a>'); ?></p>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;">
          <?php _e('Recent Contributors'); ?>
     </h3>
     <div style="padding:5px;">
          <p><?php _e('GrandSlambert would like to thank these wonderful contributors to this plugin!', 'index-press'); ?></p>
          <?php $this->contributor_list(); ?>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Credits', 'index-press'); ?></h3>
     <div style="padding:8px;">
          <p>
               <?php
               printf(__('Thank you for trying the %1$s plugin - I hope you find it useful. For the latest updates on this plugin, vist the %2$s. If you have problems with this plugin, please use our %3$s or check out the %4$s.', 'index-press'),
                       $this->pluginName,
                       '<a href="http://plugins.grandslambert.com/plugins/index-press.html" target="_blank">' . __('official site', 'index-press') . '</a>',
                       '<a href="http://support.grandslambert.com/forum/index-press" target="_blank">' . __('Support Forum', 'index-press') . '</a>',
                       '<a href="http://docs.grandslambert.com/wiki/Index_Press" target="_blank">' . __('Documentation Page', 'index-press') . '</a>'
               );
               ?>
          </p>
          <p>
               <?php
               printf(__('This plugin is &copy; %1$s by %2$s and is released under the %3$s', 'index-press'),
                       '2009-' . date("Y"),
                       '<a href="http://grandslambert.com" target="_blank">GrandSlambert, Inc.</a>',
                       '<a href="http://www.gnu.org/licenses/gpl.html" target="_blank">' . __('GNU General Public License', 'index-press') . '</a>'
               );
               ?>
          </p>
     </div>
</div>
<div class="postbox">
     <h3 class="handl" style="margin:0; padding:3px;cursor:default;"><?php _e('Donate', 'index-press'); ?></h3>
     <div style="padding:8px">
          <p>
               <?php printf(__('If you find this plugin useful, please consider supporting this and our other great %1$s.', 'index-press'), '<a href="http://plugins.grandslambert.com/" target="_blank">' . __('plugins', 'index-press') . '</a>'); ?>
               <a href="http://plugins.grandslambert.com/index-press-donate" target="_blank"><?php _e('Donate a few bucks!', 'index-press'); ?></a>
          </p>
          <p style="text-align: center;"><a target="_blank" href="http://plugins.grandslambert.com/index-press-donate"><img width="122" height="47" alt="paypal_btn_donateCC_LG" src="http://grandslambert.com/paypal.gif" title="paypal_btn_donateCC_LG" class="aligncenter size-full wp-image-174"/></a></p>
     </div>
</div>
