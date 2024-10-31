<?php
namespace Popx;
 /**
  * 
  * @package    Popx
  * @version    1.0.0
  * @author     wpmobo
  * @Websites: http://wpmobo.com
  *
  */
 
  if( ! defined( 'ABSPATH' ) ) {
    die( POPX_ALERT_MSG );
  }

class Meta_Base {

  public static $getFields;

  function __construct() {
    add_action( 'add_meta_boxes', [ __CLASS__, 'register_meta_boxes' ] );
    add_action( 'save_post', [ __CLASS__, 'save_meta_data' ] );

    self::$getFields = new \Popx\Core\Fields\Fields_Maping();

    self::$getFields->scripts();
  }

  /**
   * Register meta box
   * 
   */
  public static function register_meta_boxes() {
    add_meta_box( 'popx-popup-meta', esc_html__( 'Set Popup Options', 'popx-popup-builder' ), [__CLASS__, 'display_callback'], 'popx_popup' );
  }

  /**
   * Meta box display callback.
   *
   * @param WP_Post $post Current post object.
   */
  public static function display_callback( $post ) {
    $position = get_post_meta( $post->ID, '_popx_popup_position', true );
    $activePopup = get_post_meta( $post->ID, '_popx_active_popup', true );
    $bgOverly = get_post_meta( $post->ID, '_popx_popup_bg_overly', true );
    $delayTime = get_post_meta( $post->ID, '_popx_popup_delay_time', true );
    $width = get_post_meta( $post->ID, '_popx_popup_popup_width', true );
    $height = get_post_meta( $post->ID, '_popx_popup_popup_height', true );
    $wrapPadding = get_post_meta( $post->ID, '_popx_popup_wrap_padding', true );
    $wrapBorder = get_post_meta( $post->ID, '_popx_popup_wrap_border', true );
    $wrapBgColor = get_post_meta( $post->ID, '_popx_popup_wrap_bg_color', true );
    $wrapBgImg = get_post_meta( $post->ID, '_popx_popup_wrap_bg_img', true );

    $wrapBoxShadow = get_post_meta( $post->ID, '_popx_popup_wrap_box_shadow', true );
    $wrapBorderRadius = get_post_meta( $post->ID, '_popx_popup_wrap_border_radius', true );
    $displayPageType = get_post_meta( $post->ID, '_popx_display_page_type', true );
    $displayPages = get_post_meta( $post->ID, '_popx_display_pages', true );
    $exitPopups = get_post_meta( $post->ID, '_popx_exit_popups', true );
    $overlyColor = get_post_meta( $post->ID, '_popx_popup_overly_color', true );
    $positionZIndex = get_post_meta( $post->ID, '_popx_popup_position_z_index', true );


    // Fields 
    $getFields = self::$getFields;

    ?>
    <div class="popx-meta-content-box">
      
      <div class="popx-meta-tabs">
        <ul>
          <li id="settings_tab" class="popx-tab popx-active"><span><img src="<?php echo esc_url( POPX_DIR_URL.'core/fields/assets/icon/settings.svg' ); ?>" /></span> <?php esc_html_e( 'Settings', 'popx-popup-builder' ); ?> </li>
          <li id="settings_style" class="popx-tab"><span><img src="<?php echo esc_url( POPX_DIR_URL.'core/fields/assets/icon/style.svg' ); ?>" /></span> <?php esc_html_e( 'Style', 'popx-popup-builder' ); ?> </li>
        </ul>
      </div>

      <div class="popx-meta-tabs-content-area">

        <div data-tabref="settings_tab" class="popx-meta-tab-content popx-active">
          <?php
          $getFields->switcher_field(
            [
              'title' => esc_html__( 'Active Popup', 'popx-popup-builder' ),
              'name' => 'active_popup',
              'value' => $activePopup
            ]
          );
          $getFields->select_field(
            [
              'title' => esc_html__( 'Popup Position', 'popx-popup-builder' ),
              'name' => 'popup_position',
              'value' => $position,
              'options' => [
                  'top-right'     => esc_html__( 'Top Right', 'popx-popup-builder' ),
                  'top-left'      => esc_html__( 'Top Left', 'popx-popup-builder' ),
                  'center'        => esc_html__( 'Center', 'popx-popup-builder' ),
                  'bottom-right'  => esc_html__( 'Bottom Right', 'popx-popup-builder' ),
                  'bottom-left'   => esc_html__( 'Bottom Left', 'popx-popup-builder' ),
              ]
            ]
          );
    
          $getFields->select_field(
            [
              'title' => esc_html__( 'Display Page Type', 'popx-popup-builder' ),
              'name' => 'display_page_type',
              'value' => $displayPageType,
              'options' => [
                  'entire-pages'     => esc_html__( 'Entire Pages', 'popx-popup-builder' ),
                  'singular-archive'      => esc_html__( 'Singular and Archive Pages', 'popx-popup-builder' ),
                  'specific-pages'        => esc_html__( 'Specific Pages', 'popx-popup-builder' ),
              ]
            ]
          );
          
          $getFields->select_field(
            [
              'title' => esc_html__( 'Pages', 'popx-popup-builder' ),
              'name' => 'display_pages',
              'value' => $displayPages,
              'options' => \Popx\Helper::getPagesList(),
              'condition' => [ 'display_page_type' => ['specific-pages'] ]
            ]
          );
          $getFields->number_field(
            [
              'title' => esc_html__( 'Popup Width', 'popx-popup-builder' ),
              'name' => 'popup_width',
              'value' => $width
            ]
          );


          $getFields->number_field(
            [
              'title' => esc_html__( 'Popup Height', 'popx-popup-builder' ),
              'name' => 'popup_height',
              'value' => $height
            ]
          );
          $getFields->switcher_field(
            [
              'title' => esc_html__( 'Exit Popups', 'popx-popup-builder' ),
              'name' => 'exit_popups',
              'value' => $exitPopups,
              'description' => esc_html__( 'Display popups when users leave website.', 'popx-popup-builder' )
            ]
          );
          $getFields->number_field(
            [
              'title' => esc_html__( 'Popup Show Delay Time', 'popx-popup-builder' ),
              'name' => 'delay_time',
              'value' => $delayTime
            ]
          );
          ?>
        </div>
        <div data-tabref="settings_style" class="popx-meta-tab-content popx-hide">
          <?php
          $getFields->select_field(
            [
              'title' => esc_html__( 'Position ( for z-index fix )', 'popx-popup-builder' ),
              'name' => 'position_z_index',
              'value' => $positionZIndex,
              'options' => [
                  'default'   => esc_html__( 'Default', 'popx-popup-builder' ),
                  'relative'  => esc_html__( 'Relative', 'popx-popup-builder' )
              ],
              'description' => esc_html__( 'Use Relative, if the popup overlaps with other elements.', 'popx-popup-builder' )
            ]
          );
          $getFields->dimension_field(
            [
              'title' => esc_html__( 'Wrapper Padding', 'popx-popup-builder' ),
              'name' => 'popup_wrap_padding',
              'value' => $wrapPadding
            ]
          );
          $getFields->border_field(
            [
              'title' => esc_html__( 'Wrapper Border', 'popx-popup-builder' ),
              'name' => 'popup_wrap_border',
              'value' => $wrapBorder
            ]
          );

          $getFields->border_radius_field(
            [
              'title' => esc_html__( 'Wrapper Border Radius', 'popx-popup-builder' ),
              'name' => 'popup_wrap_border_radius',
              'value' => $wrapBorderRadius
            ]
          );

          $getFields->box_shadow_field(
            [
              'title' => esc_html__( 'Wrapper Box Shadow', 'popx-popup-builder' ),
              'name' => 'popup_wrap_box_shadow',
              'value' => $wrapBoxShadow
            ]
          );

          $getFields->color_field(
            [
              'title' => esc_html__( 'Wrapper Background Color', 'popx-popup-builder' ),
              'name' => 'popup_wrap_bg_color',
              'value' => $wrapBgColor
            ]
          );
          $getFields->media_markup(
            [
              'title' => esc_html__( 'Wrapper Background Image', 'popx-popup-builder' ),
              'name' => 'popup_wrap_bg_img',
              'value' => $wrapBgImg
            ]
          );
          $getFields->switcher_field(
            [
              'title' => esc_html__( 'Background Overly', 'popx-popup-builder' ),
              'name' => 'active_bg_overly',
              'value' => $bgOverly
            ]
          );
          $getFields->color_field(
            [
              'title' => esc_html__( 'Overly Color', 'popx-popup-builder' ),
              'name' => 'popup_overly_color',
              'value' => $overlyColor
            ]
          );
          ?>
        </div>

      </div>

    </div>
    <?php


  }
  
  public static function save_meta_data( $post_id ) {

      //
      update_post_meta( $post_id, '_popx_popup_position', sanitize_text_field(  $_POST['popup_position'] ?? ''  ) );
      update_post_meta( $post_id, '_popx_active_popup', sanitize_text_field( $_POST['active_popup'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_bg_overly', sanitize_text_field( $_POST['active_bg_overly'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_overly_color', sanitize_text_field( $_POST['popup_overly_color'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_delay_time', sanitize_text_field( $_POST['delay_time'] ?? '' ) );
      update_post_meta( $post_id, '_popx_display_page_type', sanitize_text_field( $_POST['display_page_type'] ?? '' ) );

      update_post_meta( $post_id, '_popx_display_pages', sanitize_text_field( $_POST['display_pages'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_position_z_index', sanitize_text_field( $_POST['position_z_index'] ?? '' ) );

      update_post_meta( $post_id, '_popx_popup_popup_width', sanitize_text_field( $_POST['popup_width'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_popup_height', sanitize_text_field( $_POST['popup_height'] ?? '' ) );
      update_post_meta( $post_id, '_popx_exit_popups', sanitize_text_field( $_POST['exit_popups'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_wrap_padding', array_map( 'sanitize_text_field', $_POST['popup_wrap_padding'] ?? [] ) );

      update_post_meta( $post_id, '_popx_popup_wrap_bg_color', sanitize_text_field( $_POST['popup_wrap_bg_color'] ?? '' ) );
      update_post_meta( $post_id, '_popx_popup_wrap_bg_img', sanitize_text_field( $_POST['popup_wrap_bg_img'] ?? '' ) );
      
      update_post_meta( $post_id, '_popx_popup_wrap_border', array_map( 'sanitize_text_field', $_POST['popup_wrap_border'] ?? [] ) );
      update_post_meta( $post_id, '_popx_popup_wrap_box_shadow', array_map( 'sanitize_text_field', $_POST['popup_wrap_box_shadow'] ?? [] ) );
      update_post_meta( $post_id, '_popx_popup_wrap_border_radius', array_map( 'sanitize_text_field', $_POST['popup_wrap_border_radius'] ?? [] ) );
  }

  

}

new Meta_Base();