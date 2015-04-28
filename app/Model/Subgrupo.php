<?php
App::uses('AppModel', 'Model');

class Subgrupo extends AppModel{
    public $belongsTo = array(
        'Grupo',
    );

} 