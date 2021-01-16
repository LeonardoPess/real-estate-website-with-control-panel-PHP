<?php 
    include('config.php'); 
    Site::updateUsuarioOnline();
    Site::contador(); 

    $homeController = new controllers\homeController();
    $empreendimentoController = new controllers\empreendimentoController();

    Router::get('/',function() use ($homeController) {
        $homeController->index();
    });

    Router::get('/?',function($par) use ($empreendimentoController) {
        $empreendimentoController->index($par);
    });
    
?>

