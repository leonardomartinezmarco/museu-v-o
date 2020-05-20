<?php
    session_start();

    if (isset($_SESSION['controle'])) {
      header('Location: Index.php');
    }     
    include('menu.php');
?>

<main>
    <section>   
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100 p-t-10 p-b-70">
                    <form class="login100-form validate-form flex-sb flex-w">
                        <span class="login100-form-title p-b-20">CRIAR USUÁRIO</span>       
                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Username is required">
                            <input id="registrar_login"  class="input100" type="text" name="username" placeholder="Nome">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Username is required">
                            <input id="registrar_email" class="input100" type="text" name="username" placeholder="E-mail">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="wrap-input100 validate-input m-b-8" data-validate = "Username is required">
                            <input id="registrar_senha" class="input100" type="text" name="username" placeholder="Senha">
                            <span class="focus-input100"></span>
                        </div>    
                        <div class="wrap-input100 validate-input m-b-6" data-validate = "Password is required">
                            <input id="registrar_senhaConfirmar" class="input100" type="password" name="pass" placeholder="Confirmar senha">
                            <span class="focus-input100"></span>
                        </div>
                        <small class="form-text font-weight">*Sua senha deve ter no mínimo 6 caracteres</small> 
                        <div class="flex-sb-m w-full p-t-3 p-b-24">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                            </div>
                        </div>
                        <div class="container-login100-form-btn m-t-5">
                            <button type="button" class="login100-form-btn">
                                <input type="button" onclick="registrar()">
                                    <a class="entrar" href="registrar.php">Criar Conta</a>
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
    $(document).ready(function() {
        $(document).keypress(function(e) {
            if(e.wich == 13 || e.keyCode == 13) {
                registrar() }
            })
        })
</script>

<?php include('footer.php');?>
