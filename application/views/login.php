<?php $this->load->view('common/header'); ?>

<?php echo form_open('auth/login', array('class' => 'form-signin'))?>

    <h2 class="form-signin-heading">Please sign in</h2>
    
    <?php render_flashes(); ?>
    <?php echo validation_errors('<div class="alert-error">', '</div>'); ?>
    
     <?php echo form_input(array('name' => 'email', 'value' => set_value('email'), 'class' => 'input-block-level', 'required' => 'required', 'placeholder' => 'Email'))?>
    
    <?php echo form_password(array('name' => 'password', 'class' => 'input-block-level', 'required' => 'required', 'placeholder' => 'Password'))?>
    
    <?php echo form_submit(array('class'=>'btn btn-large btn-primary'), 'Sign in');?>

</form>

<?php $this->load->view('common/footer'); ?>