<?php
include('php' . DIRECTORY_SEPARATOR . 'sessao.php');
$ID = $_GET['ID'];

$acao       = '';

$codigo     = 0;
$nome       = '';
$descri     = '';
$duracao    = 0;
$repetir    = 0;
$obra       = 'Mãos a obra!';
$status     = '';
$usuario_id = 0;

if($ID > 0)
{
    $acao='ALTERAR';

    include('php'. DIRECTORY_SEPARATOR . 'conexao_bd.php');

    $query = "select * from obras where id = ?";
    $querytratada = $conn->prepare($query); 
    $querytratada->bind_param("i",$ID);
    $querytratada->execute();
    $result = $querytratada->get_result();

    $row = $result->fetch_assoc();

    $codigo  = $row["id"];
    $nome    = $row["nome"];
    $descri  = $row["descri"];
    $duracao = $row["duracao"];
    $repetir = $row["repetir"];
    $obra    = $row["obra"];
    $status  = $row["ativo"];
}
else
{
    $acao='INCLUIR';
}

?>  

<!DOCTYPE html>
<html lang="pt-br" manifest="offline.appcache">
<head>
        <title>Museu</title>
        <meta charset="utf-8">

        <link href="Imagens/icon.png" rel="icon">

        <!-- Bootstrap -->
        <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="css/bootstrap.min.css">

        <!-- <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script> -->
        <script src="js/jquery-3.3.1.slim.min.js"></script>
        <script src="js/popper.min.js"></script>
        <script src="js/bootstrap.min.js"></script>

        <!-- Manual de uso referente aos alerts customizados "swal": https://sweetalert.js.org/guides/ -->
        <!-- <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script> -->
        <script src="js/sweetalert.min.js"></script>
        <link rel="stylesheet" href="css/sweetalert.css">
        
        <!-- JQUERY -->
        <!-- <script src="https://code.jquery.com/jquery-3.3.1.js"></script> -->
        <script src="js/jquery-3.3.1.js"></script>

        <!-- Biblioteca de ícones -->
        <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">   -->

        <!-- CSS -->
        <link rel="stylesheet" href="css/geral.css">

        <!-- JavaScript -->
        <script src="js/edicaoObra.js"></script>
    </head>

    <body onload="salvarLocal()">
        <div class='container'>
            <header class='row'>
                <div class="col-12">

                    <nav id='navbar' class="navbar navbar-expand-md navbar-light bg-light shadow-sm">

                            <a class="nav_link col-2" href='index.php'><img src='Imagens/icon.png' alt='Logo do site' style='height:100px; width:100px;' data-placement="top" data-toggle="tooltip" title="Voltar a tela inicial"></a>
                      
                            <a class="navbar-brand" href="index.php" data-placement="top" data-toggle="tooltip" title="Voltar a tela inicial">
                                Home
                            </a>
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                               
                                <!-- Left Side Of Navbar -->
                                <ul class="navbar-nav mr-auto text-center">
                                    <li class="nav-item">
                                        <a class="nav-link" href="apresentacao_obras.php" data-placement="top" data-toggle="tooltip" title="Exibição dinâmica">Apresentação das obras</a>
                                    </li>
                                    
                                    <li class="nav-item">
                                        <a class="nav-link" href="#" data-placement="top" data-toggle="tooltip" title="Lista dos artistas do Museu">Artistas</a>
                                    </li>                                     
                                </ul>

                                <!-- Right Side Of Navbar -->
                                <ul class="navbar-nav ml-auto">
                                    <!-- Authentication Links -->
                                    <!-- Exemplo de 1 item, sem subOpção
                                    <li class="nav-item">
                                            <a class="nav-link" href="#">Home</a>
                                    </li>-->
                                    
                                    <li class="nav-item dropdown text-center">
                                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                            <?php
                                                if (isset($_SESSION['controle']))
                                                {
                                                    $user = $_SESSION['controle'];
                                                    echo "Bem vindo! $user";
                                                }
                                                else
                                                {
                                                    echo " Convidado ";
                                                }
                                            ?>
                                        </a>

                                        <div class="dropdown-menu dropdown-menu-right text-center" aria-labelledby="navbarDropdown">
                                            <a class="dropdown-item" href="perfil.php" data-placement="top" data-toggle="tooltip" title="Acessar suas informações">
                                                Perfil
                                            </a>
                                            <a class="dropdown-item" href="minhasObras.php" data-placement="top" data-toggle="tooltip" title="Acessar suas obras">
                                                Minhas Obras
                                            </a>

                                            <?php
                                                if (isset($_SESSION['controle']))
                                                {
                                                    echo "<a class='dropdown-item' href='php/sair.php' data-placement='top' data-toggle='tooltip' title='Encerrar sessão'> Sair </a>";
                                                }
                                            ?>                                            
                                        </div>                                       
                                    </li>
                                </ul>
                            </div>
                    </nav>

                    <h1 id='titulo' class="text-center H1_titulo mt-3">Obra</h1>
                </div> 
            </header>

            <main>
                <section class='row'>

                    <div class='col-12'>

                    <div class='text-center col-12 mt-4'>
                        <h2 class=''> <?php echo $acao; ?> </h2>
                    </div>                      

                        <form>

                            <div class="form-group col-12">
                                
                                <span id='minhaObra_digitar_id' hidden><?php echo $codigo; ?></span>
                                
                                <div class='mt-3 row'>
                                    <label for="minhaObra_digitar_nome">Nome*</label>
                                    <input name='minhaObra_digitar_nome' type="text" class="form-control" id="minhaObra_digitar_nome" maxlength="150" oninput='salvarLocal()' autofocus placeholder="Nome da obra" data-placement="top" data-toggle="tooltip" title="Digite o nome da sua obra" value = "<?php echo $nome; ?>">
                                </div>

                                <div class="form-group row mt-3">
                                    <label for="minhaObra_digitar_desc">Descrição*</label>
                                    <textarea name='minhaObra_digitar_desc' class="form-control desc_fixo" id="minhaObra_digitar_desc" rows="5" oninput='salvarLocal()' maxlength="800" placeholder = 'Descrição Obra' data-placement="top" data-toggle="tooltip" title="Digite uma descrição para sua obra"><?php echo rtrim($descri); ?></textarea>
                                </div>

                                <div class='mt-3 row'>
                                    <label for="minhaObra_digitar_duracao">Duração da obra</label>
                                    <input name='minhaObra_digitar_duracao' type="range" class="form-control slider" id="minhaObra_digitar_duracao" min="0" max="20" oninput='salvarLocal()' onchange="updateTextInput(this.value);" data-placement="top" data-toggle="tooltip" title="Máximo de 60 segundos" value="<?php echo $duracao; ?>">
                                    <span id="minhaObra_digitarTempo">0 Segundos</span>
                                </div>

                                <div class="form-check row mt-3">
                                    <input class="form-check-input" type="checkbox" value="" id="minhaObra_digitar_loop" name="minhaObra_digitar_loop" onchange="salvarLocal()" data-placement="top" data-toggle="tooltip" title="Exibir a apresentação repetidamente">
                                    <label class="form-check-label" for="minhaObra_digitar_loop" data-placement="top" data-toggle="tooltip" title="Exibir a apresentação repetidamente"> Exibir em loop </label>
                                </div>        
                                
                                <div class='form-group row mt-3'>
                                    <label for="minhaObra_digitar_status">Status:</label>
                                    <select id='minhaObra_digitar_status' name="minhaObra_digitar_status" class="form-control ativo_select" onchange="salvarLocal()" data-placement="top" data-toggle="tooltip" title="Se estiver inativo, Não será exibido para os leitores">
                                        <option value="ativo" selected>Ativo</option>
                                        <option value="inativo">Inativo</option>
                                    </select>
                                </div>

                                <div class="row mt-5">
                                    <h3>Crie sua obra!</h3>
                                </div>
                                
                                <div class="row mt-1">
                                    <span>Você está trabalhando offline, sua obra está salva na sessão atual. Para salvar no servidor, clique em Gravar.</span>
                                </div>                                 

                                <div class='mt-5 row d-flex justify-content-center'>        
                                    <a class="btn btn-outline-dark botao_obra"       data-placement="top" data-toggle="tooltip" title="Negrito"          onclick="execCommand('bold',false,'');">            <img src="Imagens/bold.png" alt="Negrito" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Itálico"          onclick="execCommand('italic',false,'');">          <img src="Imagens/italic.png" alt="Itálico" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Sublinhado"       onclick="execCommand('underline',false,'');">       <img src="Imagens/underline.png" alt="Sublinhado" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Tachado"          onclick="execCommand('strikeThrough',false,'');">   <img src="Imagens/strikethrough.png" alt="Tachado" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Aplicar Cor"      onclick="pegarCor()">                               <img src="Imagens/tint.png" alt="Aplicar Cor" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Centralizar"      onclick="execCommand('justifyCenter',false,'');">   <img src="Imagens/align-center.png" alt="Centralizar" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Alinhar esquerda" onclick="execCommand('justifyLeft',false,'');">     <img src="Imagens/align-left.png" alt="Alinhar esquerda" class="imgBotao"> </a>
                                    <a class="btn btn-outline-dark botao_obra ml-3"  data-placement="top" data-toggle="tooltip" title="Alinhar direita"  onclick="execCommand('justifyRight',false,'');">    <img src="Imagens/align-right.png" alt="Alinhar direita" class="imgBotao"> </a>
                                    <input type="color" name="minhaObra_digitar_cor" id="minhaObra_digitar_cor" onchange="trocarCor()" hidden >
                                </div>

                                <div class="mt-3">
                                    <div class="border border-secondary" id="minhaObra_digitar_obra" contenteditable oninput='salvarLocal()'>
                                        <?php echo rtrim($obra); ?>
                                    </div>
                                </div>                          
                            </div>
                            
                            <div class="form-group row obra d-flex justify-content-center">
                                <input type="button" class="btn btn-dark btn-lg ml-3"      Value='Gravar'   onclick="salvar()"   data-placement="top" data-toggle="tooltip" title="Salvar informações">
                                <input type="button" class="btn btn-secondary btn-lg ml-3" Value='Cancelar' onclick="cancelar()" data-placement="top" data-toggle="tooltip" title="As informações não serão salvas!">
                            </div>
                        </form>
                    </div>
                </section>
            </main>

            <script>
               
                document.getElementById("minhaObra_digitar_obra").addEventListener("input", function() 
                {
                    salvarLocal();
                }, false);

                carregarDadosSession();

                window.onbeforeunload = function (e) 
                {
                   limparDadosSessao();
                };

                updateTextInput( <?php echo $duracao;  ?>  );

                function updateTextInput(val) 
                {
                    document.getElementById('minhaObra_digitarTempo').innerHTML=val + " Segundos"; 
                }      
                             
            </script>               

        <?php
            include('footer.php');
        ?>
        </div>
    </body>
</html>