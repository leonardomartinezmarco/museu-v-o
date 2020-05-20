<?php
include('php' . DIRECTORY_SEPARATOR . 'sessao.php');
    $ID = $_GET['ID'];
    $acao       = '';
    $codigo     = 0;
    $nome       = '';
    $descri     = '';
    $duracao    = 0;
    $repetir    = 0;
    $obra       = 'Escreva sua obra aqui...';
    $status     = '';
    $usuario_id = 0;

if ($ID > 0) {
    $acao='ALTERAR';
    include('php'. DIRECTORY_SEPARATOR . 'conexao.php');
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
} else {
    $acao='INCLUIR';
}

?><?php include('menu.php');?>

<main>
    <section>   
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-70">
                    <form class="login100-form validate-form flex-sb flex-w">
                        <span class="login100-form-title p-b-20">Criar Obra</span>       
                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Username is required">
                            <input id="minhaObra_digitar_nome" class="input100" type="text" name='minhaObra_digitar_nome' placeholder="Nome" oninput='salvarLocal()' value = "<?php echo $nome; ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-10" data-validate = "Username is required">
                            <input id="minhaObra_digitar_desc" class="input100" type="text" name='minhaObra_digitar_desc' placeholder="Descrição da obra" oninput='salvarLocal()'><?php echo rtrim($descri);?>
                            <span class="focus-input100"></span>
                        </div>
                            <label for="minhaObra_digitar_duracao">Duração da obra</label>
                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Username is required">
                            <input name='minhaObra_digitar_duracao' type="range" class="form-control slider" id="minhaObra_digitar_duracao" min="0" max="20" oninput='salvarLocal()' onchange="updateTextInput(this.value);" data-placement="top" data-toggle="tooltip" title="Máximo de 60 segundos" value="<?php echo $duracao; ?>">                   
                        </div> 
                        <span id="minhaObra_digitarTempo">0 Segundos</span>

                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Password is required" id="minhaObra_digitar_obra" oninput='salvarLocal()'>
                            <input class="input100" type="text" name="pass" placeholder="<?php echo rtrim($obra);?>">
                            <span class="focus-input100"></span>
                        </div>         
                        <div class="flex-sb-m w-full p-t-6 p-b-24">    
                            <a class="btn btn-outline-dark botao_obra" data-placement="top" data-toggle="tooltip" title="Negrito" onclick="execCommand('bold',false,'');"><img src="img/bold.png" alt="Negrito" class="imgBotao"> </a>
                            <a class="btn btn-outline-dark botao_obra ml-3" data-placement="top" data-toggle="tooltip" title="Itálico" onclick="execCommand('italic',false,'');"><img src="img/italic.png" alt="Itálico" class="imgBotao"> </a>
                            <a class="btn btn-outline-dark botao_obra ml-3" data-placement="top" data-toggle="tooltip" title="Sublinhado" onclick="execCommand('underline',false,'');"><img src="img/underline.png" alt="Sublinhado" class="imgBotao"> </a>
                            <a class="btn btn-outline-dark botao_obra ml-3" data-placement="top" data-toggle="tooltip" title="Tachado" onclick="execCommand('strikeThrough',false,'');"><img src="img/strikethrough.png" alt="Tachado" class="imgBotao"> </a>
                            <a class="btn btn-outline-dark botao_obra ml-3" data-placement="top" data-toggle="tooltip" title="Aplicar Cor" onclick="pegarCor()"><img src="img/tint.png" alt="Aplicar Cor" class="imgBotao"> </a>
                            <a class="btn btn-outline-dark botao_obra ml-3" data-placement="top" data-toggle="tooltip" title="Centralizar" onclick="execCommand('justifyCenter',false,'');"><img src="img/align-center.png" alt="Centralizar" class="imgBotao"> </a>
                            <input type="color" name="minhaObra_digitar_cor" id="minhaObra_digitar_cor" onchange="trocarCor()" hidden >
                        </div>
                        <div class="container-login100-form-btn m-t-5">
                            <button type="button" class="login100-form-btn">
                                <input type="button" onclick="salvar()">
                                    <a class="entrar" href="registrar.php">Criar Obra</a>
                                </input>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>           
    </section>
</main>

<script>
    document.getElementById("minhaObra_digitar_obra").addEventListener("input", function(){
        salvarLocal();
    }, false);

        carregarDadosSession();
        window.onbeforeunload = function (e) 
    {
        limparDadosSessao();
    };
    
    updateTextInput( <?php echo $duracao;  ?>  );

    function updateTextInput(val) {
        document.getElementById('minhaObra_digitarTempo').innerHTML=val + " Segundos"; 
    }                                  
</script>               

<?php include('footer.php');?>