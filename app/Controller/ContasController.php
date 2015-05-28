<?php
App::uses('AppController', 'Controller');

class ContasController extends AppController {
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        if(isset($this->request->params['ext'])){
            $this->Auth->unauthorizedRedirect=false;
        }

    }

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

        if(isset($this->request->params['ext'])){
            $this->autoRender = false;
            $this->response->body(json_encode($dados));
        }else{
            $this->set('dados', $dados);
        }
    }

} 