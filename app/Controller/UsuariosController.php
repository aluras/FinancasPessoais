<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsuariosController extends AppController {
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout', 'login', 'add', 'login_terceiros','login_callback');
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
                //return $this->redirect(array('action' => 'index'));
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
        }else{
            return $this->Auth->login();
        }
    }

    public function login_terceiros(){
        require_once 'Google/autoload.php';

        $google_client_id = '48636432617-l6duqf4jpe3irph355fas92mqfcimfmr.apps.googleusercontent.com';
        $google_client_secret = 'Vax1iehlEXy3bI6PP7hgoT1N';
        $google_redirect_url = 'http://localhost:81/FinancasPessoais/usuarios/login_callback';

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to localhost');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->addScope('email');

        //get google login url
        $authUrl = $gClient->createAuthUrl();

        $this->set('authUrl', $authUrl);

    }

    public function login_callback(){
        require_once 'Google/autoload.php';

        $google_client_id = '48636432617-l6duqf4jpe3irph355fas92mqfcimfmr.apps.googleusercontent.com';
        $google_client_secret = 'Vax1iehlEXy3bI6PP7hgoT1N';
        $google_redirect_url = 'http://localhost:81/FinancasPessoais/usuarios/login_callback';

        $gClient = new Google_Client();
        $gClient->setApplicationName('Login to localhost');
        $gClient->setClientId($google_client_id);
        $gClient->setClientSecret($google_client_secret);
        $gClient->setRedirectUri($google_redirect_url);
        $gClient->addScope('email');

        $google_oauthV2 = new Google_Service_Oauth2($gClient);

        //If user wish to log out, we just unset Session variable
        if (isset($_REQUEST['reset']))
        {
            $this->set('msg', 'Logout');
            //unset($_SESSION['token']);
            $this->Session->delete('token');
            $gClient->revokeToken();
            header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
        }

        //Redirect user to google authentication page for code, if code is empty.
        //Code is required to aquire Access Token from google
        //Once we have access token, assign token to session variable
        //and we can redirect user back to page and login.
        if (isset($_REQUEST['code']))
        {
            $gClient->authenticate($_REQUEST['code']);
            $this->Session->write('token', $gClient->getAccessToken());
            $this->redirect(filter_var($google_redirect_url, FILTER_SANITIZE_URL), null, false);
            return;
        }

        if ($this->Session->read('token'))
        {
            $gClient->setAccessToken($this->Session->read('token'));
        }

        if ($gClient->getAccessToken())
        {
            //Get user details if user is logged in
            $user = $google_oauthV2->userinfo->get();
            $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
            $token = $gClient->getAccessToken();
            $this->Session->write('token', $token);
            $this->Session->write('usuario', $user_name);
            $this->Session->write('usuario_img', $profile_image_url);

            $usuario = $this->Usuario->find('first',
                array('conditions' => array('Usuario.email'=> $email)));

            if (count($usuario)>0){
                $usuario['Usuario']['token_google'] = json_decode($token,true)['access_token'];
                if ($this->Usuario->save($usuario)) {
                    //$this->Session->setFlash(__('Alteração efetuada.'));
                    return $this->redirect(array(
                        'controller' => 'lancamentos',
                        'action' => 'principal'));
                }
            }else{
                $this->Usuario->create();
                $this->Usuario->set('email',$email);
                $this->Usuario->set('token_google',json_decode($token,true)['access_token']);
                if ($this->Usuario->save()) {
                    $this->Session->setFlash(__('Usuário cadastrado.'));
                    return $this->redirect(array(
                        'controller' => 'lancamentos',
                        'action' => 'principal'));
                }
                $this->Session->setFlash(
                    __('Ocorreu um erro. Tente novamente.')
                );
            }

            $msg1 = 'Hi '.$user_name.', Thanks for Registering!';
            $msg1 .= '<br />';
            $msg1 .= '<img src="'.$profile_image_url.'" width="100" align="left" hspace="10" vspace="10" />';
            $msg1 .= '<br />';
            $msg1 .= '&nbsp;Name: '.$user_name.'<br />';
            $msg1 .= '&nbsp;Email: '.$email.'<br />';
            $msg1 .= '<br />';
            $this->set('msg', $msg1);

        }
        //return $this->Auth->login();
    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}