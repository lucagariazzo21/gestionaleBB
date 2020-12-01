<?php $__env->startSection('content'); ?>
<?php
    $readonly = '';
    if (isset($view_camere)) {
        $readonly = 'readonly';
        $action = route('prenotazioni.create');
    } else {
        $action = route('prenotazioni.check');
    }
?>
<div class="container">
    <div class="row">
        <div class="float-left col">
            <h2>Crea una nuova prenotazione</h2>
        </div>
        <div class="col">
            <?php if(isset($edit) && $edit): ?>
                <a class="btn btn-secondary float-right" href="<?php echo e(route('prenotazioni.prenotazioni')); ?>">Indietro</a>
            <?php else: ?>
                <form action="<?php echo e(route('agenda')); ?>">
                    <input type="date" hidden value="<?php echo e(isset($day) ? $day : ''); ?>" name="day">
                    <button type="submit" class="btn btn-secondary float-right">Indietro</button>
                </form>
            <?php endif; ?>
        </div>
    </div>
    <hr>
    <form action="<?php echo e($action); ?>">
        <input type="hidden" value="<?php echo e(isset($data['id']) ? $data['id'] : ''); ?>" name="prenotazione_id">
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Data Arrivo</label>
            <div class="col-sm-10">
              <input <?php echo e($readonly); ?> type="date" class="form-control" name="data_arrivo" required value="<?php echo e(isset($day) ? $day : ( isset($data['data_arrivo']) ? $data['data_arrivo'] : '')); ?>" <?php echo e(isset($day) ? 'readonly' : ''); ?>>
            </div>
        </div>
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Ora Arrivo</label>
            <div class="col-sm-10">
              <input <?php echo e($readonly); ?> type="time" class="form-control" name="ora_arrivo" required min="<?php echo e(isset($ora_inizio) ? $ora_inizio : ''); ?>" value="<?php echo e(isset($data['ora_arrivo']) ? $data['ora_arrivo'] : ''); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Data Partenza</label>
            <div class="col-sm-10">
              <input <?php echo e($readonly); ?> type="date" class="form-control" name="data_partenza" required value="<?php echo e(isset($data['data_partenza']) ? $data['data_partenza'] : ''); ?>" min="<?php echo e(isset($day) ? date('Y-m-d', strtotime($day. ' + 1 days')) : ''); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Ora Partenza</label>
            <div class="col-sm-10">
              <input type="time" class="form-control" name="ora_partenza" required value="<?php echo e(isset($data['ora_partenza']) ? $data['ora_partenza'] : ''); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Nominativo</label>
            <div class="col-sm-10">
              <input type="text" class="form-control" name="nome" placeholder="Nominativo" required value="<?php echo e(isset($data['nome']) ? $data['nome'] : ''); ?>">
            </div>
        </div>
        <div class="form-group row">
            <label for="nome" class="col-sm-2 col-form-label">Numero Persone</label>
            <div class="col-sm-10">
              <input <?php echo e($readonly); ?> type="number" class="form-control" min="1" name="n_persone" placeholder="Numero Persone" required value="<?php echo e(isset($data['n_persone']) ? $data['n_persone'] : ''); ?>">
            </div>
        </div>
        <div class="form-check row">
            <label class="form-check-label col-2" for="defaultCheck1">
                Letto in Aggiunta
            </label>
            <input <?php echo e(isset($view_camere) ? 'readonly' : ''); ?> class="form-check-input col-1" type="checkbox" name="added_bed" <?php echo e(isset($data['added_bed']) ? 'checked' : ''); ?>>
        </div>
        <p>
        <div class="form-check row">
            <label class="form-check-label col-2" for="defaultCheck1">
                Ha animali?
            </label>
            <input <?php echo e(isset($view_camere) ? 'readonly' : ''); ?> class="form-check-input col-1" type="checkbox" name="has_animals" <?php echo e(isset($data['has_animals']) ? 'checked' : ''); ?>>
        </div>
        <hr>
        <?php if(isset($view_camere)): ?>
            <div class="alert alert-success" role="alert">
                Delle camere sono disponibili per il periodo selezionato! Scegli una camera per continuare.
            </div>

            <div class="form-group">
                <select class="form-control" name="camera_id" required>
                    <option></option>
                    <?php $__currentLoopData = $camere_libere; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camera): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($camera->id); ?>"><?php echo e($camera->nome); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </select>
            </div>
            <hr>
            <div class="form-group row">
                <div class="col-sm-6">
                <button type="submit" class="btn btn-primary float-right">Salva</button>
                </div>
            </div>
        <?php else: ?>
            <div class="form-group row">
                <div class="col-sm-7">
                <button type="submit" class="btn btn-primary float-right">Verifica Disponibilità</button>
                </div>
            </div>
            <?php if(isset($message)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo e($message); ?>

                </div>
            <?php endif; ?>
        <?php endif; ?>


    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\test\resources\views/prenotazioni/detail.blade.php ENDPATH**/ ?>