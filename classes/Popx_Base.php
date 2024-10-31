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

class Popx_Base {


  public static function popup_html_one( $pages ) {
    $args = [
        'post_type' => 'popx_popup',
        'posts_per_page' => '-1',
        'meta_query' => [
          array(
            'key' => '_popx_active_popup',
            'value' => 'on',
            'compare' => 'IN',
          )
        ]
        
      ];


    if( $pages['is_single_archive'] ) {
      $args['meta_query'][] = [
        'key' => '_popx_display_page_type',
        'value' => 'singular-archive',
        'compare' => 'IN',
      ];
    }

    if( !$pages['is_single_archive'] ) {
      $args['meta_query'][] = [
        'key' => '_popx_display_page_type',
        'value' => 'singular-archive',
        'compare' => 'NOT IN',
      ];
    }

    $popup = new \WP_Query( $args );

    if( $popup->have_posts() ) {
      while ( $popup->have_posts() ) {
        $popup->the_post();

      $itemId = get_the_ID();

      //
      $wrapBorder = get_post_meta( $itemId, '_popx_popup_wrap_border', true );
      $wrapBg     = get_post_meta( $itemId, '_popx_popup_wrap_bg_color', true );
      $wrapBgImg  = get_post_meta( $itemId, '_popx_popup_wrap_bg_img', true );
      $wrapBorderRadius = get_post_meta( $itemId, '_popx_popup_wrap_border_radius', true );
      $wrapBoxShadow    = get_post_meta( $itemId, '_popx_popup_wrap_box_shadow', true );
      $positionZindex   = get_post_meta( $itemId, '_popx_popup_position_z_index', true );

      $position = get_post_meta( $itemId, '_popx_popup_position', true );
      $isOverly = get_post_meta( $itemId, '_popx_popup_bg_overly', true ) ? 'popx-popup-bg-overly' : '';
      $displayPageType = get_post_meta( $itemId, '_popx_display_page_type', true );
      $overlyColor = get_post_meta( $itemId, '_popx_popup_overly_color', true );

      //
      $width = get_post_meta( $itemId, '_popx_popup_popup_width', true );
      $height = get_post_meta( $itemId, '_popx_popup_popup_height', true );
      $wrapPadding = get_post_meta( $itemId, '_popx_popup_wrap_padding', true );
      //
      $exitPopups = get_post_meta( $itemId, '_popx_exit_popups', true );

      $activateClassType =  $exitPopups ? 'popx-exit-popups popx-popup-is-activate' : 'popx-popup-activate popx-popup-is-activate';

      //
      $activate = '';

      if( $displayPageType == 'specific-pages' ) {
         $displayPages = get_post_meta( $itemId, '_popx_display_pages', true );

        if( $pages['page_id'] == $displayPages ) {
          $activate = $activateClassType;
        }
      }
      
      if( $displayPageType == 'entire-pages' || $displayPageType == 'singular-archive'  ) {
        $activate = $activateClassType;
      }
      
      // Style

      $customStyle = '';

      // Wrap bg style
      if( !empty( $wrapBg ) ) {
        $customStyle .= 'background-color:'.esc_attr( $wrapBg ).';';
      }

      // Wrap bg image style
      if( !empty( $wrapBgImg ) ) {
        $customStyle .= 'background-image:url('.esc_attr( $wrapBgImg ).');background-size: cover; background-position: center center; background-repeat: no-repeat;';
      }

      // Wrap border color
      if( !empty( $wrapBorder['style'] ) ) {

          if( $wrapBorder['style'] == 'none' ) {
            $customStyle .= 'border:none;';
          } else {
            $customStyle .= 'border:'.$wrapBorder['width'].'px '.$wrapBorder['style'].' '.$wrapBorder['color'].';';
          }

      }

      // Wrap padding

      if( !empty( array_filter( $wrapPadding ) ) || in_array(0, $wrapPadding) ) {

        $top    = isset( $wrapPadding['top'] ) ? $wrapPadding['top'].'px' : '';
        $right  = isset( $wrapPadding['right'] ) ? $wrapPadding['right'].'px' : '';
        $bottom = isset( $wrapPadding['bottom'] ) ? $wrapPadding['bottom'].'px' : '';
        $left   = isset( $wrapPadding['left'] ) ? $wrapPadding['left'].'px' : '';

        $customStyle .= 'padding:'.$top.' '.$right.' '.$bottom.' '.$left.';';
      }

      // Wrap border radius
      if( !empty( array_filter( $wrapBorderRadius ) ) ) {

        $top_left = !empty( $wrapBorderRadius['top_left'] ) ? $wrapBorderRadius['top_left'].'px' : '';
        $top_right = !empty( $wrapBorderRadius['top_right'] ) ? $wrapBorderRadius['top_right'].'px' : '';
        $bottom_right = !empty( $wrapBorderRadius['bottom_right'] ) ? $wrapBorderRadius['bottom_right'].'px' : '';
        $bottom_left = !empty( $wrapBorderRadius['bottom_left'] ) ? $wrapBorderRadius['bottom_left'].'px' : '';

        $customStyle .= 'border-radius:'.$top_left.' '.$top_right.' '.$bottom_right.' '.$bottom_left.' ;';
      }

      // Wrap Box Shadow
      if( !empty( array_filter( $wrapBoxShadow ) ) ) {

        $horizontal =  !empty( $wrapBoxShadow['horizontal'] ) ? $wrapBoxShadow['horizontal'] : 0;
        $vertical = !empty( $wrapBoxShadow['vertical'] ) ? $wrapBoxShadow['vertical'] : 0;
        $blur     = !empty( $wrapBoxShadow['blur'] ) ? $wrapBoxShadow['blur'] : 0;
        $spread   = !empty( $wrapBoxShadow['spread'] ) ? $wrapBoxShadow['spread'] : 0;
        $color    = !empty( $wrapBoxShadow['color'] ) ? $wrapBoxShadow['color'] : '';

        $customStyle .= 'box-shadow:'.$horizontal.'px '.$vertical.'px '.$blur.'px '.$spread.'px '.$color.';';
      }

      // Width
      if( !empty( $width ) ) {
        $customStyle .= 'width:'.$width.'px;';
      }
      // Height
      if( !empty( $height ) ) {
        $customStyle .= 'height:'.$height.'px;';
      }

      // popup wrap style
      $wrapStyle = $wrapStyleElement = '';

      // Overlay Color
      if( $isOverly && $overlyColor ) {
        $wrapStyleElement .= 'background-color:'.$overlyColor.';';
      }

      // position 
      if( !$isOverly && !empty( $positionZindex ) && $positionZindex == 'relative'  ) {
        $wrapStyleElement .= 'position:'.$positionZindex.';';

        
      }

      if( !empty( $wrapStyleElement ) ) {
        $wrapStyle = 'style='.$wrapStyleElement;
      }


    ?>
    <div class="popx-popup-wrap <?php echo esc_attr( $activate ); ?> popx-position-<?php echo esc_attr( $position ?? 'center' ).' '.esc_attr($isOverly); ?>" data-delay-time="<?php echo esc_attr( get_post_meta( $itemId, '_popx_popup_delay_time', true ) ); ?>" data-popx-id="<?php echo absint( $itemId ); ?>" <?php echo esc_attr( $wrapStyle ); ?>>
      <div class="popx-popup-top-inner">
        <div class="popx-popup-close">X</div>
        <div class="popx-popup-content-wrap" style="<?php echo esc_attr( $customStyle ); ?>">
          <?php the_content(); ?>
        </div>
      </div>
    </div>
    <?php
    
      }
      wp_reset_query();

    }


  }



}

new Popx_Base();