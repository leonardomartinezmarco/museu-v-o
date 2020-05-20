<?php

$userName		= @$_POST['userName'];
$senha			= @$_POST['senha'];
$senhaConfirmar	= @$_POST['senhaConfirmar'];
$email 			= @$_POST['email'];

if(!isset($userName))
{
    $userName = '';
}

if(!isset($senha))
{
    $senha = '';
}

if(!isset($senhaConfirmar))
{
    $senhaConfirmar = '';
}

if(!isset($email))
{
    $email = '';
}

include('funcoes.php');

// Validações de campos

// Campos vazios
if ( $userName == '' or $senha == '' or $senhaConfirmar == '' or $email == '')
{
	echo "erro-Preencher todos os campos!";
	return;	
}

// Tamanho mínimo da senha
if ( strlen($senha) < 6 )
{
	echo "erro-Tamanho mínimo da senha é de 6 caracteres!";
	return;
}

// Char especial
if ( char_especial($userName) )
{
	echo "erro-Não é permitido o uso de caracteres especiais no Login/Usuário!";
	return;	
}

// Espaço
if ( valida_espaco($userName) or valida_espaco($senha) or valida_espaco($senhaConfirmar) or valida_espaco($email) )
{
	echo "erro-Não é permitido o uso espaço! Nem entre ou dentro das palavras!";
	return;	
}

// Senhas iguais
if ($senha !== $senhaConfirmar) 
{
	echo "erro-Senhas digitadas têm que ser iguais!";
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
$query = " select id from usuarios where nome = ? or email = ? ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param( "ss", $userName, $email );	
$querytratada->execute();
$result = $querytratada->get_result();

if( $result->num_rows > 0 )
{
	echo "erro-Usuário ou e-mail já cadastrados!";
	return;
}

// criptografia da senha com chave
$senha = md5($senha . "Mutato Muzika");
$codigo = 0;
$ativo = 'ativo';

// INSERIR NOVO USUARIO
$query = " INSERT INTO usuarios ( id, nome, email, senha, ativo ) Values ( ?, ?, ?, ?, ? ) ";
$querytratada = $conn->prepare($query); 
$querytratada->bind_param("issss", $codigo, $userName, $email, $senha, $ativo);
$querytratada->execute();

if ($querytratada->affected_rows > 0) 
{
	$resposta = 'ok';
	session_start();
	$_SESSION['controle'] = ucwords($userName);	
} 
else 
{
	echo 'problema';
	return;
}

// FECHA CONEXAO
mysqli_close($conn);

// RETORNA RESULTADO
echo $resposta;
return;

?>