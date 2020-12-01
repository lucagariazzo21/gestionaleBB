<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="float-left col">
                <h2>Statistiche</h2>
            </div>
        </div>
        <ul class="nav nav-tabs" id="myTab" role="tablist">
            <li class="nav-item">
              <a class="nav-link active" id="annuale-tab" data-toggle="tab" href="#annuale" role="tab" aria-controls="annuale" aria-selected="true">Annuale</a>
            </li>
            
          </ul>
        <div class="tab-content mt-3" id="myTabContent">
            <div class="tab-pane fade show active" id="annuale" role="tabpanel" aria-labelledby="annuale-tab">
                <div class="row">
                    <div class="col-8">
                        <?php if(!empty($data)): ?>
                            <canvas id="myChart" width="400" height="400" data-grafico = "<?php echo e(json_encode($data)); ?>"></canvas>
                        <?php else: ?>    
                            <b class="text-danger">Non sono stati trovati risultati...</b>
                        <?php endif; ?>
                    </div>
                    <div class="col-4 mt-4">
                        <div class="mb-3">
                            <form action="<?php echo e(route('ricavi.index')); ?>">
                                Seleziona anno :
                                <input type="text" name="year" pattern="\d{4}" placeholder="Inserisci un anno" value="<?php echo e($year); ?>">
                                <button class="btn btn-primary" type="submit">Cerca</button>
                            </form>
                        </div>
                        
                        <div class="alert alert-success" role="alert">
                            <h3><?php echo e($year); ?></h3>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-success">Ricavo</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="float-right"><?php echo e($tot['ricavo']); ?> €</h3> 
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3 class="text-success">Prenotazioni</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="float-right"><?php echo e($tot['prenotazioni']); ?></h3>
                                </div>
                            </div>
                            
                        </div>

                        <div class="alert alert-primary" role="alert">
                            <h3 class="text-primary">Totale</h3>
                            <hr class="bg-color-primary">
                            <div class="row">
                                <div class="col">
                                    <h3>Ricavo</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="text-primary float-right"><?php echo e($tot['tot_ricavo']); ?> €</h3> 
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <div class="col">
                                    <h3>Prenotazioni</h3> 
                                </div>
                                <div class="col">
                                    <h3 class="text-primary float-right"><?php echo e($tot['tot_prenotazioni']); ?></h3>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
            
        </div>
    </div>
    
    <?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gestionebb\resources\views/statistic.blade.php ENDPATH**/ ?>