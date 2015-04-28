<?php
App::uses('AppController','Controller');


class LancamentosController extends AppController {
    public $components = array('Paginator','RequestHandler');
    public $helpers = array('Js');

    public function principal(){
    }

    public function adicionar(){
        if ($this->request->is('ajax')) {
            $this->layout = 'ajax';
            $datasource = $this->Lancamento->getDataSource();
            $datasource->begin();
            $this->Lancamento->create();
            if ($this->Lancamento->save($this->request->data)) {
                $datasource->commit();
                echo __('Lançamento registrado.');
            }else{
                $this->response->statusCode(400);
                $errors = '';
                foreach($this->Lancamento->validationErrors as $atributo){
                    foreach($atributo as $erro){
                        $errors .= $erro . '<br />';
                    }
                }
                $datasource->rollback();
                echo __('Falha ao registrar:<br />' . $errors);

            }
            //$this->redirect(array('controller'=>'usuarios','action'=>'contas'));
        }


    }

    public function ver_ajax(){
        //Consulta sem paginação
        /*        $this->set('lancamentos', $this->Lancamento->find('all',
                    array('conditions' => array(
                        'ContaUsuario.usuario_id' => $this->Auth->User('id')
                    ),
                        'recursive' => 2,
                        'order' => array('Lancamento.data DESC, Lancamento.id DESC')
                    )));*/

        //consulta com paginação
        $this->Paginator->settings = array(
            'limit' => 20,
            'order' => array(
                'Lancamento.data' => 'desc',
                'Lancamento.id' => 'desc'
            ),
            'recursive' => 2
        );
        $this->set('lancamentos', $this->Paginator->paginate('Lancamento',
            array('ContaUsuario.usuario_id' => $this->Auth->User('id')
            )));
   }
} 