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
                <div class="wrap-login100 p-t-10 p-b-150">
                    <form class="login100-form validate-form flex-sb flex-w">
                        <span class="login100-form-title p-b-20">Login</span>       
                        <div class="wrap-input100 validate-input m-b-16" data-validate = "Username is required">
                            <input id="login_user" class="input100" type="text" name="username" placeholder="Usuário">
                            <span class="focus-input100"></span>
                        </div>  
                        <div class="wrap-input100 validate-input m-b-16" data-validate = "Password is required">
                            <input id="login_senha" class="input100" type="password" name="pass" placeholder="Senha">
                            <span class="focus-input100"></span>
                        </div>
                        <div class="flex-sb-m w-full p-t-3 p-b-24">
                            <div class="contact100-form-checkbox">
                                <input class="input-checkbox100" id="ckb1" type="checkbox" name="remember-me">
                                <a href="registrar.php" class="txt1">
                                    Registrar-se
                                </a>
                            </div>
                            <div>
                            <a href="#" class="txt1">
                                    Esqueceu sua senha?
                            </a>
                            </div>
                        </div>
                        <div class="container-login100-form-btn m-t-17">
                            <button type="button" class="login100-form-btn">
                                <input type="button" onclick="login()">
                                    <a class="entrar" href="registrar.php">Entrar</a>
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
                login();
	        }
        })
    })
</script>

<?php include('footer.php');?>