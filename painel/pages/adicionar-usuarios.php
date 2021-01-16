<?php
    verificaPermissaoPagina(0);
?>
<div class="box__content">
    
    <h2><i class="fas fa-user-edit"></i> Cadastrar Usuário</h2>

    <form method="post" enctype="multipart/form-data">

    <?php
        if(isset($_POST['acao'])){
            $image = true;
            $login = $_POST['login'];
            $senha = $_POST['password'];
            $nome = $_POST['nome'];
            $cargo = $_POST['cargo'];
            $imagem = $_FILES['imagem'];
            $color = new OptionSorter(['#f6d6d6', '#f4f6d6', '#d6f6d7', '#d6edf6', '#e8d6f6']);
            $colorUser = $color->sort();
            if($login == ''){
                Painel::alert('erro','O login está vázio!');
            }else if($senha == ''){
                Painel::alert('erro','A senha está vázio!');
            }else if($nome == ''){
                Painel::alert('erro','O nome está vázio!');
            }else if($cargo == ''){
                Painel::alert('erro','O cargo precisá está selecionado!');
            }else{
                //can register
                if($cargo <= $_SESSION['cargo']){
                    Painel::alert('erro','Você precisa selecionar um cargo menor que o seu!');
                }else if(Usuario::userExists($login)){
                    Painel::alert('erro','O login já existe, selecione outro por favor!'); 
                }else{
                    //only register at db
                    if($image == true && Painel::imagemValida($imagem) == false){
                        $image = false;
                        $imagem = '';
                    }
                    $usuario = new Usuario();
                    if($image == true)
                        $imagem = Painel::uploadFile($imagem);
                    $usuario->cadastrarUsuario($login,$senha,$imagem,$nome,$cargo,$colorUser);
                    Painel::alert('sucesso','O cadastro do usuário '.$login.' foi feito com sucesso!');
                }
            }
        }
    ?>

        <div class="form__group">
            <label>Login:</label>
            <input type="text" name="login">
        </div><!--form__group-->

        <div class="form__group">
            <label>Senha:</label>
            <input type="password" name="password">
        </div><!--form__group-->

        <div class="form__group">
            <label>Nome:</label>
            <input type="text" name="nome">
        </div><!--form__group-->

        <div class="form__group">
            <label>Cargo:</label>
            <select name="cargo">
                <?php 
                    foreach (Painel::$cargos as $key => $value){
                        if($key > $_SESSION['cargo']) echo '<option value="'.$key.'">'.$value.'<options>';
                    }
                ?>
            </select>
        </div><!--form__group-->

        <div class="form-group">
			<label>Imagem</label>
			<input type="file" name="imagem"/>
		</div><!--form-group-->

        <div class="form__group">
            <input type="submit" name="acao" value="Atualizar">
        </div><!--form__group-->

    </form>

</div><!--box__content-->