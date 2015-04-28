<?php
App::uses('AppModel', 'Model');

class Grupo extends AppModel{
    public $hasMany = array(
        'Subgrupo'
    );
}