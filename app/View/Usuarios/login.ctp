<div class="users form">
    <?php echo $this->Session->flash('auth'); ?>
    <?php echo $this->Form->create('Usuario'); ?>
    <fieldset>
        <legend>
            <?php echo __('Por favor, entre com seu email e senha'); ?>
        </legend>
        <?php echo $this->Form->input('email');
        echo $this->Form->input('password', array('label' => 'Senha'));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Entrar')); ?>
</div>