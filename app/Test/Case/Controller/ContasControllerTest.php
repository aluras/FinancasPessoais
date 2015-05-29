<?php
/**
 * Created by PhpStorm.
 * User: sn1007071
 * Date: 28/05/2015
 * Time: 16:20
 */
App::uses('BlowfishPasswordHasher', 'Controller/Component/Auth');

class ContasControllerTest extends ControllerTestCase {

    public function testListar(){
        $hasher = new BlowfishPasswordHasher();

        $result = $this->testAction(
            '/contas/listar.json',
            array('method' => 'get',
                  'data' => array(
                      'Usuario' => array(
                          'email'=>'andrelrs80@gmail.com',
                          'password' => $hasher->hash('ingles')
                      )
                  )
            )
        );
        debug(json_decode($result,true));
    }
} 