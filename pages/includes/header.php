<?php
  $parametros = \views\mainView::$par;
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Portal Imobiliário</title>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="<?= INCLUDE_PATH ?>css/style.css">
</head>
<body>
<base base="<?= INCLUDE_PATH ?>">

  <header>
    <div class="container">
      <div class="logo"><a href="<?= INCLUDE_PATH ?>">Portal imobi</a></div><!--logo-->
      <nav class="desktop">
        <ul>
          <?php
            $sql = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` ORDER BY `order_id` ASC");
            $sql->execute();
            $empreendimentos = $sql->fetchAll();
            foreach($empreendimentos as $key => $value){
          ?>
            <li><a href="<?= INCLUDE_PATH.$value['slug'] ?>"><?= $value['nome'] ?></a></li>
          <?php } ?>
        </ul>
      </nav><!--desktop-->
    </div><!--container-->
  </header>
    
  <section class="search1">
    <div class="container">
      <h2>What are you looking for?</h2>
      <input type="text" name="texto__busca">
    </div><!--container-->
  </section><!--search1-->

  <section class="search2">
    <div class="container">
      <form class="form_search2" method="post" action="<?= INCLUDE_PATH ?>ajax/formularios.php">

        <div class="form__group">
          <label for="area_minima">Minimum Area: </label>
          <input name="area_minima" type="number" min="0" max="100000" step="100">
        </div><!--form__group-->

        <div class="form__group">
          <label for="area_maxima">Maximum area: </label>
          <input name="area_maxima" type="number" min="0" max="100000" step="100">
        </div><!--form__group-->

        <div class="form__group">
          <label for="preco_min">Minimum price: </label>
          <input name="preco_min" type="text">
        </div><!--form__group-->

        <div class="form__group">
          <label for="preco_max">Maximum price: </label>
          <input name="preco_max" type="text">
        </div><!--form__group-->

        <?php
          if(isset($parametros['slug_empreendimento'])){
            echo '<input type="hidden" name="slug_empreendimento" value="'.$parametros['slug_empreendimento'].'">';
          }
        ?>

      </form>
    </div><!--container-->
  </section><!--search2-->