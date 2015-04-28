<h2>Contas</h2>
<table>
    <tr>
        <th>Conta</th>
        <th>Tipo</th>
        <th>Saldo</th>
    </tr>
    <?php
    $data = null;
    foreach ($dados as $conta):
        /*
        if($data != $lancamento['Lancamento']['data']) {
            $data = $lancamento['Lancamento']['data']; ?>
            <tr>
                <td colspan="3">
                    <?php echo CakeTime::format($lancamento['Lancamento']['data'], '%d/%m/%Y'); ?>
                </td>
            </tr>

        <?php }*/?>
        <tr>
            <td><?php echo $conta['Conta']['nome']; ?></td>
            <td><?php echo $conta['TipoConta']['descricao']; ?></td>
            <td><?php echo CakeNumber::currency($conta['Conta']['saldo']); ?></td>
        </tr>
    <?php endforeach; ?>
    <?php unset($conta); ?>
</table>