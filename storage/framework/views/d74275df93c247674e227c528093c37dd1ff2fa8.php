<?php $__env->startSection('content'); ?>
<div class="container">
    <div class="row">
        <div class="col-2">
            <span class="badge" style="background-color: lightgreen;">&nbsp&nbsp</span> camera disponobile 
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: yellow;">&nbsp&nbsp</span> controlla le camere
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: red;">&nbsp&nbsp</span> camere occupate
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: lightgrey;">&nbsp&nbsp</span> giorni passati
        </div>
    </div>
    <hr>
    <div class="float-left">
        <h2>Agenda</h2>
    </div>
    <div class="float-right">
        <form action="<?php echo e(route('agenda')); ?>">
            Seleziona un giorno : <input type="date" name="day" value="<?php echo e($day); ?>">
            <button class="btn btn-primary" type="submit">Cerca</button>
        </form>
    </div>
    <table class="table">
        <thead class="thead-dark">
          <tr>
            <th scope="col">Giorno</th>
            <th scope="col">Stato</th>
            <th scope="col">Informazioni</th>
            <th scope="col">Azioni</th>
          </tr>
        </thead>
        <tbody>
            <?php
                $n_modal = 1;
            ?>
            <?php $__currentLoopData = $period; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $date): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $count_ora_arrivo = 0;
                    $status = '';
                    if (date('Y-m-d') <= $date->format('Y-m-d')) {
                        if(empty($array[$date->format('Y-m-d')])) {
                            $status = 'lightgreen';
                        } elseif (count($array[$date->format('Y-m-d')]) < $tot_camere) {
                            $status = 'lightgreen';
                        } elseif (count($array[$date->format('Y-m-d')]) == $tot_camere) {
                            foreach ($array[$date->format('Y-m-d')] as $value) {
                                foreach ($value as $item) {
                                    if (isset($item['ora_arrivo'])) {
                                        $count_ora_arrivo++;
                                    }
                                    if (!isset($item['ora_arrivo']) && !isset($item['ora_partenza'])) {
                                        $count_ora_arrivo++;
                                    }
                                    if (isset($item['ora_partenza']) && !isset($item['ora_partenza'])) {
                                        break;
                                    }
                                }
                            }
                            if ($count_ora_arrivo == $tot_camere) {
                                $status = 'red';
                            } else {
                                $status = 'yellow';
                            }
                        }
                    } else {
                        $status = 'lightgrey';
                    }
                ?>
                <tr style="background-color: <?php echo e($status); ?>;">
                    <th>
                        <b class="<?php echo e($date->format('Y-m-d') == $day ? 'text-primary' : ''); ?>"><?php echo e($date->format('d/m/Y')); ?></b>
                    </th>
                    <th>
                        <?php if(!empty($array[$date->format('Y-m-d')]) && $count_ora_arrivo < $tot_camere): ?>
                            camere occupate : <?php echo e(count($array[$date->format('Y-m-d')])); ?>

                        <?php elseif($date->format('Y-m-d') >= date('Y-m-d') && $count_ora_arrivo == $tot_camere): ?>
                            OCCUPATO
                        <?php elseif(empty($array[$date->format('Y-m-d')])): ?>
                            LIBERO
                        <?php endif; ?>
                    </th>
                    <th>
                        <?php if(!empty($array[$date->format('Y-m-d')])): ?>    
                            <button class="btn btn-primary btn-sm view-info" data-toggle="modal" data-target="#modal-info-<?php echo e($n_modal); ?>">
                                <i class="fa fa-eye"></i>INFO
                            </button>
                            <div class="modal fade" id="modal-info-<?php echo e($n_modal); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                  <div class="modal-content">
                                    <div class="modal-header">
                                      <h5 class="modal-title" id="exampleModalLabel">Informazioni <?php echo e($date->format('d/m/Y')); ?></h5>
                                      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                      </button>
                                    </div>
                                    <div class="modal-body info">
                                        <?php if(!empty($array[$date->format('Y-m-d')])): ?>
                                            <?php $__currentLoopData = $array[$date->format('Y-m-d')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camera => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <h5><?php echo e($camera); ?></h5>
                                                <?php $__currentLoopData = $item; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>   
                                                    <?php if(isset($value['ora_arrivo'])): ?>
                                                        arriva <b class="text-primary"><?php echo e($value['cliente']); ?></b> alle <b class="text-success"><?php echo e($value['ora_arrivo']); ?></b><br>
                                                    <?php elseif(isset($value['ora_partenza'])): ?>
                                                        parte <b class="text-primary"><?php echo e($value['cliente']); ?></b> alle <b class="text-danger"><?php echo e($value['ora_partenza']); ?></b><br>
                                                    <?php else: ?>
                                                        occupata da <b class="text-primary"><?php echo e($value['cliente']); ?></b> tutto il giorno<br>
                                                    <?php endif; ?>
                                                    <?php if($value['ora_sveglia'] && $value['ora_sveglia'] != 0): ?>
                                                        <div>Ora sveglia : <b class="text-info"><?php echo e($value['ora_sveglia']); ?></b></div>
                                                    <?php endif; ?>
                                                    <?php if($value['colazione']): ?>
                                                        <div>Colazione : <b class="text-info"><?php echo e($value['colazione']); ?></b></div>
                                                    <?php endif; ?>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                <hr>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </th>
                    <th>
                        <?php
                            $max_hour = null;
                            if(!empty($array[$date->format('Y-m-d')])) {
                                $count = 0;
                                if (count($array[$date->format('Y-m-d')]) == $tot_camere) {
                                    foreach ($array[$date->format('Y-m-d')] as $value) {
                                        if (count($value) < 2) {
                                            foreach ($value as $item) {
                                                if (isset($item['ora_partenza'])) {
                                                    if ($count == 0) {
                                                        $max_hour = $item['ora_partenza'];
                                                    } elseif($max_hour > $item['ora_partenza']) {
                                                        $max_hour = $item['ora_partenza'];
                                                    }
                                                }
                                            }
                                            $count++;
                                        }
                                    }
                                }
                            }
                        ?>
                        <?php if(date('Y-m-d') <= $date->format('Y-m-d') && $count_ora_arrivo < $tot_camere): ?>    
                            <a class="btn btn-primary btn-sm" href="<?php echo e(route('prenotazioni.detail', ['day' => $date->format('Y-m-d'), 'ora_max' => $max_hour])); ?>">
                                Aggiungi
                            </a>
                        <?php endif; ?>
                    </th>
                </tr>
                <?php
                    $n_modal++;
                ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </tbody>
    </table>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\gestionebb\resources\views/agenda.blade.php ENDPATH**/ ?>