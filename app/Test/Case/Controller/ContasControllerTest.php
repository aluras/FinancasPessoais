<?php
/**
 * Created by PhpStorm.
 * User: sn1007071
 * Date: 28/05/2015
 * Time: 16:20
 */

class ContasControllerTest extends ControllerTestCase {

    public function testListar(){
        $result = $this->testAction(
            '/contas/listar.json',
            array('method' => 'get')
        );
        debug(json_decode($result,true));
    }
} 