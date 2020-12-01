<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col">
            <div class="float-left">
                <h2>Prenotazioni</h2>
            </div>
        </div>
        <div class="col">
            <div class="float-right">
                <button class="btn btn-primary" type="button" data-toggle="collapse" data-target="#collapseFilters" aria-expanded="false" aria-controls="collapseFilters">
                    Aggiungi Filtri
                </button>
            </div>
        </div>
    </div>
    <div class="row mt-2">
        <div class="col">
            <div class="collapse" id="collapseFilters">
                <div class="card card-body">
                    <form action="">
                        <div class="col-6">
                            <div class="form-group row">
                                <label for="nome" class="col-sm-2 col-form-label">Nome</label>
                                <div class="col-sm-9">
                                  <input type="text" class="form-control" name="nome" required value="<?php echo e(isset($filter['nome']) ? $filter['nome'] : ''); ?>">
                                </div>
                            </div>
                            <div class="form-group row">
                                <label for="nome" class="col-sm-2 col-form-label">Camera</label>
                                <div class="col-sm-9">
                                    <select name="camera" id="camera">
                                        <option></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <table class="table table-striped">
        <thead>
          <tr>
            <th scope="col">Dal</th>
            <th scope="col">Al</th>
            <th scope="col">Nominativo</th>
            <th scope="col">Camera</th>
            <th scope="col">N° Persone</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            <?php if($prenotazioni->count() > 0): ?>    
                <?php $__currentLoopData = $prenotazioni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prenotazione): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <th><?php echo e(date('d/m/Y', strtotime($prenotazione->data_arrivo))); ?> alle <?php echo e($prenotazione->ora_arrivo); ?></th>
                        <th><?php echo e(date('d/m/Y', strtotime($prenotazione->data_partenza))); ?> alle <?php echo e($prenotazione->ora_partenza); ?></th>          
                        <th><?php echo e($prenotazione->client->nome); ?></th>          
                        <th><?php echo e($prenotazione->room->nome); ?></th>          
                        <th><?php echo e($prenotazione->n_persone); ?></th>          
                        <th>
                            <?php if($prenotazione->data_partenza > date('Y-m-d')): ?>    
                                <a class="btn btn-primary btn-sm" href="<?php echo e(route('prenotazioni.edit', ['prenotazione' => $prenotazione->id])); ?>">Modifica</a>
                                <a class="btn btn-danger btn-sm" data-toggle="modal" data-target="#modal-deleteprenotazione-<?php echo e($prenotazione->id); ?>">Elimina</a>
                                <div class="modal fade" id="modal-deleteprenotazione-<?php echo e($prenotazione->id); ?>" tabindex="1" role="dialog" aria-labelledby="deleteprenotazione" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <h5 class="modal-title" id="deleteprenotazione">Sei sicuro di eliminare la prenotazione?</h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Annulla</button>
                                            <a type="button" class="btn btn-danger" href="<?php echo e(route('prenotazioni.destroy', ['prenotazione' => $prenotazione->id])); ?>">Cancella</a>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            <?php else: ?>
                                <a class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modal-infoprenotazione-<?php echo e($prenotazione->id); ?>">Info</a>
                                <div class="modal fade" id="modal-infoprenotazione-<?php echo e($prenotazione->id); ?>" tabindex="1" role="dialog" aria-labelledby="infoprenotazione" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                      <div class="modal-content">
                                        <div class="modal-header">
                                          <h5 class="modal-title" id="infoprenotazione">Info prenotazione</h5>
                                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                          </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="container">
                                                <div>
                                                    Nome : <b class="text-primary"><?php echo e($prenotazione->client->nome); ?></b>
                                                </div>
                                                <div>
                                                    Arrivo : <b class="text-success"><?php echo e(date('d/m/Y', strtotime($prenotazione->data_arrivo))); ?></b> alle <b class="text-success"><?php echo e($prenotazione->ora_arrivo); ?></b>
                                                </div>
                                                <div>
                                                    Partenza : <b class="text-danger"><?php echo e(date('d/m/Y', strtotime($prenotazione->data_partenza))); ?></b> alle <b class="text-danger"><?php echo e($prenotazione->ora_partenza); ?></b>
                                                </div>
                                                <div>
                                                    Camera : <b class="text-primary"><?php echo e($prenotazione->room->nome); ?></b>
                                                </div>
                                                <div>
                                                    Letto aggiuntivo :
                                                    <?php if($prenotazione->added_bed): ?>
                                                        <b class="text-success">SI</b>
                                                    <?php else: ?>
                                                        <b class="text-danger">NO</b>
                                                    <?php endif; ?>
                                                </div>
                                                <div>
                                                    Animali :
                                                    <?php if($prenotazione->has_animals): ?>
                                                        <b class="text-success">SI</b>
                                                    <?php else: ?>
                                                        <b class="text-danger">NO</b>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endif; ?>
                        </th>
                    </tr>          
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr><th colspan="8">Non sono stati trovati risultati...</th></tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php echo e($prenotazioni->links()); ?>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gestionebb\resources\views/prenotazioni/index.blade.php ENDPATH**/ ?>