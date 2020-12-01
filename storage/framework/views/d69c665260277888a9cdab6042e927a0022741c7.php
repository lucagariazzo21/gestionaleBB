<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="float-left">
        <h2>Camere</h2>
    </div>
    <div class="float-right">
        <a class="btn btn-primary" href="<?php echo e(route('camere.create')); ?>">Aggiungi</a>
    </div>
    <table class="table table-striped table-dark">
        <thead>
          <tr>
            <th scope="col">Nome</th>
            <th scope="col">Numero Letti</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            <?php if(isset($prenotazioni)): ?>    
                <?php $__currentLoopData = $prenotazioni; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $prenotazione): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr><th><?php echo e($prenotazione->nome); ?></th></tr>
                    <tr><th><?php echo e($prenotazione->n_letti); ?></th></tr>          
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
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\test\resources\views/camere.blade.php ENDPATH**/ ?>