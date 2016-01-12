<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Html->charset(); ?>
    <title>
        <?php echo $cakeDescription ?>:
        <?php echo $this->fetch('title'); ?>
    </title>
    <?php
    echo $this->Html->meta('icon');

    //echo $this->Html->css('cake.generic');
    echo $this->Html->css('jquery-ui');
    echo $this->Html->css('geral');
    echo $this->Html->script('jquery-1.11.2.min');
    echo $this->Html->script('jquery-ui');

    echo $this->fetch('meta');
    echo $this->fetch('css');
    echo $this->fetch('script');
    ?>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body class="clearfix">
<div id="container">
    <div id="dialog">
        <div id="mensagem"></div>
        <div id="progressBar"></div>
    </div>
    <div id="content">

        <?php echo $this->Session->flash(); ?>


        <div id="login_buttons" style="text-align: center; margin: 10em;">
            <?php echo $this->Html->image('logo_completo.png', array('alt' => 'Algum', 'border' => '0')); ?>
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
    </div>
    <div id="footer">
        <?php echo $this->Html->image('logo_aluras2.png', array('alt' => 'Feito por Aluras', 'border' => '0')); ?>
    </div>
</div>
<?php /*echo $this->element('sql_dump'); */?>
<?php echo $this->Js->writeBuffer(); ?>
</body>
</html>

