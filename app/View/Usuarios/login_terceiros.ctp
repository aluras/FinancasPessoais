<?php echo $this->Session->flash('auth'); ?>
<div id="login_buttons" style="text-align: center">
    <p>Entrar</p>

<?php
if(isset($authUrl)) //user is not logged in, show login button
{
    echo $this->Html->image('google+.png',
                            array(  'alt' => 'Entre com sua conta do Google',
                                    'url' => $authUrl,
                                    'class' => 'login_terceiros',
                                    'border' => '0'
                                )
                            );
}
?>

<?php
    echo $this->Html->image('facebook.png',
        array(  'alt' => 'Entre com sua conta do Facebook',
            'url' => '',
            'class' => 'login_terceiros',
            'border' => '0'
        )
    );

?>

</div>