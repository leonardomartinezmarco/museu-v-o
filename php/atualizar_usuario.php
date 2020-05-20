<?php

$userName		= @$_POST['nome'];
$email 			= @$_POST['email'];
$nomeAntigo		= @$_POST['nomeAntigo'];
$emailAntigo	= @$_POST['emailAntigo'];

if(!isset($userName))
{
    $userName = '';
}

if(!isset($email))
{
    $email = '';
}

if(!isset($nomeAntigo))
{
    $nomeAntigo = '';
}

if(!isset($emailAntigo))
{
    $emailAntigo = '';
}

if ($userName == $nomeAntigo and $email == $emailAntigo)
{
	echo 'ok';
	return;
}


include('funcoes.php');

// Validações de campos

// Campos vazios
if ( $userName == '' or $email == '')
{
	echo "erro-Preencher todos os campos!";
	return;	
}

// Char especial
if ( char_especial($userName) )
{
	echo "erro-Não é permitido o uso de caracteres especiais no Login/Usuário!";
	return;	
}

// Espaço
if ( valida_espaco($userName) or valida_espaco($email) )
{
	echo "erro-Não é permitido o uso espaço! Nem entre ou dentro das palavras!";
	return;	
}

// Validar e-mail
if ( validar_email($email) )
{
	echo "erro-E-mail inválido!";
	return;	
}

include('conexao_bd.php');

// Não pode informar um usuario ou e-mail já utilizado em outro cadastro
if ( $userName !== $nomeAntigo )
{
	$query = " select id from usuarios where nome = ? ";
	$querytratada = $conn->prepare($query); 
	$querytratada->bind_param( "s", $userName );	
	$querytratada->execute();
	$result = $querytratada->get_result();
	
	if( $result->num_rows > 0 )
	{
		echo "erro-Usuário ou e-mail já utilizados em outro cadastro!";
		return;
	}
}

if ( $email !== $emailAntigo )
{
	$query = " select id from usuarios where email = ? ";
	$querytratada = $conn->prepare($query); 
	$querytratada->bind_param( "s", $email );	
	$querytratada->execute();
	$result = $querytratada->get_result();
	
	if( $result->num_rows > 0 )
	{
		echo "erro-Usuário ou e-mail já utilizados em outro cadastro!";
		return;
	}
}

$query = " UPDATE usuarios SET nome = ? ,email = ? where nome = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "sss", $userName, $email, $nomeAntigo );

$querytratada->execute();

//var_dump($conn->info);
// [info] => Rows matched: 1  Changed: 1  Warnings: 0

preg_match_all ('/(\S[^:]+): (\d+)/', $conn->info, $querytratada);
$info = array_combine ($querytratada[1], $querytratada[2]);	

// Linhas encontradas com base na condição da where
$linhas_encontradas = $info['Rows matched'];

// Linhas que foram alteradas, quando os dados não forem alterados, mesmo o comando estando certo, não é retornado linhas afetadas
$linhas_afetadas = $info['Changed'];

// Avisos de problemas
$avisos_problemas = $info['Warnings'];

if ($linhas_encontradas == '1' and $avisos_problemas == '0')
{
	$resposta = 'ok';
	session_start();
	$_SESSION['controle'] = ucwords($userName);
} 
else 
{
	$resposta = 'erro-Problema ao atualizar cadastro!';
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;

?>