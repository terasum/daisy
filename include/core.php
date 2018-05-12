<?php
require  dirname( __FILE__ ) . '/../vendor/autoload.php';

function daisy_get_background_image($post_id = null , $width = null , $height = null){
    if( has_post_thumbnail($post_id) ){
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $output = $timthumb_src[0];
    } else {
        $content = get_post_field('post_content', $post_id);
        $defaltthubmnail = get_template_directory_uri().'/build/img/default.jpg';
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
            $output = $strResult[1][0];
        } else {
            $output = $defaltthubmnail;
        }
    }
    return $output;
}

function daisy_is_has_image($post_id){
    static $has_image;
    global $post;
    if( has_post_thumbnail($post_id) ){
        $has_image = true;
    } else {
        $content = get_post_field('post_content', $post_id);
        preg_match_all('/<img.*?(?: |\\t|\\r|\\n)?src=[\'"]?(.+?)[\'"]?(?:(?: |\\t|\\r|\\n)+.*?)?>/sim', $content, $strResult, PREG_PATTERN_ORDER);
        $n = count($strResult[1]);
        if($n > 0){
            $has_image = true;
        } else {
            $has_image = false;
        }
    }
    return $has_image;
}



function daisy_setup() {
    add_theme_support( 'post-thumbnails' );
    register_nav_menu( 'top' , '顶部菜单' );
}

add_action( 'after_setup_theme', 'daisy_setup' );


function daisy_scripts_styles() {

    if ( is_singular() && comments_open() && get_option( 'thread_comments' ) )
        wp_enqueue_script( 'comment-reply' );

    wp_enqueue_style( 'daisy', get_template_directory_uri() . '/build/css/style.css', array(), DAISY_VERSION );
    // wp_enqueue_style( 'daisy-highlight', get_template_directory_uri() . '/build/css/code/atom-one-light.css', array(), DAISY_VERSION );

    wp_enqueue_script( 'daisy-highlight-js' , get_template_directory_uri() . '/build/js/app.js' , array('jquery') , DAISY_VERSION ,true);

    // wp_enqueue_script( 'daisy' , get_template_directory_uri() . '/build/js/application.js' , array('jquery','daisy-highlight-js') , DAISY_VERSION ,true);
    wp_localize_script( 'daisy' , 'D' , array(
        'ajax_url' => admin_url( 'admin-ajax.php' ),
      ) );

    if ( is_singular() && has_post_thumbnail() ) {

        global $post;
        $timthumb_src = wp_get_attachment_image_src(get_post_thumbnail_id($post_id),'full');
        $output = $timthumb_src[0];
        $custom_css = "
                .banner-mask{
                        background-image:url(" . $output . ");
                }";
        wp_add_inline_style( 'daisy', $custom_css );
    }

}

add_action( 'wp_enqueue_scripts', 'daisy_scripts_styles' );

function daisy_wp_title( $title, $sep ) {
    global $paged, $page;

    if ( is_feed() )
        return $title;


    $title .= get_bloginfo( 'name', 'display' );


    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) )
        $title = "$title $sep $site_description";

    if ( ( $paged >= 2 || $page >= 2 ) && ! is_404() )
        $title = "$title $sep " . sprintf( __( 'Page %s', 'twentythirteen' ), max( $paged, $page ) );

    return $title;
}

add_filter( 'wp_title', 'daisy_wp_title', 10, 2 );


function daisy_ssl_avatar($avatar) {
    $avatar = str_replace(array("www.gravatar.com","0.gravatar.com","1.gravatar.com","2.gravatar.com"),"secure.gravatar.com",$avatar);
    return $avatar;
}

add_filter('get_avatar', 'daisy_ssl_avatar');

function daisy_recover_comment_fields($comment_fields){
    $comment = array_shift($comment_fields);
    $comment_fields =  array_merge($comment_fields ,array('comment' => $comment));
    return $comment_fields;
}

add_filter('comment_form_fields','daisy_recover_comment_fields');

function daisy_post_nav_background() {
    if ( ! is_single() ) {
        return;
    }

    $previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
    $next     = get_adjacent_post( false, '', false );
    $css      = '';

    if ( is_attachment() && 'attachment' == $previous->post_type ) {
        return;
    }

    if ( $previous &&  has_post_thumbnail( $previous->ID ) ) {
        $prevthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $previous->ID ), 'post-thumbnail' );
        $css .= '
      .post-navigation .nav-previous { background-image: url(' . esc_url( $prevthumb[0] ) . ');}
      .post-navigation .nav-previous .post-title { color: #fff; }
      .post-navigation .nav-previous .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-previous:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
    }

    if ( $next && has_post_thumbnail( $next->ID ) ) {
        $nextthumb = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'post-thumbnail' );
        $css .= '
      .post-navigation .nav-next { background-image: url(' . esc_url( $nextthumb[0] ) . ');}
      .post-navigation .nav-next .post-title { color: #fff; }
      .post-navigation .nav-next .meta-nav { color: rgba(255,255,255,.9)}
      .post-navigation .nav-next:before{
      content: "";
      position: absolute;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      background-color: rgba(0,0,0,0.4);
    }
    ';
    }

    wp_add_inline_style( 'daisy', $css );
}
add_action( 'wp_enqueue_scripts', 'daisy_post_nav_background' );


 
// function daisy_featured_image_before_content( $content ) { 
//     if ( is_singular('post')) {
//          // do nothing 
// 		}

//     return $content;
// }

// add_filter( 'the_content', 'daisy_featured_image_before_content' ); 



function daisy_ajax_comment_callback(){
    $comment = wp_handle_comment_submission( wp_unslash( $_POST ) );
    if ( is_wp_error( $comment ) ) {
        $data = $comment->get_error_data();
        if ( ! empty( $data ) ) {
            fa_ajax_comment_err($comment->get_error_message());
        } else {
            exit;
        }
    }
    $user = wp_get_current_user();
    do_action('set_comment_cookies', $comment, $user);
    $GLOBALS['comment'] = $comment;
    ?>
    <li <?php comment_class(); ?>>
        <article class="comment-body">
            <footer class="comment-meta">
                <div class="comment-author vcard">
                    <?php echo get_avatar( $comment, $size = '48')?>
                    <b class="fn">
                        <?php echo get_comment_author_link();?>
                    </b>
                </div>
                <div class="comment-metadata">
                    <?php echo get_comment_date(); ?>
                </div>
            </footer>
            <div class="comment-content">
                <?php comment_text(); ?>
            </div>
        </article>
    </li>
    <?php die();
}

add_action('wp_ajax_nopriv_ajax_comment', 'daisy_ajax_comment_callback');
add_action('wp_ajax_ajax_comment', 'daisy_ajax_comment_callback');