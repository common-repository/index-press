<?php

/*
  Plugin Name: Index Press
  Plugin URI: http://plugins.grandslambert.com/plugins/index-press.html
  Description: Add an index page to your site that displays links to all pages and page sections.
  Author: grandslambert
  Version: 1.0
  Author URI: http://grandslambert.com/

 * *************************************************************************

  Copyright (C) 2009-2011 GrandSlambert

  This program is free software: you can redistribute it and/or modify
  it under the terms of the GNU General License as published by
  the Free Software Foundation, either version 3 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General License for more details.

  You should have received a copy of the GNU General License
  along with this program.  If not, see <http://www.gnu.org/licenses/>.

 * *************************************************************************

 */

class indexPress {
     /* Plugin settings */

     var $menuName = 'index-press';
     var $pluginName = 'Index Press';
     var $version = '1.0';
     var $optionsName = 'index-press-options';
     var $xmlURL = 'http://grandslambert.com/xml/index-press/';
     var $make_link = false;

     /**
      * Constructor Method.
      */
     function indexPress() {
          /* Load Langauge Files */
          $langDir = dirname(plugin_basename(__FILE__)) . '/lang';
          load_plugin_textdomain('index-press', false, $langDir, $langDir);

          $this->pluginName = __('Index Press', 'index-press');
          $this->pluginPath = WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__));
          $this->pluginURL = WP_PLUGIN_URL . '/' . basename(dirname(__FILE__));
          $this->templatesPath = WP_PLUGIN_DIR . '/' . basename(dirname(__FILE__)) . '/templates/';
          $this->templatesURL = WP_PLUGIN_URL . '/' . basename(dirname(__FILE__)) . '/templates/';
          $this->loadSettings();

          /* WordPress Actions */
          add_action('wp_loaded', array(&$this, 'wp_loaded'));
          add_action('wp_print_styles', array(&$this, 'wp_print_styles'));
          add_action('admin_init', array(&$this, 'admin_init'));
          add_action('query_vars', array(&$this, 'query_vars'));
          add_action('admin_menu', array(&$this, 'admin_menu'));
          add_action('save_post', array(&$this, 'update_index'));
          add_action('update_option_' . $this->optionsName, array(&$this, 'update_option'), 10);

          /* WordPress Filters */
          add_filter('plugin_action_links', array(&$this, 'plugin_action_links'), 10, 2);

          /* Add Shortcode handler */
          add_shortcode('index-press', array(&$this, 'index_press_shortcode'));

          /* Add filter to bold word */
          if ( $this->options['highlight_tag'] != 'none' ) {
               add_filter('the_content', array(&$this, 'the_content'));
          }
     }

     /**
      * Loads the plugin settings.
      */
     function loadSettings() {

          $defaults = array(
               'title' => __('Index', 'index-press'),
               'title_tag' => 'h3',
               'hide_title' => false,
               'min_count' => 3,
               'word_length' => 5,
               'columns' => 2,
               'blocked_words' => array("it's", "we'll", "you're", 'because', 'it’s', 'i’m', '$20 = ['),
               'post_types' => array('page'),
               'custom-css' => '.index-press-item {font-size: 12px;}',
               'highlight_tag' => 'strong',
          );

          $this->options = wp_parse_args(get_option($this->optionsName), $defaults);
     }

     /**
      * Filter the content to highlight the word.
      */
     function the_content($content) {
          global $wp_query;

          if ( isset($wp_query->query_vars['word']) ) {
               $word = $wp_query->query_vars['word'];
               $content = preg_replace('/' . $word . '/', '<' . $this->options['highlight_tag'] . '>' . $word . '</' . $this->options['highlight_tag'] . '>', $content);
          }
          return $content;
     }

     /**
      * Add query vars for modal windows
      */
     function query_vars($qvars) {
          $qvars[] = 'word';
          return $qvars;
     }

     /**
      * Register styles to load on web site.
      */
     function wp_loaded() {
          wp_register_style('indexPressCSS', $this->get_template('index-press', '.css', 'url'));
     }

     /**
      * Add the custom CSS from the settings page.
      */
     function wp_print_styles() {
          if ( $this->options['custom-css'] ) {
               echo '<style type="text/css" media="screen">' . "\n" . $this->options['custom-css'] . "\n</style>";
          }
     }

     /**
      * Admin Init Action
      */
     function admin_init() {
          register_setting($this->optionsName, $this->optionsName);
          wp_register_style('indexPressAdminCSS', $this->pluginURL . '/templates/index-press-admin.css');
          wp_register_script('indexPressAdminJS', $this->pluginURL . '/js/index-press-admin.js');
     }

     /**
      * Print the stylesheets needed for the admin.
      */
     function admin_print_styles() {
          wp_enqueue_style('indexPressAdminCSS');
     }

     /**
      * Print the scripts needed for the admin.
      */
     function admin_print_scripts() {
          wp_enqueue_script('indexPressAdminJS');
     }

     /**
      * Add the admin page for the settings panel.
      *
      * @global string $wp_version
      */
     function admin_menu() {
          global $wp_version;

          $page = add_options_page($this->pluginName, $this->pluginName, 'edit_posts', $this->menuName, array(&$this, 'options_panel'));

          add_action('admin_print_styles-' . $page, array(&$this, 'admin_print_styles'));
          add_action('admin_print_scripts-' . $page, array(&$this, 'admin_print_scripts'));

          // Use the bundled jquery library if we are running WP 2.5 or above
          if ( version_compare($wp_version, '2.5', '>=') ) {
               wp_enqueue_script('jquery', false, false, '1.2.3');
          }
     }

     /**
      * Add a configuration link to the plugins list.
      *
      * @staticvar object $this_plugin
      * @param array $links
      * @param array $file
      * @return array
      */
     function plugin_action_links($links, $file) {
          static $this_plugin;

          if ( !$this_plugin ) {
               $this_plugin = plugin_basename(__FILE__);
          }

          if ( $file == $this_plugin ) {
               $settings_link = '<a href="' . get_option('siteurl') . '/wp-admin/options-general.php?page=' . $this->menuName . '">' . __('Settings') . '</a>';
               array_unshift($links, $settings_link);
          }

          return $links;
     }

     /**
      * Check on update option to see if we need to reset the options.
      * @param <array> $input
      * @return <boolean>
      */
     function update_option($input) {
          if ( $_REQUEST['confirm-reset-options'] ) {
               delete_option($this->optionsName);
               wp_redirect(admin_url('options-general.php?page=index-press&tab=' . $_POST['active_tab'] . '&reset=true'));
               exit();
          } else {
               wp_redirect(admin_url('options-general.php?page=index-press&tab=' . $_POST['active_tab'] . '&updated=true'));
               exit();
          }
     }

     /**
      * Settings management panel.
      */
     function options_panel() {
          include($this->pluginPath . '/includes/settings.php');
     }

     /**
      * Retrieve a template file from either the theme or the plugin directory.
      *
      * @param <string> $template    The name of the template.
      * @return <string>             The full path to the template file.
      */
     function get_template($template = NULL, $ext = '.php', $type = 'path') {
          if ( $template == NULL )
               return false;
          $themeFile = get_theme_root() . '/' . get_template() . '/' . $template . $ext;

          if ( file_exists($themeFile) ) {
               if ( $type == 'url' ) {
                    $file = get_option('siteurl') . '/wp-content/themes/' . get_template() . '/' . $template . $ext;
               } else {
                    $file = get_theme_root() . '/' . get_template() . '/' . $template . $ext;
               }
          } elseif ( $type == 'url' ) {
               $file = $this->templatesURL . $template . $ext;
          } else {
               $file = $this->templatesPath . $template . $ext;
          }

          return $file;
     }

     /**
      * Updates the index. Called automatically when pages are saved. Can be called manually.
      *
      * @return <boolean>
      */
     function update_index() {
          $args = array(
               'sort_column' => 'post_title',
               'post_type' => $this->options['post_types'],
               'showposts' => -1, // Included since posts_per_page does not work properly.
               'posts_per_page' => -1
          );
          $thePages = get_posts($args);
          $this->pagesFound = count($thePages);

          $index = array();

          foreach ( $thePages as $page ) {
               $pages[$page->ID] = $page;
               $pages[$page->ID]->permalink = get_permalink($page->ID);
               $content = strip_tags($page->post_content);
               $content = preg_replace("/[^a-zA-Z0-9 -]/", " ", $content);
               $content = preg_replace("/\s+/s", " ", $content);
               $content = strtolower($content);

               $words = split(' ', $content);

               foreach ( $words as $word ) {
                    if ( $word and strlen($word) >= $this->options['word_length'] ) {

                         if ( isset($index[$word]['count']) ) {
                              $index[$word]['count'] += 1;
                         } else {
                              $index[$word]['count'] = 1;
                         }

                         if ( isset($index[$word]['pages']) ) {
                              $index[$word]['pages'][] = $page->ID;
                         } else {
                              $index[$word]['pages'] = array($page->ID);
                         }
                    }
               }
          }

          $totalRows = 0;

          foreach ( $index as $word => $data ) {
               $index[$word]['pages'] = array_unique($index[$word]['pages']);
               if ( $data['count'] < $this->options['min_count'] ) {
                    unset($index[$word]);
               } else {
                    $index[$word]['count'] = count($index[$word]['pages']);
                    if ( !in_array($word, $this->options['blocked_words']) ) {
                         $totalRows = $totalRows + 1 + $index[$word]['count'];
                    }
               }
          }

          ksort($index);

          update_option('index-press-words', $index);
          update_option('index-press-total', $totalRows);

          return false;
     }

     /**
      * Function to handle the shortcode.
      *
      * @param <array> $attrs
      * @return <string>
      */
     function index_press_shortcode($attrs) {
          extract(shortcode_atts(array(
                       'title' => $this->options['title'],
                       'title_tag' => $this->options['title_tag'],
                       'hide_title' => $this->options['hide_title'],
                       'columns' => $this->options['columns'],
                       'ignore' => false,
                          ), $attrs));

          if ( $ignore ) {
               return '[index-press]';
          }

          $words = get_option('index-press-words');
          $totalRows = get_option('index-press-total');

          if ( !$hide_title ) {
               $output = '<' . $title_tag . '>' . $title . '</' . $title_tag . '>';
          }

          $perCol = ceil($totalRows / $columns);
          $section = '';
          $colCount = 0;
          $column = 1;

          $topbar = '';
          $pages = array();

          $index = '<table id="index_press_table" class="index-press-table">';
          $index.= '<tr class="index-press-row"><td id="index_press_column_' . $column . '" class="index-press-column"><dl>';

          foreach ( $words as $word => $data ) {
               if ( $section != substr($word, 0, 1) and !in_array($word, $this->options['blocked_words']) ) {
                    $section = substr($word, 0, 1);
                    $index.= '<a name="section-' . $section . '"></a>';
                    $index.= '<dt id="index_press_section_' . $section . '" class="index-press-section">' . strtoupper($section) . '</dt>';
                    $topbar.= '<span class="index-press-section-topbar">[<a href="#section-' . $section . '" class="index-press-section-topbar-letter">' . $section . '</a>]</span>';
               }

               if ( !in_array($word, $this->options['blocked_words']) ) {
                    $index.= '<dd id="index_press_' . $word . '" class="index-press-word">' . $word . '<ul id="index-press-' . $word . '-list" class="index-press-list">';
                    ++$colCount;

                    foreach ( $data['pages'] as $page ) {
                         if ( !array_key_exists($page, $pages) ) {
                              $pages[$page] = get_page($page);
                              $pages[$page]->permalink = get_permalink($pages[$page]->ID);
                         }

                         $index.= '<li class="index-press-item"><a href="' . $pages[$page]->permalink . '?word=' . $word . '" class="index-press-link">' . $pages[$page]->post_title . '</a></li>';
                         ++$colCount;
                    }
                    $index.= '</ul></dd>';
               }
               if ( $colCount >= $perCol and $column < $columns ) {
                    ++$column;
                    $index.= '</dl></td><td id="index_press_column_' . $column . '" class="index-press-column"><dl>';
                    $index.= '<a name="section-' . $section . '"></a><dt>' . strtoupper($section) . ' (cont.)</dt>';
                    $colCount = 0;
               }
          }


          $index.= '</tr></table>';

          return $topbar . $index;
     }

     /**
      * Display the list of contributors.
      * @return boolean
      */
     function contributor_list() {
          $this->showFields = array('NAME', 'LOCATION', 'COUNTRY');
          print '<ul>';

          $xml_parser = xml_parser_create();
          xml_parser_set_option($xml_parser, XML_OPTION_CASE_FOLDING, true);
          xml_set_element_handler($xml_parser, array($this, "start_element"), array($this, "end_element"));
          xml_set_character_data_handler($xml_parser, array($this, "character_data"));

          if ( !(@$fp = fopen('http://grandslambert.com/xml/index-press/contributors.xml', "r")) ) {
               print 'There was an error getting the list. Try again later.';
               return;
          }

          while ($data = fread($fp, 4096)) {
               if ( !xml_parse($xml_parser, $data, feof($fp)) ) {
                    die(sprintf("XML error: %s at line %d",
                                    xml_error_string(xml_get_error_code($xml_parser)),
                                    xml_get_current_line_number($xml_parser)));
               }
          }

          xml_parser_free($xml_parser);
          print '</ul>';
     }

     /**
      * XML Start Element Procedure.
      */
     function start_element($parser, $name, $attrs) {
          if ( $name == 'NAME' ) {
               print '<li class="rp-contributor">';
          } elseif ( $name == 'ITEM' ) {
               print '<br><span class="rp_contributor_notes">Contributed: ';
          }

          if ( $name == 'URL' ) {
               $this->make_link = true;
          }
     }

     /**
      * XML End Element Procedure.
      */
     function end_element($parser, $name) {
          if ( $name == 'ITEM' ) {
               print '</li>';
          } elseif ( $name == 'ITEM' ) {
               print '</span>';
          } elseif ( in_array($name, $this->showFields) ) {
               print ', ';
          }

          $this->make_link = false;
     }

     /**
      * XML Character Data Procedure.
      */
     function character_data($parser, $data) {
          if ( $this->make_link ) {
               print '<a href="http://' . $data . '" target="_blank">' . $data . '</a>';
               $this->make_link = false;
          } else {
               print $data;
          }
     }

}

/* Instantiate the Plugin */
$INDEXPRESSOBJ = new indexPress;


