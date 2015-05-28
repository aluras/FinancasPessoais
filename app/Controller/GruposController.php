<?php
App::uses('AppController','Controller');

class GruposController extends AppController{
    public $components = array('RequestHandler');

    public function listar_json()
    {
        $dados =$this->Grupo->find('all',array());
        $this->autoRender = false;
        $this->response->body(json_encode($dados));

    }

}