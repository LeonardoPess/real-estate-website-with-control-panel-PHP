<?php
	include('../config.php');
	$data = array();
	$data['sucesso'] = true;
	$data = "";

	
	if(isset($_POST['slug_empreendimento'])){
		//Estamos na página de um empreendimento específico.
		$preco_min = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['preco_min']));
		if($preco_min === ''){
			$preco_min = 0;
		}
		$preco_max = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['preco_max']));
		if($preco_max === ''){
			$preco_max = 9999999;
		}
		$area_min = $_POST['area_minima'];
		if($area_min === ''){
			$area_min = 0;
		}
		$area_max = $_POST['area_maxima'];
		if($area_max === ''){
			$area_max = 9999999;
		}
		$slug_empreendimento = $_POST['slug_empreendimento'];
		$nome_imovel = $_POST['nome_imovel'];
		
		$infoEmpreendimento = \MySql::conectar()->prepare("SELECT * FROM `tb_admin.empreendimentos` WHERE slug = ?");
		$infoEmpreendimento->execute(array($slug_empreendimento));
		$infoEmpreendimento = $infoEmpreendimento->fetch();
		$sql = \MySql::conectar()->prepare("SELECT `tb_admin.imoveis`.* FROM `tb_admin.imoveis` WHERE (preco >= ? AND 
			preco <= ?) AND (area >= ? AND area <= ?) AND nome LIKE ? AND empreend_id = ?");
		$sql->execute(array($preco_min,$preco_max,$area_min,$area_max,"%$nome_imovel%",$infoEmpreendimento['id']));
		$imoveis = $sql->fetchAll();

        $data.='<h2 class="title__busca">Listanto <b>'.count($imoveis).' Imóveis</b> em '.$infoEmpreendimento['nome'].'</h2>';

        foreach ($imoveis as $key => $value) {
			$imagem = \MySql::conectar()->prepare("SELECT imagem FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $value[id]");
			$imagem->execute();
			$imagem = $imagem->fetch()['imagem'];
            $data.=
            '
            <div class="row__imoveis">
                <div class="r1">
                    <img src="'.INCLUDE_PATH_PAINEL.'uploads/'.$imagem.'" alt="imóvel">
                </div><!--r1-->

                <div class="r2">
                    <p><i class="fa fa-info"></i> Nome do Imóvel: '.$value['nome'].'</p>
                    <p><i class="fa fa-info"></i> Área: '.$value['area'].'m2</p>
                    <p><i class="fa fa-info"></i> Preço: R$'.\Painel::convertMoney($value['preco']).' ?></p>
                </div><!--r2-->
            </div><!--row__imoveis-->
            ';
        }
    }else{
        $preco_min = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['preco_min']));
		if($preco_min === ''){
			$preco_min = 0;
		}
		$preco_max = Painel::formatarMoedaBd(str_replace('R$ ','',$_POST['preco_max']));
		if($preco_max === ''){
			$preco_max = 9999999;
		}
		$area_min = $_POST['area_minima'];
		if($area_min === ''){
			$area_min = 0;
		}
		$area_max = $_POST['area_maxima'];
		if($area_max === ''){
			$area_max = 9999999;
		}
		$nome_imovel = $_POST['nome_imovel'];
		$sql = \MySql::conectar()->prepare("SELECT `tb_admin.imoveis`.* FROM `tb_admin.imoveis` WHERE `tb_admin.imoveis`.`preco` >= ? AND 
			`tb_admin.imoveis`.`preco` <= ? AND `tb_admin.imoveis`.`area` >= ? AND `tb_admin.imoveis`.`area` <= ? AND `tb_admin.imoveis`.`nome` LIKE ?");
		$sql->execute(array($preco_min,$preco_max,$area_min,$area_max,"%$nome_imovel%"));
		$imoveis = $sql->fetchAll();
		
        $data.='<h2 class="title__busca">Listanto <b>'.count($imoveis).' Imóveis</b></h2>';
        
        foreach ($imoveis as $key => $value) {
			$imagem = \MySql::conectar()->prepare("SELECT imagem FROM `tb_admin.imagens_imoveis` WHERE imovel_id = $value[id]");
			$imagem->execute();
			$imagem = $imagem->fetch()['imagem'];
            $data.='
            <div class="row__imoveis">
                <div class="r1">
                    <img src="'.INCLUDE_PATH_PAINEL.'uploads/'.$imagem.'" alt="imóvel">
                </div><!--r1-->

				<div class="r2">
                    <p><i class="fa fa-info"></i> Nome do Imóvel: '.$value['nome'].'</p>
                    <p><i class="fa fa-info"></i> Área: '.$value['area'].'m2</p>
                    <p><i class="fa fa-info"></i> Preço: R$'.\Painel::convertMoney($value['preco']).' ?></p>
                </div><!--r2-->
            </div><!--row__imoveis-->
            ';
		}
		
	}

	echo $data;