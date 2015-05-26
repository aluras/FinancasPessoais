<?php
echo $this->Paginator->options(array(
    'update' => '#ultimos_lancamentos',
    'evalScripts' => true,
    'before' => $this->Js->get('#busy-indicator')->effect('fadeIn', array('buffer' => false)),
    'complete' => $this->Js->get('#busy-indicator')->effect('fadeOut', array('buffer' => false)),
));
?>
<table>
   <!-- <tr>
        <th>Grupo</th>
        <th align="right">Valor</th>
    </tr>-->
    <?php
    $data = null;
    $conta = null;
    foreach ($lancamentos as $lancamento):
        if($data != $lancamento['Lancamento']['data']) {
            $data = $lancamento['Lancamento']['data'];
            $conta = null;?>
            <tr class="ultimosLancamentosData">
                <td colspan="2" class="ultimosLancamentosData">
                    <?php echo CakeTime::format($lancamento['Lancamento']['data'], '%d/%m/%Y'); ?>
                </td>
            </tr>
        <?php }
        if($conta != $lancamento['Lancamento']['conta_usuario_id']) {
            $conta = $lancamento['Lancamento']['conta_usuario_id'];?>
            <tr class="ultimosLancamentosConta">
                <td colspan="2" class="ultimosLancamentosConta"><strong>
                    <?php echo $lancamento['ContaUsuario']['Conta']['nome']; ?>
                </strong></td>
            </tr>
        <?php }?>
        <tr>
<!--            <td>--><?php //echo CakeTime::format($lancamento['Lancamento']['data'], '%d/%m/%Y'); ?><!--</td>-->
            <td class="ultimosLancamentosGrupos"><?php echo $lancamento['Subgrupo']['nome']; ?>
                &nbsp;-&nbsp;
                <?php echo $lancamento['Subgrupo']['Grupo']['nome']; ?></td>
            <td align="right" class="<?php
                if($lancamento['Lancamento']['valor']<0){
                    echo 'ultimosLancamentosValorNegativo';
                }else{
                    echo 'ultimosLancamentosValor';
                }
            ?>"><?php echo CakeNumber::currency($lancamento['Lancamento']['valor']); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php unset($lancamento); ?>
</table>
<?php
    echo $this->Paginator->numbers();
    echo $this->Js->writeBuffer();
?>