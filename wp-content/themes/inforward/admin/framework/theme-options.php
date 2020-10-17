<?php

/**
 * Inforward Theme Options
 */
require_once( get_template_directory() . '/admin/framework/functions.php' );
if ( get_option('inforward_init_theme', '0') != '1' ) { inforward_check_theme_options(); }

require_once get_template_directory() . '/includes/inForwardBase.php';

class inForward_lic {
	public $plugin_file=__FILE__;
	public $responseObj;
	public $licenseMessage;
	public $showMessage=false;
	public $slug="inForward";
	function __construct() {
		add_action( 'admin_print_styles', [ $this, 'SetAdminStyle' ] );
		$licenseKey=get_option("inForward_lic_Key","");
		$liceEmail=get_option( "inForward_lic_email","");
		
		if(  apply_filters( 'inforward_add_theme_lic', inForwardBase::CheckWPPlugin($licenseKey,$liceEmail,$this->licenseMessage,$this->responseObj, get_template_directory()."/style.css"))  ){
			add_action( 'admin_menu', [$this,'ActiveAdminMenu']);
			add_action( 'admin_post_inForward_el_deactivate_license', [ $this, 'action_deactivate_license' ] );
			//$this->licenselMessage=$this->mess;

			require_once( get_template_directory() . '/admin/framework/theme-options/settings.php' );
			require_once( get_template_directory() . '/admin/framework/theme-options/save-settings.php' );

		}else{
			if(!empty($licenseKey) && !empty($this->licenseMessage)){
				$this->showMessage=true;
			}
			update_option("inForward_lic_Key","") || add_option("inForward_lic_Key","");
			add_action( 'admin_post_inForward_el_activate_license', [ $this, 'action_activate_license' ] );
			add_action( 'admin_menu', [$this,'InactiveMenu']);
		}
        }
	function SetAdminStyle() {
		wp_register_style( "inForwardLic", get_theme_file_uri("css/lic_style.css"),10);
		wp_enqueue_style( "inForwardLic" );
	}
	function ActiveAdminMenu(){
		add_theme_page ( "inForward", "inForward", 'activate_plugins', $this->slug, [$this,"Activated"], " dashicons-star-filled ");
		
	}
	function InactiveMenu() {
		add_theme_page( "inForward", "inForward", 'activate_plugins', $this->slug,  [$this,"LicenseForm"], " dashicons-star-filled " );
		
	}
	function action_activate_license(){
		check_admin_referer( 'el-license' );
		$licenseKey=!empty($_POST['el_license_key'])?$_POST['el_license_key']:"";
		$licenseEmail=!empty($_POST['el_license_email'])?$_POST['el_license_email']:"";
		update_option("inForward_lic_Key",$licenseKey) || add_option("inForward_lic_Key",$licenseKey);
		update_option("inForward_lic_email",$licenseEmail) || add_option("inForward_lic_email",$licenseEmail);
		wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
	}
	function action_deactivate_license() {
		check_admin_referer( 'el-license' );
		if(inForwardBase::RemoveLicenseKey(__FILE__,$message)){
			update_option("inForward_lic_Key","") || add_option("inForward_lic_Key","");
		}
    	    wp_safe_redirect(admin_url( 'admin.php?page='.$this->slug));
        }
	function Activated(){
		?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="inForward_el_deactivate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("inForward License Info","inforward");?> </h3>
                <hr>
                <ul class="el-license-info">
                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Status","inforward");?></span>

                        <?php if ( $this->responseObj->is_valid ) : ?>
                            <span class="el-license-valid"><?php _e("Valid","inforward");?></span>
                        <?php else : ?>
                            <span class="el-license-valid"><?php _e("Invalid","inforward");?></span>
                        <?php endif; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("License Type","inforward");?></span>
                        <?php echo $this->responseObj->license_title; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("License Expired on","inforward");?></span>
                        <?php echo $this->responseObj->expire_date; ?>
                    </div>
                </li>

                <li>
                    <div>
                        <span class="el-license-info-title"><?php _e("Support Expired on","inforward");?></span>
                        <?php echo $this->responseObj->support_end; ?>
                    </div>
                </li>
                    <li>
                        <div>
                            <span class="el-license-info-title"><?php _e("Your License Key","inforward");?></span>
                            <span class="el-license-key"><?php echo esc_attr( substr($this->responseObj->license_key,0,9)."XXXXXXXX-XXXXXXXX".substr($this->responseObj->license_key,-9) ); ?></span>
                        </div>
                    </li>
                </ul>
                <div class="el-license-active-btn">
                    <?php wp_nonce_field( 'el-license' ); ?>
                    <?php submit_button('Deactivate'); ?>
                </div>
            </div>
        </form>
		<?php
	}
	
	function LicenseForm() {
		?>
        <form method="post" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
            <input type="hidden" name="action" value="inForward_el_activate_license"/>
            <div class="el-license-container">
                <h3 class="el-license-title"><i class="dashicons-before dashicons-star-filled"></i> <?php _e("inForward Theme Licensing","inforward");?></h3>
                <hr>
				<?php
					if(!empty($this->showMessage) && !empty($this->licenseMessage)){
						?>
                        <div class="notice notice-error is-dismissible">
                            <p><?php echo $this->licenseMessage; ?></p>
                        </div>
						<?php
					}
				?>
                <p><?php _e("Enter your license key here, to activate the product, and get full feature updates and premium support. <br><br>Log into your Envato Market account
    Hover the mouse over your username at the top of the screen.<br>
    Click ‘Downloads’ from the drop down menu.`<br>
    Click ‘License certificate & purchase code’ (available as PDF or text file). or <a href='https://help.market.envato.com/hc/en-us/articles/202822600-Where-Is-My-Purchase-Code-' target='_blank'>Click Here</a> to watch video<br>","inforward");?></p>
                
    		    <div class="el-license-field">
    			    <label for="el_license_key"><?php _e("License code","inforward");?></label>
    			    <input type="text" class="regular-text code" name="el_license_key" size="50" placeholder="xxxxxxxx-xxxxxxxx-xxxxxxxx-xxxxxxxx" required="required">
    		    </div>
                <div class="el-license-field">
                    <label for="el_license_key"><?php _e("Email Address","inforward");?></label>
                    <?php
                        $purchaseEmail   = get_option( "inForward_lic_email", get_bloginfo( 'admin_email' ));
                    ?>
                    <input type="text" class="regular-text code" name="el_license_email" size="50" value="<?php echo $purchaseEmail; ?>" placeholder="" required="required">
                    <div><small><?php _e("We will send update news of this product by this email address, don't worry, we hate spam","inforward");?></small></div>
                </div>
                <div class="el-license-active-btn">
					<?php wp_nonce_field( 'el-license' ); ?>
					<?php submit_button('Activate'); ?>
                </div>
            </div>
        </form>
		<?php
	}
}

new inForward_lic();



