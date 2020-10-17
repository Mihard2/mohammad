
<?php
$id = get_the_author_meta('ID');
$name  = get_the_author_meta('display_name', $id);
$email = get_the_author_meta('email', $id);
$heading = esc_html__("About", 'inforward') ." ". $name;
$description = get_the_author_meta('description', $id);

if ( empty($description) ) return;

if ( current_user_can('edit_users') || get_current_user_id() == $id ) {
	$description .= " <a href='" . admin_url( 'profile.php?user_id=' . $id ) . "'>". esc_html__( '[ Edit the profile ]', 'inforward' ) ."</a>";
}
?>

<div class="cp-author-box content-element">
<div class="team-holder type-2">
<div class="team-item">
	<h5 class="tt-up"><?php echo esc_html($heading); ?></h5>

    <div class="team-member">
    
        <div class="member-photo">
           <?php echo get_avatar($email, '100', '', esc_html($name)); ?>
        </div>
        
        <div class="cp-author-info wrapper">
            
            <div class="member-info">
    
                <h6 class="cp-author-name member-name"><?php echo esc_html($name); ?></h6>
    
                <?php if ( !empty($description) ): ?>
                    <div class="cp-author-about member-about">
                        <?php echo sprintf('%s', $description); ?>
                    </div>
                <?php endif; ?>
            
            </div>
    
            <?php
            $user_profile = new inforward_admin_user_profile();
            echo wp_kses_post($user_profile->output_social_links());
            ?>
    
        </div>
    
    </div>
</div>
</div>
</div>
