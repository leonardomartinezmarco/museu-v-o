<?php include('php/sessao.php'); include('menu.php');?>  



<form action='minhas_obras.php?ID=0' method='POST' class='form-group row mt-5' style="margin-left: 1000px;">
    <button type="submit" class="btn btn-success btn-md botao_incluir" data-placement="top" data-toggle="tooltip" title="Criar nova obra">Criar</button>
</form>                                                                           

<div id='table_consulta_minhas_obras' class='container mt-12'></div>        

<script>   
    const parametros = '';
        $.post('php/consulta_minhas_obras.php',parametros, function(data) {
            $('#table_consulta_minhas_obras').html(data);})            
</script>                

<?php include('footer.php');?>             
