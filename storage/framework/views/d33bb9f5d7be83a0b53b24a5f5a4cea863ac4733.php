<?php $__env->startSection('content'); ?>
<div class="container">
    <h2>Crea una nuova camera</h2>
    <hr>
    <form action="<?php echo e(route('camere.create')); ?>">
        <div class="row">
            <div class="col-6">
                <div class="form-group row">
                    <label for="nome" class="col-sm-3 col-form-label"><b>Nome</b></label>
                    <div class="col-sm-9">
                        <input type="text" class="form-control" id="nome" required value="">
                    </div>
                </div>
        
                <div class="form-group row">
                    <label for="n_letti" class="col-sm-3 col-form-label"><b>Posti Letto</b></label>
                    <div class="col-sm-9">
                        <input type="number" min="1" class="form-control" id="n_letti" required value="">
                    </div>
                </div>
            </div>
    
            <div class="col-6">
                <div class="form-group row">
                    <div class="col-sm-7">
                      <button type="submit" class="btn btn-primary float-right">Crea</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\test\resources\views/camere/detail.blade.php ENDPATH**/ ?>