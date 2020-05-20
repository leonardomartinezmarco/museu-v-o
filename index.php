<?php session_start(); include('menu.php');?>           

<main>
    <section class='row'>
        <div class="col-12 row mt-5">
            <div class="col-6">
                <div class="card" >
                    <div class="card-body text-center">
                        <h5 class="card-title">Obras</h5>
                            <p class="card-text">Veja as obras construídas.</p>
                            <a href="obras.php" class="btn btn-primary">Ver Obras</a>
                    </div>
                </div>      
            </div>    
                                
            <div class="col-6">
                <div class="card">
                    <div class="card-body text-center">
                        <h5 class="card-title">Artistas</h5>
                            <p class="card-text"><i class="fas fa-eye"></i>Veja os artistas por trás das obras.</p>
                            <a href="artistas.php" class="btn btn-primary">Ver Artistas</a>
                            </div>
                    </div>      
                </div>                              
            </div>
    </section>
</main>

<?php include('footer.php');?>
            
