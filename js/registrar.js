function registrar()
{
    if (!sessionStorage_verif())
    {
        return false;
    }    
    
    const userName          = document.getElementById('registrar_login').value;
    const email             = document.getElementById('registrar_email').value;
    const senha             = document.getElementById('registrar_senha').value;
    const senhaConfirmar    = document.getElementById('registrar_senhaConfirmar').value;

    const dados = "userName=" + encodeURIComponent(userName) + "&senha=" + encodeURIComponent(senha) + "&senhaConfirmar=" + encodeURIComponent(senhaConfirmar) + "&email=" + email;

    // Tamanho mínimo da senha
    if (senha.length < 6 || senhaConfirmar.length < 6 ) 
    {
        swal(
            {
                title: "Senha inválida!",
                text: 'Tamanho mínimo da senha é de 6 caracteres!',
                type: "warning",
                button: "OK",
            }
        )
       return;
    };

    // VALIDA CHARS
    if (char_especial(userName)) 
    {
        swal(
            {
                title: "Caracter(es) inválido(s)!",
                text: 'Não é permitido o uso de caracteres especiais no Login/Usuário! Exceto " _ "',
                type: "warning",
                button: "OK",
            }
        )
       return;
    };
    
    // VALIDA SE TEM ESPAÇO
    if (valida_espaco(userName) || valida_espaco(senha) || valida_espaco(senhaConfirmar) || valida_espaco(email)) 
    {
        swal(
            {
                title: "Espaço não é permitido!",
                text: 'Não é permitido o uso espaço! Nem entre ou dentro das palavras!',
                type: "warning",
                button: "OK",
            }
        )
        return;
    };
    
    // VERIFICA SE CAMPOS FORAM PREENCHIDOS
    if (userName == "") 
    {
        swal(
            {
                title: "Login não informado!",
                text: "Por favor preencher o login!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };

    if (email == "") 
    {
        swal(
            {
                title: "E-mail não informado!",
                text: "Por favor preencher o e-mail!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };    

    if (senha == "" || senhaConfirmar == "") 
    {
        swal(
            {
                title: "Campos de senha não preenchidos!",
                text: "Por favor preencher ambos campos da senha!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };

    // VERIFICAR SENHAS DIGITAS
    if (senha != senhaConfirmar) 
    {
        swal(
            {
                title: "Senhas não conferem!",
                text: "Senhas digitadas têm que ser iguais!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };

    // Valida E-mail
    if (validar_email(email)) 
    {
        swal(
            {
                title: "E-mail inválido!",
                text: "Verifique o e-mail digitado!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };

   // AJAX
   var xmlhttp = new XMLHttpRequest();
   xmlhttp.onreadystatechange = function () 
   {
       if (this.readyState == 4 && this.status == 200) 
       {
           var resposta = this.responseText;

           // Tirando ENTER
           resposta = resposta.replace(/(\r\n|\n|\r)/gm, "");

           resposta_codigo      = resposta.substr(0,4);
           resposta_descricao   = resposta.substr(5);

           switch (resposta_codigo) 
           {
            case 'ok':
                swal(
                    {
                        title: "Tudo Certo!",
                        text: "Cadastro efetuado com sucesso!",
                        type: "success",
                        button: "OK",
                    }, function() 
                    {
                        window.open("perfil.php", '_self');
                    });
                break;

            case 'erro':
                swal(
                        {
                            title: "Problema ao registrar",
                            text: resposta_descricao,
                            type: "warning",
                            button: "OK",
                        }
                    )
                break;                   

            default:
                swal(
                    {
                        title: "Problema ao efetuar Cadastro!",
                        text: "Por favor entrar em contato com o administrador do sistema!",
                        type: "error",
                        button: "OK",
                    }
                )
           }
       };
   }

   xmlhttp.open("POST", "php/criar_usuario.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xmlhttp.send(dados);

}