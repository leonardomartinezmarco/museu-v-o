<?php
    include('php/sessao.php');
    include('menu.php');
    include('PHP'. DIRECTORY_SEPARATOR . 'conexao.php');

    $query = "select email from usuarios where nome = ?";
    $querytratada = $conn->prepare($query); 
    $nome = $_SESSION['controle'];
    $querytratada->bind_param("s",$nome);
    $querytratada->execute();
    $result = $querytratada->get_result();
    $row = $result->fetch_assoc();
    $email = $row["email"];
?>           
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-150">
                    <form class="login100-form validate-form flex-sb flex-w">
                        <span class="login100-form-title p-b-20">Perfil</span>       
                        <div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
                            <input id="perfil_login" class="input100" type="text" name="username" placeholder="Usuário" value="<?php echo $nome; ?>">
                            <span class="focus-input100"></span>
                        </div>  
                        <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
                            <input id="perfil_email" class="input100" type="text" name="pass" placeholder="Senha" value="<?php echo $email; ?>">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="d-flex justify-content-center">
                                <a class='btn btn-secondary MousePoiter text-white mt-3' data-toggle="modal" data-target="#myModal" data-placement="top" data-type="tooltip" title="Trocar senha">Trocar senha</a>
                                <input type="button" value="Salvar alterações" onclick="atualizarCadastro('<?php echo $nome; ?>', '<?php echo $email; ?>')" class="btn btn-dark mt-3 ml-2" data-placement="top" data-toggle="tooltip" title="Atualizar Cadastro" >
                                <input type="button" value="Excluir cadastro" onclick="desativarUsuarioPerguntar('<?php echo $nome; ?>')" class="btn btn-secondary mt-3 ml-2" data-placement="top" data-toggle="tooltip" title="Para ativar novamente, basta fazer login novamente." >
                            </div>
                        </div>       
                    </form>
                </div>
            </div>
        </div>           

<!-- Modal - Resetar Senha -->

<div id="myModal" class="modal" role="dialog" style="margin-top: 5%;">
    <div class="modal-dialog">
        <div class="modal-content">                     
            <div class="modal-header d-flex justify-content-center">
                <span class="modal-title font-weight-bold">Redefinição da sua senha</span>
            </div>
            
            <div class="modal-body form-group">
                <div class="col-12">
                    <input type="password" id='perfilSenhaAtual' class='form-control' placeholder="Senha atual" data-placement="top" data-toggle="tooltip" title="Senha atual" >  
            </div>
            
            <div class="col-12 mt-3">
                <input type="password" id='perfilSenhaNova' class='form-control' maxlength="20" placeholder="Nova Senha" data-placement="top" data-toggle="tooltip" title="Nova Senha" >
            </div>
        
        <div class="col-12 mt-3">
            <input type="password" id='perfilSenhaConfirmar' class='form-control' maxlength="20" placeholder="Confirmar Senha" data-placement="top" data-toggle="tooltip" title="Confirmar Senha" >
                <small><p>*A senha deve ter no mínimo 6 caracteres</p></small>
        </div>
        
        <div class="col-12 mt-2 text-center">
            <input type="button" value="Salvar" class="btn btn-primary form-control" onclick="trocarSenha('<?php echo $nome; ?>')" data-placement="top" data-toggle="tooltip" title="Trocar senha">
        </div>

        </div>
            <div class="modal-footer d-flex justify-content-center">
                <input type="button" value="Fechar" class="btn btn-secondary" data-dismiss="modal" data-placement="top" data-toggle="tooltip" title="Cancelar procedimento de troca de senha">
            </div>
        </div>
    </div>
</div>                         

<?php include('footer.php');?>
