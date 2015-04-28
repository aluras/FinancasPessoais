<?php
App::uses('AppModel', 'Model');

class TipoConta  extends AppModel{
    public $hasMany = array(
        'Conta'
    );
} 