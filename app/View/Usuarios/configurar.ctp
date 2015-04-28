<ul>
    <li><?php echo $this->Html->link('Contas', array('controller'=>'Contas','action'=>'listar')); ?></li>
    <li><?php echo $this->Html->link('Grupos', array('controller'=>'Grupos','action'=>'principal')); ?></li>
    <li><?php echo $this->Html->link('Dados', array('controller'=>'Usuarios','action'=>'alterarDados')); ?></li>
    <li><?php echo $this->Html->link('Alterar senha', array('controller'=>'Usuarios','action'=>'alterarSenha'))    ; ?></li>
</ul>