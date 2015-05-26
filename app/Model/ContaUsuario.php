<?php
App::uses('AppModel', 'Model');

class ContaUsuario extends AppModel{
    public $belongsTo = array(
        'Usuario', 'Conta'
    );

    public $hasMany = array(
        'LancamentoCredito' => array(
            'className' => 'Lancamento',
            'foreignKey' => 'conta_usuario_credito_id'
        ),
        'LancamentoDebito' => array(
            'className' => 'Lancamento',
            'foreignKey' => 'conta_usuario_debito_id'
        )
    );

} 