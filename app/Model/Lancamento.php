<?php
App::uses('AppModel', 'Model');
App::uses('Subgrupo', 'Model');
App::uses('ContaUsuario', 'Model');

class Lancamento extends AppModel{

    private  $dataSource;

    public $belongsTo = array(
        'Subgrupo', 'ContaUsuario'
    );

    public $validate = array(
        'valor' => array(
            'rule' => array('comparison', '>', 0),
            'message' => 'Lançamentos devem ser maior que zero!'
        )
    );

    /*
     *
        public function save($data = null, $validate = true, $fieldList = array()){
            $datasource = $this->getDataSource();
            try{
                $datasource->begin();

                //Caso subgrupo seja despesa, transforma valor para negativo
                $subgrupoModel = new Subgrupo();
                $subgrupo = $subgrupoModel->find('first',array(
                    'conditions' => array('Subgrupo.id' => $data['Lancamento']['subgrupo_id'])
                ));
                if($subgrupo['Grupo']['id_tipo_grupo'] == 1){
                    $data['Lancamento']['valor'] = abs($data['Lancamento']['valor']) * -1;
                }else{
                    $data['Lancamento']['valor'] = abs($data['Lancamento']['valor']);
                }

                if (!parent::save($data)){
                    throw new Exception('Erro ao gravar!');
                }

                //Atualiza saldo na conta
                $model = new ContaUsuario();
                $model->Behaviors->load('Containable');
                $contaUsuario = $model->find('first', array(
                    'conditions' => array('ContaUsuario.id' => $data['Lancamento']['conta_usuario_id']),
                    'contain' => array('Conta')
                ));
                $contaUsuario['Conta']['saldo'] =  $contaUsuario['Conta']['saldo'] + $data['Lancamento']['valor'];
                if(!$this->ContaUsuario->Conta->save($contaUsuario['Conta'])){
                    throw new Exception('Erro ao gravar!');
                }
                $datasource->commit();
                return true;

            }catch (Exception $e) {
                $datasource->rollback();
                throw $e;
            }
        }
    */

    public function gravaTransferencia($data = null, $validate = true, $fieldList = array()){
        $data['Lancamento']['conta_usuario_id'] = $data['Lancamento']['conta_usuario_destino_id'];
        parent::save($data);
        $data['Lancamento']['conta_usuario_id'] = $data['Lancamento']['conta_usuario_origem_id'];
        return parent::save($data);
    }

    public function beforeSave($options = array()) {
        $subgrupoModel = new Subgrupo();
        $subgrupo = $subgrupoModel->find('first',array(
            'conditions' => array('Subgrupo.id' => $this->data['Lancamento']['subgrupo_id'])
        ));
        if($subgrupo['Grupo']['id_tipo_grupo'] == 1 || $this->data['Lancamento']['conta_usuario_id'] == $this->data['Lancamento']['conta_usuario_origem_id']){
            $this->data['Lancamento']['valor'] = abs($this->data['Lancamento']['valor']) * -1;
        }else{
            $this->data['Lancamento']['valor'] = abs($this->data['Lancamento']['valor']);
        }
        return true;
    }

    public function afterSave($created, $options = array()){
        $model = new ContaUsuario();
        $model->Behaviors->load('Containable');
        $contaUsuario = $model->find('first', array(
            'conditions' => array('ContaUsuario.id' => $this->data['Lancamento']['conta_usuario_id']),
            'contain' => array('Conta')
        ));
        $contaUsuario['Conta']['saldo'] =  $contaUsuario['Conta']['saldo'] + $this->data['Lancamento']['valor'];
        $this->ContaUsuario->Conta->save($contaUsuario['Conta']);
    }

}
