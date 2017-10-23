<h1>Sunset Contact Form</h1>
<?php settings_errors(); ?>

<form method="post" action="options.php" class="sunset-general-form">
	<?php settings_fields( 'sunset-contact-options' ) ?>
	<?php do_settings_sections( 'sunset_contact_form_slug' ); ?>
	<?php submit_button(); ?>
</form>