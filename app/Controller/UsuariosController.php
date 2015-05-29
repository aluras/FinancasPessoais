<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsuariosController extends AppController {
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout', 'login', 'add');
    }

    public function view($id = null) {
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuário inválido.'));
        }
        $this->set('usuario', $this->Usuario->read(null, $id));
    }

    public function add() {
        if ($this->request->is('post')) {
            $this->Usuario->create();
            if ($this->Usuario->save($this->request->data)) {
                $this->Session->setFlash(__('Usuário cadastrado.'));
                return $this->redirect(array('action' => 'login'));
            }
            $this->Session->setFlash(
                __('Ocorreu um erro. Tente novamente.')
            );
        }
    }

    public function edit($id = null) {
        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuário inválido.'));
        }
        if ($this->request->is('post') || $this->request->is('put')) {
            if ($this->Usuario->save($this->request->data)) {
                $this->Session->setFlash(__('Alteração efetuada.'));
                return $this->redirect(array('action' => 'index'));
            }
            $this->Session->setFlash(
                __('Não foi possível completar a operação. Tente novamente.')
            );
        } else {
            $this->request->data = $this->Usuario->read(null, $id);
            unset($this->request->data['User']['password']);
        }
    }

    public function delete($id = null) {
        // Prior to 2.5 use
        // $this->request->onlyAllow('post');

        $this->request->allowMethod('post');

        $this->Usuario->id = $id;
        if (!$this->Usuario->exists()) {
            throw new NotFoundException(__('Usuário inválido.'));
        }
        if ($this->Usuario->delete()) {
            $this->Session->setFlash(__('Usuário excluído'));
            return $this->redirect(array('action' => 'index'));
        }
        $this->Session->setFlash(__('O usuário não pode ser excluído.'));
        return $this->redirect(array('action' => 'index'));
    }

    public function login() {
        if ($this->request->is('post')) {
            if($this->Auth->login()){
                return $this->redirect($this->Auth->redirectUrl());
            }else{
                $this->Session->setFlash(__('Email ou senha inválido. Tente novamente.'));

            }
        }
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}