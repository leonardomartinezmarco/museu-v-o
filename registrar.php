<?php
    session_start();
    // Se já iniciou sessão, não precisa logar novamente
    if (isset($_SESSION['controle'])) 
    {
      header('Location: Index.php');
    }     
    include('menu.php');
?>

                <h1 class="text-center mt-3">Criar acesso</h1>
            </div>
        </header>

        <main>
            <section>

                <div class='form-group mt-3 col-12'>
                    <header>
                        <h2>Digite suas informações</h2>
                    </header>

                    <input type="text" id="registrar_login" class="form-control mt-3" placeholder="Novo Usuário" maxlength="20" data-placement="top" data-toggle="tooltip" title="Digite o novo usuário">  
                    
                    <input type="email" id="registrar_email" class="form-control mt-3" placeholder="nome@server.com.br" maxlength="200" data-placement="top" data-toggle="tooltip" title="Digite seu e-mail">

                    <input type="password" id="registrar_senha" class="form-control mt-3" placeholder="Nova Senha" maxlength="200" data-placement="top" data-toggle="tooltip" title="Defina uma senha">                        
                    <input type="password" id="registrar_senhaConfirmar" class="form-control mt-3" placeholder="Confirmar Senha" maxlength="200" data-placement="top" data-toggle="tooltip" title="Digite novamente a senha">
                    <small class="form-text font-weight-bold" >Senha deve ter no mínimo 6 caracteres</small> 
                    
                    <input type="button" value="Efetuar Cadastro" onclick="registrar()" class="btn btn-dark btn-lg mt-3" data-placement="top" data-toggle="tooltip" title="Criar novo cadastro" >
                </div>

            </section>
        </main>

        <script>

        // Executa o login ao pressionar a tecla enter 
        $(document).ready(function()
        {
            $(document).keypress(function(e)
            {
                if(e.wich == 13 || e.keyCode == 13)
                {
                    registrar()
	            }
            })
        })

        </script>

        <?php
            include('footer.php');
        ?>
    </div>
</body>

</html>