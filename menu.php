<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <title>Museu Vão</title>
        <meta charset="utf-8"> 
        <link href="Imagens/icon.png" rel="icon">

        <!-- Imports -->
            <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
            <script src="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
            <script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
            <link rel="stylesheet" href="css/bootstrap.min.css">
            <script src="js/jquery-3.3.1.slim.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/sweetalert.min.js"></script>
            <link rel="stylesheet" href="css/sweetalert.css">
            <script src="js/jquery-3.3.1.js"></script>
            <link rel="stylesheet" href="css/geral.css">
            <link rel="stylesheet" type="text/css" href="css/util.css">
            <link rel="stylesheet" type="text/css" href="css/main.css">
            
            <script src="js/login.js"></script>
            <script src="js/registrar.js"></script>
            <script src="js/usuario.js"></script>
            <script src="js/edicaoObra.js"></script>
            <script src="js/funcoes.js"></script>
    </head>

<div class='container'>
    <header class='row'>
        <div class="col-12">
            <nav id='navbar' class="navbar navbar-expand-md navbar-light bg-light shadow-sm">
                <a class="nav_link col-2" href='index.php'><img src='img/icon-index.png' alt='Logo do site' style='height:50px; width:65px;' data-placement="top" data-toggle="tooltip" title="Voltar a tela inicial"></a>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                        <span class="navbar-toggler-icon"></span>
                    </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- <ul class="navbar-nav mr-auto text-center">
                <li class="nav-item">
                    <a class="nav-link" href="obras.php" data-placement="top" data-toggle="tooltip" title="Exibição dinâmica">Obras</a>
                </li>
                                    
                <li class="nav-item">
                    <a class="nav-link" href="artistas.php" data-placement="top" data-toggle="tooltip" title="Lista dos artistas do Museu">Artistas</a>
                </li>                                     
            </ul> -->

        <ul class="navbar-nav ml-auto">        
            <li class="nav-item dropdown text-center">
                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?php
                        if (isset($_SESSION['controle'])) {
                        $user = $_SESSION['controle'];
                            echo "Olá, $user";
                        } else {
                            echo "Modo Convidado";
                        }
                    ?>
                </a>

                <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="perfil.php" data-placement="top" data-toggle="tooltip" title="Acessar suas informações">Meu Perfil</a>
                    <a class="dropdown-item" href="obras_autor.php" data-placement="top" data-toggle="tooltip" title="Acessar suas obras">Minhas Obras</a>

                    <?php
                        if (isset($_SESSION['controle'])) {
                            echo "<a class='dropdown-item' href='php/sair.php' data-placement='top' data-toggle='tooltip' title='Encerrar sessão'> Sair </a>";
                        }
                    ?>                                            
                </div>                                       
            </li>
        </ul>
    </div>
</nav>