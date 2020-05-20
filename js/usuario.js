function atualizarCadastro(nomeAntigo, emailAntigo)
{
    const loginUser = document.getElementById('perfil_login').value;
    const emailUser = document.getElementById('perfil_email').value;

    const dados = "nome=" + encodeURIComponent(loginUser) + "&email=" + encodeURIComponent(emailUser) + "&nomeAntigo=" + encodeURIComponent(nomeAntigo) + "&emailAntigo=" + encodeURIComponent(emailAntigo);

    if ( nomeAntigo == '' || emailAntigo == '' ) 
    {
        swal(
            {
                title: "Problema ao encontrar cadastro!",
                text: 'Por favor entrar em contato com o administrador do sistema!',
                type: "error",
                button: "OK",
            }
        )
       return;
    };    

    // VALIDA CHARS
    if (char_especial(loginUser)) 
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
    if (valida_espaco(loginUser) || valida_espaco(emailUser)) 
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
    if (loginUser == "") 
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

    if (emailUser == "") 
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
    
    // Valida E-mail
    if (validar_email(emailUser)) 
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
                        text: "Cadastro atualizado com sucesso!",
                        type: "success",
                        button: "OK",
                    });
                break;

            case 'erro':
                swal(
                        {
                            title: "Problema ao atualizar cadastro",
                            text: resposta_descricao,
                            type: "warning",
                            button: "OK",
                        }
                    )
                break;                   

            default:
                swal(
                    {
                        title: "Problema ao atualizar Cadastro!",
                        text: "Por favor entrar em contato com o administrador do sistema!",
                        type: "error",
                        button: "OK",
                    }
                )
           }
       };
   }

   xmlhttp.open("POST", "php/atualizar_usuario.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xmlhttp.send(dados);    
}

function desativarUsuarioPerguntar(nome)
{
    if ( nome == '' ) 
    {
        swal(
            {
                title: "Problema ao encontrar cadastro!",
                text: 'Por favor entrar em contato com o administrador do sistema!',
                type: "error",
                button: "OK",
            }
        )
       return;
    }; 

    swal({
        title: "Desativar seu usuário?",
        text: "Você pode ativar novamente fazendo login",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#DD6B55",
        confirmButtonText: "Sim",
        cancelButtonText: "Não",
        closeOnConfirm: false,
        closeOnCancel: false
        },
        function (isConfirm) 
        {
            if (isConfirm) 
            {
                desativarUsuario(nome,'desativar');
            } 
            else 
            {
              swal({
                  title: "Processo cancelado!",
                  text: "Seu usuário ainda está ativo!",
                  type: "info",
                  button: "OK",
              })
            }
        });
}


function desativarUsuario(nome, tipo)
{
    if ( nome == '' || tipo == '' ) 
    {
        swal(
            {
                title: "Problema ao encontrar cadastro!",
                text: 'Por favor entrar em contato com o administrador do sistema!',
                type: "error",
                button: "OK",
            }
        )
       return;
    }; 

    let okTitle         = '';
    let okText          = '';
    let erroTitle       = '';
    let defaultTitle    = '';

    if (tipo == 'ativar')
    {
        okTitle         = 'Usuário ativado!';
        okText          = 'Suas obras voltaram a ser visualizadas!';
        erroTitle       = 'Problema ao Ativar!';
        defaultTitle    = 'Problema ao ativar Cadastro!'
    }
    else
    {
        okTitle         = 'Usuário desativado!';
        okText          = 'Suas obras não podem mais ser visualizadas! Para ativar sua conta novamante, basta fazer login.';
        erroTitle       = 'Problema ao Inativar!';
        defaultTitle    = 'Problema ao inativar Cadastro!'        
    }


    const dados = "nome=" + encodeURIComponent(nome) + "&acao=" + encodeURIComponent(tipo)

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
                        title: okTitle,
                        text: okText,
                        type: "success",
                        button: "OK",
                    }, function() 
                    {
                        if (tipo == 'ativar')
                        {
                            login();
                        }
                        else
                        {
                            window.open("index.php", '_self');
                        }
                    });
                break;

            case 'erro':
                swal(
                        {
                            title: erroTitle,
                            text: resposta_descricao,
                            type: "warning",
                            button: "OK",
                        }
                    )
                break;                   

            default:
                swal(
                    {
                        title: defaultTitle,
                        text: "Por favor entrar em contato com o administrador do sistema!",
                        type: "error",
                        button: "OK",
                    }
                )
           }
       };
   }

   xmlhttp.open("POST", "php/cadastro_ativar_desativar.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xmlhttp.send(dados);
}



function trocarSenha(nome)
{
    const senhaAtual        = document.getElementById('perfilSenhaAtual').value;
    const senhaNova         = document.getElementById('perfilSenhaNova').value;
    const senhaConfirmar    = document.getElementById('perfilSenhaConfirmar').value;

    const dados = "nome=" + encodeURIComponent(nome) + "&senhaAtual=" + encodeURIComponent(senhaAtual) + "&senhaNova=" + encodeURIComponent(senhaNova) + "&senhaConfirmar=" + encodeURIComponent(senhaConfirmar);
    
    if ( nome == '' ) 
    {
        swal(
            {
                title: "Problema ao encontrar cadastro!",
                text: 'Por favor entrar em contato com o administrador do sistema!',
                type: "error",
                button: "OK",
            }
        )
       return;
    }; 

    if (senhaAtual == "") 
    {
        swal(
            {
                title: "Campo não informado!",
                text: "Por favor preencher a senha atual!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };

    if (senhaNova == "") 
    {
        swal(
            {
                title: "Campo não informado!",
                text: "Por favor preencher a nova senha!",
                type: "warning",
                button: "OK",
            }
        )
        return;
    };
    
    if (senhaConfirmar == "") 
    {
        swal(
            {
                title: "Campo não informado!",
                text: "Por favor preencher a confirmação da senha!",
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
                        text: "Senha atualizada com sucesso!",
                        type: "success",
                        button: "OK",
                    }, function() 
                    {
                        window.open("perfil.php", '_self');
                    })
                break;

            case 'erro':
                swal(
                        {
                            title: "Problema ao atualizar senha",
                            text: resposta_descricao,
                            type: "warning",
                            button: "OK",
                        }
                    )
                break;                   

            default:
                swal(
                    {
                        title: "Problema ao atualizar senha!",
                        text: "Por favor entrar em contato com o administrador do sistema!",
                        type: "error",
                        button: "OK",
                    }
                )
           }
       };
   }

   xmlhttp.open("POST", "php/trocarSenha.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
   xmlhttp.send(dados);
}
