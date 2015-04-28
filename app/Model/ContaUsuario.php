<?php
App::uses('AppModel', 'Model');

class ContaUsuario extends AppModel{
    public $belongsTo = array(
        'Usuario', 'Conta'
    );

    public $hasMany = array(
        'Lancamento'
    );

} 