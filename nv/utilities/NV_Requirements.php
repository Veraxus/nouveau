<?php
/**
 * Is used to check whether the server meets the PHP and WordPress requirements of Nouveau. If not, an error message is
 * displayed.
 *
 * This class MUST NOT use any PHP 5.3+ features or that would defeat the purpose of the class (as users would get an
 * error message instead of a helpful notice). Instead, we'll use an old-fashioned prefix just this once.
 *
 * @TODO Can we do this better?
 */
class NV_Requirements {

    /**
     * Stores requirements check result. true if pass, false if fail.
     * @var bool
     */
    public $is_compatible;

    /**
     * The validation message to display if check fails.
     * @var string
     */
    public $errors;

    /**
     * Sets up the class
     */
    function __construct()
    {

        //Run check and save result to $this->is_compatible
        $this->phpVersionCheck();

        //Set compatibility based on errors
        $this->is_compatible = ( count($this->errors) === 0 );

        //If check fails, run notification hooks
        if ( ! $this->is_compatible ) {
            //Check front end
            $this->checkFrontend();
            // Perform check on admin
            add_action('admin_notices', array(&$this, 'checkAdmin'));
        }

    }


    /**
     * Checks the current version of PHP
     *
     * @param string $req_php The required version of PHP
     * @param string $req_wp The required version of WordPress
     *
     * @return boolean True if users version is >= required version
     */
    public function phpVersionCheck($req_php='5.3.0',$req_wp='3.9.0')
    {
        global $wp_version;

        //VALIDATE PHP VERSION
        if ( version_compare(PHP_VERSION, $req_php, '<') )
        {
            //Set the default error message
            $this->errors['php'] = sprintf(
                __('<p><b>WARNING:</b> Nouveau requires PHP %s or newer! Your server is currently running PHP %s. This <a href="%s">theme</a> will not work until PHP is updated.</p>','nvLangScope'),
                $req_php,
                PHP_VERSION,
                admin_url('themes.php')
            );
        }

        //VALIDATE WP VERSION
        if ( version_compare($wp_version, $req_wp, '<') )
        {
            //Set the default error message
            $this->errors['wp'] = sprintf(
                __('<p><b>WARNING:</b> Nouveau requires WordPress %s or newer! You are currently running WordPress %s. This <a href="%s">theme</a> will not work until WordPress is updated.</p>','nvLangScope'),
                $req_wp,
                $wp_version,
                admin_url('themes.php')
            );
        }

    }

    /**
     * This DRYs the process of displaying an admin message. Special note: only call this inside any function that is
     * already hooked by 'admin_notices'
     *
     * @param string $message The message you want to display.
     * @param string $type This can be either 'notice' (default) or 'error'.
     */
    public function showNotice($message,$type='notice')
    {
        $html['notice']     = '<div class="updated">%s</div>';
        $html['error']      = '<div class="error">%s</div>';
        printf( $html[$type] , $message );
    }


    /**
     * Generally, you shouldn't call this method directly. Instead, use:
     *
     * add_action('admin_notices', array(&$this,'showNotice')
     *
     * This will show a message on the WordPress admin if the minimum PHP version is not met. This gives admins the
     * ability to shut down the theme if needed by not breaking the admin.
     */
    public function checkAdmin()
    {
        if ( ! $this->phpVersionCheck() ) {
            $this->showNotice( $this->getErrors(), 'error' );
        }
    }


    /**
     * Shows an error on the frontend and stops further execution (in order to prevent unhelpful PHP errors).
     */
    public function checkFrontend()
    {
        if ( ! $this->is_compatible && ! is_admin() && ! $this->isLogin() ) {
            wp_die( $this->getErrors() );
        }
    }


    /**
     * Fetches errors as a string
     * @return string
     */
    public function getErrors()
    {
        return implode('',$this->errors);
    }


    /**
     * Detects whether this is the login page
     *
     * @return boolean True if this is the login page
     */
    public function isLogin()
    {
        return in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'));
    }

}