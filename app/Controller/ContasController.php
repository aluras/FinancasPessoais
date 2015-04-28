<?php
App::uses('AppController', 'Controller');

class ContasController extends AppController {
    public $components = array('RequestHandler');

    public function listar(){
        $this->Conta->Behaviors->load('Containable');
        $dados = $this->Conta->find('all', array(
            'contain' => array(
                'ContaUsuario' => array(
                    'conditions' => array(
                        'usuario_id' => $this->Auth->User('id')
                    )
                ),
                'TipoConta'
            )
        ));
        $this->set('dados', $dados);
        $this->set('_serialize', array('dados'));
    }


} 