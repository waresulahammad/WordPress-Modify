<?php 
// WP-Admin Page Customization
function webdo24_custom_login_logo() {

    // Get Site Icon (Favicon)
    $icon_url = get_site_icon_url(512);

    if ($icon_url) {
        echo '<style type="text/css">
            #login h1 a {
                background-image: url(' . esc_url($icon_url) . ');
                background-size: contain;
                background-repeat: no-repeat;
                background-position: center;
                height: 100px;
                width: 100px;
                margin: 0 auto 20px;
                border-radius: 12px;
                border: 2px solid #ddd;
                padding: 10px;
                box-sizing: border-box;
            }
			form#loginform, form#lostpasswordform {
				border-radius: 12px;
				border: 1px solid #ddd;
			}
			form#lostpasswordform p label{
				margin-bottom: 15px;
				text-align: center;
				display: block;
				font-size: 21px;
				font-weight: 500;
				color: #163f91;
			}
			form#loginform div label, form#loginform p label {
				margin-bottom: 15px;
				font-size: 21px;
				font-weight: 500;
				color: #163f91;
			}


			input#wp-submit {
				display: block;
				width: 100%;
				border-radius: 8px;
				padding: 9px;
				background: #163f91;
			}
			.login .button.wp-hide-pw{
			height: 3rem !important;
			}

			input#user_login, form#loginform input#user_pass {
				border: 1px solid #b9b9b9 !important;
				border-radius: 8px;
				padding: 8px;
			}
			.notice.notice-info.message {
				display: none;
			}
        </style>';
    }
}
add_action('login_enqueue_scripts', 'webdo24_custom_login_logo');


// Logo click → Homepage
add_filter('login_headerurl', function() {
    return home_url();
});


// Logo hover text → Site Name
add_filter('login_headertext', function() {
    return get_bloginfo('name');
});
