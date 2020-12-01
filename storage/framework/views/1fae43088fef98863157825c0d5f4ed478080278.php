<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="float-left">
        <h2>Prenotazioni</h2>
    </div>
    <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Da</th>
            <th scope="col">A</th>
            <th scope="col">Nominativo</th>
            <th scope="col">Camera</th>
            <th scope="col">N° Persone</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            <?php if(isset($prenotazioni)): ?>    
                <?php $__currentLoopData = $prenotazioni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prenotazione): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><th><?php echo e($prenotazione->data_arrivo); ?> alle <?php echo e($prenotazione->ora_arrivo); ?></th></tr>
                    <tr><th><?php echo e($prenotazione->data_partenza); ?> alle <?php echo e($prenotazione->ora_partenza); ?></th></tr>          
                    <tr><th><?php echo e($prenotazione->nome); ?> <?php echo e($prenotazione->cognnome); ?></th></tr>          
                    <tr><th><?php echo e($prenotazione->camnera->nome); ?></th></tr>          
                    <tr><th><?php echo e($prenotazione->n_persone); ?></th></tr>          
                    <tr>
                        <th>
                            <a class="btn btn-primary btn-sm" href="">Modifica</a>
                            <a class="btn btn-danger btn-sm" href="">Elimina</a>
                        </th>
                    </tr>          
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php else: ?>
                <tr><th colspan="8">Non sono stati trovati risultati...</th></tr>
            <?php endif; ?>
        </tbody>
      </table>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\test\resources\views/prenotazioni.blade.php ENDPATH**/ ?>