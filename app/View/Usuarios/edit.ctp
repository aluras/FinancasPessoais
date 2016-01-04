<div class="users form">
    <?php echo $this->Form->create('Usuario'); ?>
    <fieldset>
        <legend><?php echo __('Editar usuário'); ?></legend>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('email');
        echo $this->Form->input('password', array('label' => 'Senha'));
        echo $this->Form->input('perfil', array(
            'options' => array('admin' => 'Admin', 'usuario' => 'Usuário')
        ));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Enviar')); ?>
</div>