<?php
App::uses('AppController', 'Controller');
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class UsuariosController extends AppController {
    public $components = array('RequestHandler');

    public function beforeFilter() {
        parent::beforeFilter();
        $this->Auth->allow('logout', 'login', 'add', 'google_login');
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

    public function google_login(){
        require_once 'Google/autoload.php';

        $google_client_id = '48636432617-l6duqf4jpe3irph355fas92mqfcimfmr.apps.googleusercontent.com';
        $google_client_secret = 'Vax1iehlEXy3bI6PP7hgoT1N';
        $google_redirect_url = 'http://localhost:81/FinancasPessoais/usuarios/login_callback/';

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
            //header('Location: ' . filter_var($google_redirect_url, FILTER_SANITIZE_URL));
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
            $user_id = $user['id'];
            $user_name = filter_var($user['name'], FILTER_SANITIZE_SPECIAL_CHARS);
            $email = filter_var($user['email'], FILTER_SANITIZE_EMAIL);
            $profile_url = filter_var($user['link'], FILTER_VALIDATE_URL);
            $profile_image_url = filter_var($user['picture'], FILTER_VALIDATE_URL);
            $personMarkup = "$email<div><img src='$profile_image_url?sz=50'></div>";
            $this->Session->write('token', $gClient->getAccessToken());
        }
        else
        {
            //get google login url
            $authUrl = $gClient->createAuthUrl();
        }

        if(isset($authUrl)) //user is not logged in, show login button
        {
            $this->set('authUrl', $authUrl);
        }
        else // user logged in
        {
            $result = $this->User->find('count', array('conditions' => array('google_id' => $user_id)));
            if($result > 0)
            {
                $msg = 'Welcome back '.$user_name.'!<br />';
                $msg .= '<br />';
                $msg .= '<img src="'.$profile_image_url.'" width="100" align="left" hspace="10" vspace="10" />';
                $msg .= '<br />';
                $msg .= '&nbsp;Name: '.$user_name.'<br />';
                $msg .= '&nbsp;Email: '.$email.'<br />';
                $msg .= '<br />';
                $this->set('msg', $msg);
            }
            else
            {
                $msg1 = 'Hi '.$user_name.', Thanks for Registering!';
                $msg1 .= '<br />';
                $msg1 .= '<img src="'.$profile_image_url.'" width="100" align="left" hspace="10" vspace="10" />';
                $msg1 .= '<br />';
                $msg1 .= '&nbsp;Name: '.$user_name.'<br />';
                $msg1 .= '&nbsp;Email: '.$email.'<br />';
                $msg1 .= '<br />';
                $this->set('msg', $msg1);
                $this->User->query("INSERT INTO google_users (google_id, google_name, google_email, google_link, google_picture_link) VALUES ($user_id, '$user_name', '$email', '$profile_url', '$profile_image_url')");
            }
        }
        debug('fim');



    }

    public function logout() {
        return $this->redirect($this->Auth->logout());
    }
}