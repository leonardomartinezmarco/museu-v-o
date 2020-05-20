<?php
    include('..' . DIRECTORY_SEPARATOR . 'PHP' . DIRECTORY_SEPARATOR . 'sessao.php');
	
	$filtro_nome = @$_POST['filtro_nome'];

	if (!isset($filtro_nome))
	{
		$filtro_nome = '';
	}

	$filtro_desc = @$_POST['filtro_desc'];

	if (!isset($filtro_desc))
	{
		$filtro_desc = '';
	}

	$filtro_status = @$_POST['filtro_status'];

	if (!isset($filtro_status))
	{
		$filtro_status = '';
	}

	
	// Montando where
	$where = '';

    if(!$filtro_nome == '')
    {
        $where = $where . " and nome like '%$filtro_nome%' ";
	} 
	
    if(!$filtro_desc == '')
    {
        $where = $where . " and descri like '%$filtro_desc%' ";
    } 	

   switch ($filtro_status)
   {
        case 'Ativos':
            $where = $where . " and ativo ='Ativo' ";
        break;

        case 'Inativos':
            $where = $where . " and ativo ='Inativo' ";
        break;
   }

   include('..' . DIRECTORY_SEPARATOR . 'php' . DIRECTORY_SEPARATOR . 'conexao.php');

   //session_start();
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
		   $where = $where . " and usuario_id = $usuario_id ";
	   }
	   else
	   {
		   echo "erro-Problema ao encontrar usuários!";
	   }
   } 
   else
   {
		echo "erro-Problema ao encontrar usuários!";
   }

   // Tirando 1º and, é sempre colocado um and, pois não sabemos quais filtros serão utilizados
   if(!$where == '')
   {
        $where = " Where " . substr($where,5);;
   } 
	
	$query = "select * from obras $where order by id desc";
	$result = $conn->query($query);
		
	echo "<div id='table_consulta_minhas_obras' class='container'>";
	echo "<div class='row-fluid'>";
	
		echo "<div class='col-xs-6'>";
		echo "<div class='table-responsive'>";
		
			echo "<table id ='usuarios_table' class='table table-hover table-inverse table-sm table-bordered table_format'>";
			// table-hover: Ao Passar o mouse, fazer um destaque
			// table-sm: Diminuir o espaço entre as linhas

			echo "<thead class='thead-light'>";
			
			echo "<tr class='Status_Ativo'>";
			echo "<th>Obra</th>";
			echo "<th>Descrição</th>";
			echo "<th>Edição</th>";
			echo "<th>Status</th>";
			echo "</tr>";

			echo '</thead>';
			
			echo "<tbody>";
	
			if ($result->num_rows > 0) 
			{
				$Style_Status = '';
				$Cor_botao_inativar = '';
				$ToolTipText_inativar = '';
				$texto = '';

				while($row = $result->fetch_assoc()) 
				{
						
					if ($row["ativo"] == 'ativo')
					{
						$Style_Status = 'Status_Ativo';
						$Cor_botao_inativar = 'btn-warning';
						$ToolTipText_inativar = 'Desativar obra';
						$texto = 'Desativar';
					}
					else
					{
						$Style_Status = 'Status_Inativo';
						$Cor_botao_inativar = 'btn-success';
						$ToolTipText_inativar = 'Ativar obra';
						$texto = 'Ativar';
					}
					
					echo "<tr class='' "  . $Style_Status . "'>";
					echo "<td class=' "  . $Style_Status . "'>" . $row["nome"] . "</td>";
					echo "<td class=' "  . $Style_Status . "'>" . $row["descri"] . "</td>";
					
					echo " <td class='$Style_Status'> <a type='button' class='btn btn-primary d-flex justify-content-center' data-placement='top' data-toggle='tooltip' title='Alterar obra' href='minhaObra_digitar.php?ID={$row["id"]}'>	Alterar</a> </td>";
					echo " <td class='$Style_Status'> <a type='button' class='btn $Cor_botao_inativar d-flex justify-content-center' data-placement='top' data-toggle='tooltip' title='$ToolTipText_inativar' onclick='desativar({$row["id"]})' >$texto</a> </td>";

					echo "</tr>";			
				}
			} else {
				echo "Nenhum registro encontrado...";
			}
			
		echo "</tbody>";
		echo "</table>";
?>