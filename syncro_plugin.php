<?php

/* Find more information at http://syncrowebchat.com/ */

/*
Plugin Name: Syncro
Description: Enables Syncro on your Wordpress website.
Author: Atomic55
Version: 1.3.4
Author URI: http://www.atomic55.net
*/

add_action('admin_menu', 'syncro_admin_page');
function syncro_admin_page(){
    add_menu_page('Syncro Settings', 'SYNCRO', 'administrator', 'syncro-settings', 'syncro_admin_page_callback', plugin_dir_url( __FILE__ ) . 'syncro-ico.png');
}

add_action('admin_init', 'syncro_register_settings');
function syncro_register_settings(){
    register_setting('syncro_settings', 'syncro_settings');
}

add_action('admin_notices', 'syncro_admin_notices');
function syncro_admin_notices(){
   settings_errors();
}

function syncro_admin_page_callback(){ // Admin section: notifications, syncro field, and save button?>
    <div class="wrap">
    <h2>SYNCRO Settings</h2>
    <p>Chat seamlessly with people visiting your website via your mobile device no matter where you are. Leads coming from your web chat tool are now instantly funneled via text message to your phone in real time. This all adds up to you selling more and building customer relationships one text at a time.</p>
       
    <p>In order for SYNCRO to appear on your website, you must first register for an account and input your account's "Short Name" into the field below.</p>
    
    <p><a href="http://syncrowebchat.com/" target="_blank">Get chatting with potential clients today and register for your accounton our website</a></p>
    
    <form action="options.php" method="post"><?php
        settings_fields( 'syncro_settings' );
        do_settings_sections( __FILE__ );

        $options = get_option( 'syncro_settings' ); ?>
        <table class="form-table">
            <tr>
                <th scope="row">SYNCRO Short Name</th>
                <td>
                    <fieldset>
                        <label>
                            <input name="syncro_settings[syncro_shortname]" type="text" id="syncro_shortname" value="<?php echo (isset($options['syncro_shortname']) && $options['syncro_shortname'] != '') ? $options['syncro_shortname'] : ''; ?>"/>
                            <br />
                            <span class="description">You can find your Short Name in your SYNCRO account: Manage > Settings.</span>
                        </label>
                    </fieldset>
                </td>
            </tr>
        </table>
        <input type="submit" value="Save" />
    </form>
</div>
<?php }

function syncro_embed_code() { // function for adding the Syncro embed code to the footer
    $syncro_site = get_option( 'syncro_settings' );
    $syncro_settings = get_option( 'syncro_settings' );
    $syncro_array_value = array_values($syncro_settings);
    $syncro_short_code = $syncro_array_value[0];
    $syncro_short_code = trim($syncro_short_code);

    if(!empty($syncro_short_code)){
        wp_enqueue_script('syncro-plugin-js', 'https://stable.syncrowebchat.com/js/v2/embed.js', array(), '0.8', TRUE);
        wp_localize_script('syncro-plugin-js', 'syncrowebchat', array('shortname' => $syncro_short_code));

        echo '<div id="syncro-webchat"></div>';
    }
} 

add_action('wp_footer', 'syncro_embed_code'); // adds embed code to wp_footer
?>