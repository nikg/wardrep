<?php defined('BASEPATH') OR exit; ?>
    <div class="row content">
        <h1>Feedback</h1>
        
        <p>Please let us know how we can improve WardRep! If you`re a councilor and wish to update your contact, social media or other information -- please use the email address that is currently shown on your town`s council website. </p>
        <p>&nbsp;</p>
        
        <h2>Send us an Email</h2>
        
        <?php print form_open('/feedback/'); ?>
        <div class="form">
            <?php if( isset($has_error) && $has_error ) : ?>
            <div class="error-box">
                <p><?php print isset($error_message) && !empty($error_message) ? $error_message : 'An unknown error has occurred. Please try again.'; ?></p>
            </div>
            <?php elseif( isset($is_success) && $is_success ) : ?>
            <div class="success-box">
                <p><?php print isset($success_message) && !empty($success_message) ? $success_message : 'You have successfully submitted this form.'; ?></p>
            </div>
            <?php endif; ?>
            <ul>
                <li>
                    <?php print form_label('Name', 'name'); ?>
                    <?php print form_input(array('name' => 'name', 'id' => 'name', 'maxlength' => 100, 'value' => $name, 'size' => 80, 'class' => 'text')); ?>
                </li>
                <li>
                    <?php print form_label('Email', 'email'); ?>
                    <?php print form_input(array('name' => 'email', 'id' => 'email', 'maxlength' => 255, 'value' => $email, 'size' => 80, 'class' => 'text')); ?>
                </li>
                <li>
                    <?php print form_label('Message', 'message'); ?>
                    <?php print form_textarea(array('name' => 'message', 'id' => 'message', 'rows' => 12, 'cols' => 80, 'class' => 'text', 'value' => $message)); ?>
                </li>
                <li class="submit">
                    <?php print form_submit('submit', 'Send'); ?>
                </li>
            </ul>
        </div>
        <?php print form_close(); ?>
    </div>