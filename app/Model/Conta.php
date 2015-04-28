<?php
App::uses('AppModel', 'Model');

class Conta extends AppModel {
    public $hasMany = array(
        'ContaUsuario'
    );
    public $belongsTo = array(
        'TipoConta'
    );
} 