<?php

/* obtendo o conteudo do body */
$json =  file_get_contents('php://input');

/* convertendo o body em formato json em objeto php*/
$dadosObra = json_decode ($json);

$codigo         = $dadosObra->idObra;
$nomeObra       = $dadosObra->nomeObra;
$descObra       = $dadosObra->descObra;
$duracaoObra    = $dadosObra->duracaoObra;
$loopObra       = $dadosObra->loopObra;
$statusObra     = $dadosObra->statusObra;
$textoObra      = $dadosObra->textoObra;

if(!isset($codigo))
{
    $codigo = 0;
}

if(!isset($nomeObra))
{
    $nomeObra = '';
}

if(!isset($descObra))
{
    $descObra = '';
}

if(!isset($duracaoObra))
{
    $duracaoObra = 0;
}

if(!isset($loopObra))
{
    $loopObra = 0;
}

if(!isset($statusObra))
{
    $statusObra = '';
}

if(!isset($textoObra))
{
    $textoObra = '';
}

// Campos vazios
if ( $nomeObra == '' or $descObra == '' or $textoObra == '')
{
	echo "erro-Preencher os campos obrigatórios!";
	return;	
}

include('conexao_bd.php');

if ($loopObra == true)
{
    $loopObra = 1;
}
else
{
    $loopObra = 0; 
}

session_start();
if ( isset($_SESSION['controle']) ) 
{
    $login = $_SESSION['controle'];
    
    $query = " select id from usuarios where nome = ?";
    $querytratada = $conn->prepare($query); 
    $querytratada->bind_param( "s", $login );
    $querytratada->execute();
    $result = $querytratada->get_result();
    
    if( $result->num_rows > 0 )
    {
        $row = $result->fetch_assoc();
        $usuario_id = $row["id"];
    }
    else
    {
        echo "erro-Problema ao encontrar usuário para salvar obra!";
    }
} 
else
{
    echo "erro-Problema ao encontrar usuário para salvar obra!";
}

$existe = false;

// VERIFICA SE JÁ EXISTE
$query = "select id from obras where id = ?";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param("i",$codigo);
$querytratada->execute();
$result = $querytratada->get_result();

if( $result->num_rows > 0)
{
	$existe = true;
}

if ($existe == true)
{
	// Prevenção de injection
	$query = "	UPDATE 
					obras 
				SET 
                    nome        = ?
                    ,descri		= ?
					,duracao	= ? 
					,repetir    = ?
					,obra		= ?
					,ativo	    = ?
				where 
					id = ?	";	
	$querytratada = $conn->prepare($query); 
	$querytratada->bind_param("ssiissi", $nomeObra, $descObra, $duracaoObra, $loopObra, $textoObra, $statusObra, $codigo);

	$querytratada->execute();
	
    preg_match_all ('/(\S[^:]+): (\d+)/', $conn->info, $querytratada);
	$info = array_combine ($querytratada[1], $querytratada[2]);	
	
	// Linhas encontradas com base na condição da where
	$linhas_encontradas = $info['Rows matched'];

	// Linhas que foram alteradas, quando os dados não forem alterados, mesmo o comando estando certo, não é retornado linhas afetadas
	$linhas_afetadas = $info['Changed'];

	// Avisos de problemas
	$avisos_problemas = $info['Warnings'];
	
	//if ($querytratada->affected_rows > 0) 
	if ($linhas_encontradas == '1' and $avisos_problemas == '0')
	{
		$resposta = 'ok';
	} 
	else 
	{
		$resposta = 'problema';
	}
}
else
{
    $codigo = 0;
    //$statusObra = 'ativo';
        
    $query = " INSERT INTO obras ( id, nome, descri, duracao, repetir, obra, ativo, usuario_id ) Values ( ?, ?, ?, ?, ?, ?, ?, ? ) ";
    $querytratada = $conn->prepare($query); 
    $querytratada->bind_param("issiissi", $codigo, $nomeObra, $descObra, $duracaoObra, $loopObra, $textoObra, $statusObra, $usuario_id );
    $querytratada->execute();
    
    if ($querytratada->affected_rows > 0) 
    {
        $resposta = 'ok';
    } 
    else 
    {
        $resposta = 'problema';
    }
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;

?>