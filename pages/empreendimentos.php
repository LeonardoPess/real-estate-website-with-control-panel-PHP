<?php
  $parametros = \views\mainView::$par;
?>
<section class="lista__imoveis">
    
  <div class="container">

  <h2 class="title__busca">Listanto <b><?= count($parametros['imoveis']); ?> Imóveis</b> em <?= $parametros['nome_empreendimento']; ?></h2>

  <?php 
    foreach($parametros['imoveis'] as $key => $value){ 
    $imagem = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.imagens_imoveis` WHERE `imovel_id` = $value[id]");
    $imagem->execute();
    $imagem = $imagem->fetch()['imagem'];
  ?>

    <div class="row__imoveis">
      <div class="r1">
        <img src="<?= INCLUDE_PATH_PAINEL ?>uploads/<?= $imagem ?>" alt="imóvel">
      </div><!--r1-->

      <div class="r2">
        <p><i class="fa fa-info"></i> Nome do Imóvel: <?= $value['nome'] ?></p>
        <p><i class="fa fa-info"></i> Área: <?= $value['area'] ?></p>
        <p><i class="fa fa-info"></i> Preço: <?= \Painel::convertMoney($value['preco']) ?></p>
      </div><!--r2-->
    </div><!--row__imoveis-->

    <?php } ?>

  </div><!--container-->

</section><!--lista__imoveis-->
