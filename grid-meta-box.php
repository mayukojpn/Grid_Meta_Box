<?php
/**
 * @package Grid_Meta_Box
 * @version 0.1
 */
/*
Plugin Name: Grid Meta Box
Description: 投稿画面のメタボックスをグリッド表示します。
Plugin URI: http://wordpress.org/plugins/grid-meta-box/
Author: Mayuko Moriyama
Version: 0.1
Author URI: http://mayuko.me/
*/

if ( ! defined( 'GRID_META_BOX_PLUGIN_URL' ) ) { define( 'GRID_META_BOX_PLUGIN_URL', plugin_dir_url( __FILE__ ) ); }

function grid_meta_box_enqueue_scripts ()
{
  if ( get_user_meta( get_current_user_id(), 'grid_meta_box_setting' )[0] ) {
    wp_enqueue_script( 'jquery-masonry' );
    wp_enqueue_script( 'grid-meta-box', GRID_META_BOX_PLUGIN_URL . 'grid-meta-box.js', array( 'jquery-masonry' ) );
  }
}

function grid_meta_box_user_fields( $user )
{
  $grid_meta_box_setting = get_user_to_edit($user->ID)->grid_meta_box_setting;

  ?>
    <h3>グリッドエディタ</h3>

    <table class="form-table">
        <tr>
            <th><span>グリッドエディタ</span></th>
            <td>
                <input id="grid_meta_box" name="grid_meta_box" type="checkbox" <?php checked( $grid_meta_box_setting );?> />
                <label for="grid_meta_box" class="description">グリッドエディタを有効化します。</lavel>
            </td>
        </tr>
    </table>
  <?php
}

function grid_meta_box_save_user_fields( $user_id )
{
    if ( !current_user_can( 'edit_user', $user_id ) ) { return false; }
    else
    {
      $meta_value = isset( $_POST['grid_meta_box'] ) && 'on' == $_POST['grid_meta_box'] ? '1' : '';
      update_user_meta( $user_id, 'grid_meta_box_setting', $meta_value );
    }
}


function grid_meta_box_action_links ( $links ) {
  $mylinks = array(
    '<a href="' . get_edit_user_link( get_current_user_id() ) . '#grid_meta_box">設定</a>',
  );
  return array_merge( $links, $mylinks );
}

add_filter( 'plugin_action_links_' . plugin_basename(__FILE__), 'grid_meta_box_action_links' );
add_action( 'admin_init', 'grid_meta_box_enqueue_scripts' );
add_action( 'show_user_profile', 'grid_meta_box_user_fields' );
add_action( 'edit_user_profile', 'grid_meta_box_user_fields' );
add_action( 'personal_options_update',  'grid_meta_box_save_user_fields' );
add_action( 'edit_user_profile_update', 'grid_meta_box_save_user_fields' );
