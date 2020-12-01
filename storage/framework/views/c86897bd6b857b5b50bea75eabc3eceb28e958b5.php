<?php $__env->startSection('content'); ?>
    <div class="container">
        <div class="row">
            <div class="col">
                <div class="float-left">
                    <h2>Clienti</h2>
                </div>
            </div>
            <div class="col-4">
                <form action="<?php echo e(route('client.index')); ?>" class="float-right">
                    Filtra : <input type="text" name="filter" value="<?php echo e($filter); ?>">
                    <button class="btn btn-primary" type="submit">Cerca</button>
                </form>
            </div>
        </div>
        <table class="table table-striped table-dark">
            <thead>
              <tr>
                <th scope="col">Nome</th>
                <th scope="col">Ora Sveglia</th>
                <th scope="col">Colazione</th>
                <th scope="col">Azioni</th>
              </tr>
            </thead>
            <tbody>
                <?php if($clienti->count() > 0): ?>    
                    <?php $__currentLoopData = $clienti; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $cliente): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <tr>
                            <th><?php echo e($cliente->nome); ?></th>
                            <th><?php echo e($cliente->ora_sveglia != 0 ?: null); ?></th>         
                            <th><?php echo e($cliente->colazione); ?></th>
                            <th>
                                
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-editCliente-<?php echo e($cliente->id); ?>">Modifica</a>
                                <div class="modal fade" id="modal-editCliente-<?php echo e($cliente->id); ?>" tabindex="1" role="dialog" aria-labelledby="editCliente" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header bg-dark">
                                        <h5 class="modal-title" id="editCliente">Modifica Cliente</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-body bg-dark">
                                            <div class="container">
                                                <form action="<?php echo e(route('client.edit')); ?>" method="GET">
                                                    <input type="hidden" name="id" value="<?php echo e($cliente->id); ?>">
                                                    <div class="form-group row">
                                                        <label for="nome" class="col-sm-3 col-form-label"><b>Nome</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="text" class="form-control" name="nome" required value="<?php echo e($cliente->nome); ?>">
                                                        </div>
                                                    </div>
                                            
                                                    <div class="form-group row">
                                                        <label for="n_letti" class="col-sm-3 col-form-label"><b>Ora Sveglia</b></label>
                                                        <div class="col-sm-9">
                                                            <input type="time" class="form-control" name="ora_sveglia" required  value="<?php echo e($cliente->ora_sveglia); ?>">
                                                        </div>
                                                    </div>

                                                    <div class="form-group row">
                                                        <label for="n_letti" class="col-sm-3 col-form-label"><b>Colazione</b></label>
                                                        <div class="col-sm-9">
                                                            <textarea name="colazione" cols="42" rows="5"><?php echo e($cliente->colazione); ?></textarea>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="form-group row">
                                                        <div class="col-sm-7">
                                                        <button type="submit" class="btn btn-primary float-right">Salva</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>      
                            </th>   
                        </tr>          
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <tr><th colspan="8">Non sono stati trovati risultati...</th></tr>
                <?php endif; ?>
            </tbody>
        </table>
        <?php echo e($clienti->links()); ?>

    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gestionebb\resources\views/clients.blade.php ENDPATH**/ ?>