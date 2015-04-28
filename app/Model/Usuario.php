<?php
App::uses('AppModel', 'Model');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');


class Usuario extends AppModel {
    public $hasMany = array(
        'ContaUsuario'
    );

    public $validate = array(
        'email' => array(
            'required' => array(
                'rule' => 'notEmpty',
                'message' => 'Informe seu email.'
            ),
            'emailUnico' => array(
                'rule' => 'isUnique',
                'message' => 'Email já cadastrado em nossa base.'
            )
        ),
        'password' => array(
            'required' => array(
                'rule' => array('notEmpty'),
                'message' => 'Digite sua senha.'
            )
        ),
        'perfil' => array(
            'valid' => array(
                'rule' => array('inList', array('admin', 'usuario')),
                'message' => 'Perfil inválido',
                'allowEmpty' => false
            )
        )
    );

    public function beforeSave($options = array()) {
        if (isset($this->data[$this->alias]['password'])) {
            $passwordHasher = new BlowfishPasswordHasher();
            $this->data[$this->alias]['password'] = $passwordHasher->hash(
                $this->data[$this->alias]['password']
            );
        }
        return true;
    }
}