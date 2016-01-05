<?php
/**
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

$cakeDescription = __d('cake_dev', 'Finanças Pessoais');
$cakeVersion = __d('cake_dev', 'v 0.01')
?>
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
		<div id="header">
            <?php echo $this->Html->image('logo.png', array('alt' => 'Algum', 'border' => '0')); ?>
            <?php echo $this->Session->read('usuario'); ?>
            <?php echo $this->Html->image($this->Session->read('usuario_img'), array('alt' => 'Você', 'border' => '0')); ?>
            <ul style="display: none">
                <li><?php echo $this->Html->link('Cadastrar', array('controller'=>'Lancamentos','action'=>'principal')); ?></li>
                <li><?php echo $this->Html->link('Analisar', array('controller'=>'Lancamentos','action'=>'principal')); ?></li>
                <li><?php echo $this->Html->link('Configurar', array('controller'=>'Usuarios','action'=>'configurar')); ?></li>
                <li><?php echo $this->Html->link('Sair', array('controller'=>'Usuarios','action'=>'logout'))    ; ?></li>
            </ul>
		</div>
		<div id="content">

			<?php echo $this->Session->flash(); ?>

			<?php echo $this->fetch('content'); ?>
		</div>
		<div id="footer">
            <?php echo $this->Html->image('logo_aluras2.png', array('alt' => 'Feito por Aluras', 'border' => '0')); ?>
		</div>
	</div>
	<?php /*echo $this->element('sql_dump'); */?>
    <?php echo $this->Js->writeBuffer(); ?>
</body>
</html>
