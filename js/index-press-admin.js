/**
 * index-press-admin.js - Javascript for the settings page.
 *
 * @package Index Press
 * @subpackage js
 * @author GrandSlambert
 * @copyright 2009-2011
 * @access public
 * @since 0.1
 */

/* Function to change tabs on the settings pages */
function index_press_show_tab(tab) {
     /* Close Active Tab */
     activeTab = document.getElementById('active_tab').value;
     document.getElementById('index_press_box_' + activeTab).style.display = 'none';
     document.getElementById('index_press_' + activeTab).removeAttribute('class','index-press-selected');

     /* Open new Tab */
     document.getElementById('index_press_box_' + tab).style.display = 'block';
     document.getElementById('index_press_' + tab).setAttribute('class','index-press-selected');
     document.getElementById('active_tab').value = tab;
}

/* Function to verify selection to reset options */
function verifyResetOptions(element) {
     if (element.checked) {
          if (prompt('Are you sure you want to reset all of your options? To confirm, type the word "reset" into the box.') == 'reset' ) {
               document.getElementById('index_press_settings').submit();
          } else {
               element.checked = false;
          }
     }
}

/* Check word boxes */
function index_press_check(type) {
     var boxes = document.getElementById('index_press_settings').elements;

     for (ctr = 0; ctr < boxes.length; ctr++) {
          if (boxes[ctr].className == 'index-press-checkbox') {
               switch (type) {
                    case 'all':
                         boxes[ctr].checked = true;
                         document.getElementById('index_press_check_all').checked = true;
                         break;
                    case 'none':
                         boxes[ctr].checked = false;
                         document.getElementById('index_press_check_none').checked = false;
                         break;
                    case 'invert':
                         boxes[ctr].checked = !boxes[ctr].checked;
                         break;
                    default:
                         boxes[ctr].checked = false;
               }
          }
     }

     /* Clear global boxes */
     document.getElementById('index_press_check_all').checked = false;
     document.getElementById('index_press_check_none').checked = false;
     document.getElementById('index_press_check_invert').checked = false;
}
