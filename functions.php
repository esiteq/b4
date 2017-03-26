<?php

include_once 'lib/bootstrap-four-wp-navwalker.php';

global $bootstrap_four_version;

$bootstrap_four_version = '4.0.0';

// Le sigh...
if ( ! isset( $content_width ) ) $content_width = 837;

class Indochina
{
    const VERSION = '1.0';
    //
    function __construct()
    {
        add_action('widgets_init', [$this, 'widgets_init']);
        add_action('after_setup_theme', [$this, 'setup']);
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_filter('nav_menu_css_class', [$this, 'nav_li_class'], 10, 2);
        add_filter('nav_menu_link_attributes', [$this, 'nav_anchor_class'], 10, 3 );
        add_action('comment_form_before', [$this, 'comment_form_before'], 10, 5 );
        add_filter('comment_form_defaults', [$this, 'comment_form'], 10, 5 );
        add_action('comment_form_after', [$this, 'comment_form_after'], 10, 5 );
    }
    //
    function widgets_init()
    {
        register_sidebar([
        'name' => __( 'Right Sidebar', 'bootstrap-four' ),
        'id' => 'right-sidebar',
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget' => '</aside>',
        'before_title' => '<h3>',
        'after_title' => '</h3>',
        ]);        
    }
    //
    function setup()
    {
        add_theme_support('custom-background', ['default-color' => 'ffffff']);
        add_theme_support('automatic-feed-links' );
        add_theme_support('title-tag' );
        add_theme_support('html5', ['search-form', 'comment-form', 'comment-list', 'gallery', 'caption']);
        register_nav_menus(['main_menu' => __( 'Main Menu', 'bootstrap-four' )]);
        add_editor_style( 'css/bootstrap.min.css' );        
    }
    //
    function enqueue_scripts()
    {
        wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', array(), '4.4.0' );
        wp_register_style('bootstrap', get_template_directory_uri() . '/css/bootstrap.min.css', array(), self::VERSION );
        wp_enqueue_style('styles', get_stylesheet_uri(), array('bootstrap' ), '1' );
        wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.js', array('jquery'), self::VERSION, true );
    }
    //
    function nav_li_class($classes, $item)
    {
        $classes[] .= ' nav-item';
        return $classes;
    }
    //
    function nav_anchor_class( $atts, $item, $args )
    {
        $atts['class'] .= ' nav-link';
        return $atts;
    }
    //
    function comment_form_before()
    {
        echo '<div class="card"><div class="card-block">';
    }
    //
    function comment_form( $fields )
    {
        $fields['fields']['author'] = '
  <fieldset class="form-group comment-form-email">
    <label for="author">' . __( 'Name *', 'bootstrap-four' ) . '</label>
    <input type="text" class="form-control" name="author" id="author" placeholder="' . __( 'Name', 'bootstrap-four' ) . '" aria-required="true" required>
  </fieldset>';
        $fields['fields']['email'] ='
  <fieldset class="form-group comment-form-email">
    <label for="email">' . __( 'Email address *', 'bootstrap-four' ) . 'Email address *</label>
    <input type="email" class="form-control" id="email" placeholder="' . __( 'Enter email', 'bootstrap-four' ) . '" aria-required="true" required>
    <small class="text-muted">' . __( 'Your email address will not be published.', 'bootstrap-four' ) . '</small>
  </fieldset>';
        $fields['fields']['url'] = '
  <fieldset class="form-group comment-form-email">
    <label for="url">' . __( 'Website *', 'bootstrap-four' ) . '</label>
    <input type="text" class="form-control" name="url" id="url" placeholder="' . __( 'http://example.org', 'bootstrap-four' ) . '">
  </fieldset>';
        $fields['comment_field'] = '
  <fieldset class="form-group">
    <label for="comment">' . __( 'Comment *', 'bootstrap-four' ) . '</label>
    <textarea class="form-control" id="comment" name="comment" rows="3" aria-required="true" required></textarea>
  </fieldset>';
        $fields['comment_notes_before'] = '';
        $fields['class_submit'] = 'btn btn-primary';
        return $fields;
    }
    //
    function comment_form_after()
    {
        echo '</div><!-- .card-block --></div><!-- .card -->';
    }
    //
    function get_posts_pagination( $args = '' )
    {
        global $wp_query;
        $pagination = '';
        if ( $GLOBALS['wp_query']->max_num_pages > 1 )
        {

            $defaults = array(
            'total'     => isset( $wp_query->max_num_pages ) ? $wp_query->max_num_pages : 1,
            'current'   => get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1,
            'type'      => 'array',
            'prev_text' => '&laquo;',
            'next_text' => '&raquo;',
            );

            $params = wp_parse_args( $args, $defaults );

            $paginate = paginate_links( $params );

            if( $paginate )
            {
                $pagination .= "<ul class='pagination'>";
                foreach( $paginate as $page )
                {
                    if (strpos( $page, 'current' ))
                    {
                        $pagination .= "<li class='active'>$page</li>";
                    }
                    else
                    {
                        $pagination .= "<li>$page</li>";
                    }
                }
                $pagination .= "</ul>";
            }

        }
        return $pagination;
    }
    //
    function the_posts_pagination( $args = '' )
    {
        echo bootstrap_four_get_posts_pagination( $args );
    }
    //
}

$ich = new Indochina;
?>