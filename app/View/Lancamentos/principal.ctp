<div id="lancamentoTop">
    <div id="tipoLancamento">
        <input type="radio" id="lancamentoDespesa" name="tipoLancamento" onclick="selecionaTipoLancamento(this, 1)" checked><label id="lblLancamentoDespesa" for="lancamentoDespesa" class="tipoLancamento tipoLancamentoSelecionado" >Despesa</label>
        <input type="radio" id="lancamentoReceita" name="tipoLancamento" onclick="selecionaTipoLancamento(this, 2)"><label id="lblLancamentoReceita" for="lancamentoReceita" class="tipoLancamento">Receita</label>
        <input type="radio" id="lancamentoTransferencia" name="tipoLancamento" onclick="selecionaTipoLancamento(this, 3)"><label id="lblLancamentoTransferencia" for="lancamentoTransferencia" class="tipoLancamento">Transferência</label>
        <!--<button id="lancamentoDespesa" onclick="selecionaTipoLancamento(this, 1)" class="tileTipoLancamentoSelecionado" >Despesa</button>
        <button id="lancamentoReceita" onclick="selecionaTipoLancamento(this, 2)">Receita</button>
        <button id="lancamentoTransferencia" onclick="selecionaTipoLancamento(this,3)">Transferência</button>-->
    </div>
    <div id="lancamentoDetalhe">
    </div>
</div>
<div id="lancamentoCadastro">
    <div id="adicionar">
        <p id='busy-indicator' style='display: none'>Carregando...</p>
    </div>
    <div id="formulario" style="display: none;">
        <?php
        echo $this->Form->create('Lancamento', array('default' => false, 'id'=>'lancamentoForm'));
        echo $this->Form->input('data',array('dateFormat' => 'DMY'));
        echo $this->Form->input('descricao', array('id' => 'descricao'));
        echo $this->Form->input('valor', array('id' => 'valor'));
        echo $this->Form->hidden('conta_usuario_credito_id', array('id' => 'conta_usuario_credito_id'));
        echo $this->Form->hidden('conta_usuario_debito_id', array('id' => 'conta_usuario_debito_id'));
        echo $this->Form->hidden('subgrupo_id', array('id' => 'subgrupo_id'));
        echo $this->Form->button('Gravar', array('id' => 'btnGravar'));
        ?>
    </div>
</div>
<div id="lancamentoUltimos">
    <div id='carregandoUltimos'></div>
    <h2>Últimos lançamentos</h2>
    <div id="ultimos_lancamentos_content"></div>
</div>

<script>
    $(function(){
        $('#carregandoUltimos').progressbar({value: false});
    })


    $('#btnGravar').click(function(event) {
        if(adicionarPrepara()){
            form = $("#lancamentoForm").serialize();
            $.ajax({
                type: "POST",
                url: "<?php echo Router::url(array('controller'=>'lancamentos','action'=>'adicionar'));?>",
                data: form,

                success: function(data){
                    adicionarRetorno(data);
                    wait = false;
                },
                error: function(data) {
                    mostraMensagem('Erro:',data.responseText);
                    wait = false;
                }
            });
            event.preventDefault();
       }
        return false;  //stop the actual form post !important!

    });

    var tipoLancamento = 1;
    var wait = false;

    carregaUltimos();

    $.getJSON(
        '<?php echo Router::url(array('controller'=>'grupos','action'=>'listar_json','ext' => 'json'));?>',
        function(data){
            grupos = data;
            mostraContas();
        }
    )
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            mostraMensagem('Erro:', err)
        });

    $.getJSON(
        '<?php echo Router::url(array('controller'=>'contas','action'=>'listar','ext' => 'json'));?>',
        function(data){
            contas = data;
            mostraContas();
        }
    )
        .fail(function( jqxhr, textStatus, error ) {
            var err = textStatus + ", " + error;
            mostraMensagem('Erro:', err)
        });

    function carregaUltimos(){
        $('#carregandoUltimos').show();
        $.ajax({
            url: '<?php echo Router::url(array('controller'=>'lancamentos','action'=>'ver_ajax'));?>',
            cache: false,
            type: 'GET',
            dataType: 'HTML',
            success: function (data) {
                $('#ultimos_lancamentos_content').html(data);
                $('#carregandoUltimos').hide();
            }
        });
    }

    function mostraContas(){
        if (typeof contas !== 'undefined' && typeof grupos !== 'undefined'){
            $("#lancamentoDetalheConta").remove();
            $("#lancamentoDetalheGrupo").remove();
            $("#lancamentoDetalheSubgrupo").remove();
            mostraForulario(false);
            $("#lancamentoTop").show();
            $('#adicionar').html('');
            if (contas.length == 1) {
                selecionaConta(contas[0])
            }else{
                $.each( contas, function( key, val ) {
                    if(val['Conta']['tipo_conta_id'] != 2 || tipoLancamento != 1){
                        var btnConta = document.createElement("button");
                        $(btnConta).addClass("tile").html(val['Conta']['nome']).appendTo("#adicionar");
                        $(btnConta).click(function(){selecionaConta(val)});
                    }
                });
            }
        }
    }

    function mostraContasTransferenciaDestino(subGrupo){
        if (typeof subGrupo !== 'undefined'){
            mostraForulario(false);
            $('#adicionar').html('');
            if (contas['ContaUsuario'].length == 1) {
                selecionaConta(contas['ContaUsuario'][0])
            }else{
                $.each( contas['ContaUsuario'], function( key, val ) {
                    if (subGrupo["tipo_conta_destino_id"] == null || val['Conta']["tipo_conta_id"] == subGrupo["tipo_conta_destino_id"]){
                        var btnConta = document.createElement("button");
                        $(btnConta).addClass("tile").html(val['Conta']['nome']).appendTo("#adicionar");
                        $(btnConta).click(function(){selecionaContaTransferenciaDestino(val, subGrupo)});
                    }
                });
            }
        }
    }

    function mostraContasTransferenciaOrigem(subGrupo){
        if (typeof subGrupo !== 'undefined'){
            mostraForulario(false);
            $('#adicionar').html('');
            if (contas['ContaUsuario'].length == 1) {
                selecionaConta(contas['ContaUsuario'][0])
            }else{
                $.each( contas['ContaUsuario'], function( key, val ) {
                    if (subGrupo["tipo_conta_origem_id"] == null || val['Conta']["tipo_conta_id"] == subGrupo["tipo_conta_origem_id"]){
                        var btnConta = document.createElement("button");
                        $(btnConta).addClass("tile").html(val['Conta']['nome']).appendTo("#adicionar");
                        $(btnConta).click(function(){selecionaContaTransferenciaOrigem(val, subGrupo)});
                    }
                });
            }
        }
    }

    function mostraGrupos(){
        $("#lancamentoDetalheGrupo").remove();
        $("#lancamentoDetalheSubgrupo").remove();
        mostraForulario(false);
        $('#adicionar').html('');
        $.each( grupos, function( key, val ) {
            if (val['Grupo']['id_tipo_grupo'] == tipoLancamento){
                var btnGrupo = document.createElement("button");
                $(btnGrupo).addClass("tile").html(val['Grupo']['nome']).appendTo("#adicionar");
                $(btnGrupo).click(function(){selecionaGrupo(val)});
            }
        });
        if($('#adicionar button').length == 1){
            $('#adicionar button')[0].click();
        }
}

    function mostraSubgrupos(grupo){
        $("#lancamentoDetalheSubgrupo").remove();
        $('#adicionar').html('');
        mostraForulario(false);
        $.each( grupo['Subgrupo'], function( key, val ) {
            var btnSubgrupo = document.createElement("button");
            $(btnSubgrupo).addClass("tile").html(val['nome']).appendTo("#adicionar");
            $(btnSubgrupo).click(function(){selecionaSubgrupo(val)});
        });
    }

    function selecionaTipoLancamento(input, tipo){
        tipoLancamento = tipo;
        $('#tipoLancamento > label').removeClass('tipoLancamentoSelecionado');
        $("label[for='"+$(input).attr('id')+"']").addClass('tipoLancamentoSelecionado');
        $("#lancamentoDetalhe").html("");
        if (tipo == 3){
            mostraGrupos();
        }else{
            mostraContas();
        }
    }

    function selecionaConta(conta){
        var b = document.createElement("button");
        $(b).attr("id","lancamentoDetalheConta").html(conta['Conta']['nome']).appendTo("#lancamentoDetalhe");
        $(b).click(function(){mostraContas()});
        $(b).button();
        if(tipoLancamento == 1){
            $('#conta_usuario_debito_id').val(conta['Conta']['id']);
        }else{
            $('#conta_usuario_credito_id').val(conta['Conta']['id']);
        }
        mostraGrupos();
    }

    function selecionaContaTransferenciaDestino(conta, subGrupo){
        var b = document.createElement("button");
        $(b).attr("id","lancamentoDetalheContaDestino").html(conta['Conta']['nome']).appendTo("#lancamentoDetalhe");
        $(b).click(function(){mostraContasTransferenciaDestino(subGrupo)});
        $(b).button();
        $('#conta_usuario_credito_id').val(conta['Conta']['id']);
        mostraContasTransferenciaOrigem(subGrupo);
    }

    function selecionaContaTransferenciaOrigem(conta, subGrupo){
        var b = document.createElement("button");
        $(b).attr("id","lancamentoDetalheContaOrigem").html(conta['Conta']['nome']).appendTo("#lancamentoDetalhe");
        $(b).click(function(){mostraContasTransferenciaOrigem(subGrupo)});
        $(b).button();
        $('#conta_usuario_debito_id').val(conta['Conta']['id']);
        mostraForulario(true);
    }

    function selecionaGrupo(grupo){
        var b = document.createElement("button");
        $(b).attr("id","lancamentoDetalheGrupo").html(grupo['Grupo']['nome']).appendTo("#lancamentoDetalhe");
        $(b).click(function(){mostraGrupos()});
        $(b).button();
        mostraSubgrupos(grupo);
    }

    function selecionaSubgrupo(subgrupo){
        var b = document.createElement("button");
        $(b).attr("id","lancamentoDetalheSubgrupo").html(subgrupo['nome']).appendTo("#lancamentoDetalhe");
        $('#subgrupo_id').val(subgrupo['id']);
        $(b).button();
        if (tipoLancamento == 3){
            mostraContasTransferenciaDestino(subgrupo);
        }else{
            mostraForulario(true);
        }
    }

    function mostraForulario(value){
        if(value){
            $('#adicionar').hide();
            $('#formulario').show();
            $('#valor').focus();
        }else{
            $('#adicionar').show();
            $('#formulario').hide();
        }
    }

    function adicionarRetorno(data){
        $("#lancamentoForm")[0].reset();
        carregaUltimos();
        $("#lancamentoDetalhe").html("");
        if (tipoLancamento == 3){
            mostraGrupos();
        }else{
            mostraContas();
        }
    }

    function adicionarPrepara(){
        if (wait == true){
            mostraMensagem('Atenção:', 'Aguarde a gravação atual!')
            return false;
        }else{
            wait = true;
            return true;
        }
    }

    function mostraMensagem(titulo, mensagem){
        $('#mensagem').html(mensagem);
        $("#mensagem").dialog({
            modal: false,
            title: titulo,
            dialogClass: "no-close",
            buttons: {
                "OK": {
                    class: "btn btn-primary",
                    text: "OK",
                    click: function() { $(this).dialog("close"); }
                }
            }
        });
    }

</script>