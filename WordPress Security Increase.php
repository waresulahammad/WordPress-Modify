<?php
// Disable comments support for all post types
function wp_disable_comments_post_types_support() {
    foreach (get_post_types() as $post_type) {
        if (post_type_supports($post_type, 'comments')) {
            remove_post_type_support($post_type, 'comments');
            remove_post_type_support($post_type, 'trackbacks');
        }
    }
}
add_action('admin_init', 'wp_disable_comments_post_types_support');

// Close comments and pings
add_filter('comments_open', '__return_false', 20, 2);
add_filter('pings_open', '__return_false', 20, 2);

// Hide existing comments
add_filter('comments_array', '__return_empty_array', 10, 2);

// Remove comments admin menu
function wp_disable_comments_admin_menu() {
    remove_menu_page('edit-comments.php');
}
add_action('admin_menu', 'wp_disable_comments_admin_menu');

// Redirect any user who tries to access comment-related pages
function wp_disable_comments_admin_redirect() {
    global $pagenow;
    if ($pagenow === 'edit-comments.php' || $pagenow === 'comment.php') {
        wp_redirect(admin_url()); exit;
    }
}
add_action('admin_init', 'wp_disable_comments_admin_redirect');

// Remove comments metabox from dashboard
function wp_disable_comments_dashboard() {
    remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
}
add_action('admin_init', 'wp_disable_comments_dashboard');

// Remove comment links from the admin bar
function wp_disable_comments_admin_bar() {
    if (is_admin_bar_showing()) {
        remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
    }
}
add_action('init', 'wp_disable_comments_admin_bar');

// Optional: Remove comment support from REST API
add_filter('rest_endpoints', function($endpoints) {
    unset($endpoints['/wp/v2/comments']);
    return $endpoints;
});



// Disable Username everywhere

add_filter('rest_authentication_errors', function($result) {
    if (!is_user_logged_in()) {
        return new WP_Error(
            'rest_not_logged_in',
            'You are not allowed to access this endpoint',
            array('status' => 401)
        );
    }
    return $result;
});

// Disable Author Archive Pages 

add_action('template_redirect', function() {
    if (is_author() || preg_match('/author/i', $_SERVER['REQUEST_URI'])) {
        wp_redirect(home_url(), 301);
        exit;
    }
});

// Login failed erros messages
add_filter('login_errors', function() {
    return 'Login failed';
});

// WP version Hide
remove_action('wp_head', 'wp_generator');

// XML-RPC Disable
add_filter('xmlrpc_enabled', '__return_false');
