function pegarCor() 
{
    const cor = document.getElementById('minhaObra_digitar_cor');
    cor.focus();
    cor.click();
}

function trocarCor() 
{
    document.execCommand("foreColor", false, document.getElementById('minhaObra_digitar_cor').value);    
}

// Carrega dados da session
function carregarDadosSession() 
{
    const dadosCarregar = sessionStorage.getItem("obra_dados");

    if (dadosCarregar == null)
    {
        return false;
    }

    if (! dadosCarregar.length == 0)
    {
        const dados = JSON.parse( sessionStorage.getItem("obra_dados") );
        
        document.getElementById('minhaObra_digitar_id').innerHTML   = dados['idObra'];
        document.getElementById('minhaObra_digitar_nome').value     = dados['nomeObra'];
        document.getElementById('minhaObra_digitar_desc').value     = dados['descObra'];
        document.getElementById('minhaObra_digitar_duracao').value  = dados['duracaoObra'];
        document.getElementById('minhaObra_digitar_loop').checked  = dados['loopObra'];
        document.getElementById('minhaObra_digitar_status').value   = dados['statusObra'];
        document.getElementById('minhaObra_digitar_obra').innerHTML = dados['textoObra'];
    }
}

// Salvar na session
function salvarLocal() 
{
    const dados = new Object ();
    
    dados.idObra        = document.getElementById('minhaObra_digitar_id').innerHTML;
    dados.nomeObra      = document.getElementById('minhaObra_digitar_nome').value;
    dados.descObra      = document.getElementById('minhaObra_digitar_desc').value;
    dados.duracaoObra   = document.getElementById('minhaObra_digitar_duracao').value;
    dados.loopObra      = document.getElementById('minhaObra_digitar_loop').checked;
    dados.statusObra    = document.getElementById('minhaObra_digitar_status').value;
    dados.textoObra     = document.getElementById('minhaObra_digitar_obra').innerHTML;

    sessionStorage.setItem("obra_dados", JSON.stringify(dados));
}



// Salvar no banco de dados
function salvar() 
{
    salvarLocal();

    const dadosSalvar = sessionStorage.getItem("obra_dados");

    if (dadosSalvar == null)
    {
        swal(
            {
                title: "Informações não preenchidas!",
                text: 'Por favor preencher os campos da obra',
                type: "info",
                button: "OK",
            }
        )
        return false;
    }    

     // Validar dados no php e retonar com erro-Mensagem

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
                        text: "Obra inclusa/atualizada com sucesso!",
                        type: "success",
                        button: "OK",
                    }, function() 
                    {
                        limparDadosSessao();
                        window.open("minhasObras.php", '_self');
                    });
                break;

            case 'erro':
                swal(
                        {
                            title: "Não foi possivel incluir/atualizar a Obra!",
                            text: resposta_descricao,
                            type: "warning",
                            button: "OK",
                        }
                    )
                break;                   

            default:
                swal(
                    {
                        title: "Problema ao incluir/atualizar a Obra!",
                        text: "Por favor entrar em contato com o administrador do sistema!",
                        type: "error",
                        button: "OK",
                    }
                )
           }
       };
   }

   xmlhttp.open("POST", "php/criar_obra.php", true);
   xmlhttp.setRequestHeader("Content-type", "application/json");
   xmlhttp.send(dadosSalvar);
}

function desativar(ID_para_desativar) 
{
    var desativar = "codigo=" + encodeURIComponent(ID_para_desativar);

   // AJAX
    var xmlhttp = new XMLHttpRequest();
    xmlhttp.onreadystatechange = function()
    {
        if (this.readyState == 4 && this.status == 200) 
        {
            
            var resposta = this.responseText;
            
            // Tirando ENTER
            resposta = resposta.replace(/(\r\n|\n|\r)/gm, "");
            
            switch (resposta)
			{
				case 'ativo':
                    swal(
                        {
                            title:  "Obra foi Ativada!",
                            text:   'Obra pode ser visualizada por todos!',
                            type:   "success",
                            button: "OK",
                        }
                    );
                break;

                case 'inativo':
                    swal(
                        {
                            title:  "Obra foi Inativada!",
                            text:   'Obra não pode mais ser visualizada por todos!',
                            type:   "success",
                            button: "OK",
                        }
                    );                 
                break;
					
				 default:
                    swal(
                        {
                            title:  "Problemas ao inativar ou ativar!",
                            text:   "Por favor entrar em contato com o administrador do sistema!",
                            type:   "error",
                            button: "OK",
                        }
                    )                    
			}
            
            // Ajax com Jquery e está refazendo apenas a tabela 
            $.post('php/consulta_minhas_obras.php',desativar, function(data)
            {
                $('#table_consulta_minhas_obras').html(data);
            }
        )  		
			
        }      
    }
    // MODO POST
    xmlhttp.open("POST", "php/desativar.php",true);
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");  
    xmlhttp.send(desativar);
}

function filtrarMinhasObras() 
{  ;
    const filtro_nome    = document.getElementById("minhas_obras_filtro_nome").value;
    const filtro_desc    = document.getElementById("minhas_obras_filtro_desc").value;
    const filtro_status   = document.getElementById("minhas_obras_filtro_status").value;

    var parametros = "filtro_nome=" + encodeURIComponent(filtro_nome) + "&filtro_desc=" + encodeURIComponent(filtro_desc) + "&filtro_status=" + encodeURIComponent(filtro_status);
    
    // Ajax com Jquery e está refazendo apenas a tabela 
    $.post('php/consulta_minhas_obras.php',parametros, function(data)
        {
            $('#table_consulta_minhas_obras').html(data);
        }
    )
}


function cancelar() 
{
    limparDadosSessao();
    window.open("minhasObras.php", '_self');
}

function limparDadosSessao() 
{
    sessionStorage.clear();
    sessionStorage.setItem("obra_dados", '');
}