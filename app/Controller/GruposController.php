<?php
App::uses('AppController','Controller');

class GruposController extends AppController{
    public $components = array('RequestHandler');

    public function listar()
    {
        $dados =$this->Grupo->find('all',array());
        $this->set('grupos',$dados);
        $this->set('_serialize', array('grupos'));
    }

    public function sub_grupos($id){
        $this->set('grupo',$this->Grupo->find('first',array(
            'conditions' => array(
                'id' => $id
            )
        )));
    }
}