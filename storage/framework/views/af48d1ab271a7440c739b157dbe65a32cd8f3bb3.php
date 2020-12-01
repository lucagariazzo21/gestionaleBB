<?php $__env->startSection('content'); ?>
<div class="container">
    <?php
        $today = date('Y-m-d');
        $period = new DatePeriod(
            new DateTime(date('Y-m-d', strtotime($today. ' - 5 days'))),
            new DateInterval('P1D'),
            new DateTime(date('Y-m-d', strtotime($today. ' + 5 days')))
        );

        $array = [
            '2020-10-03' => [
                '1' => [
                    'nome' =>'Mario Rossi',
                    'ora_arrivo' => '08:00',
                ],
                '2' => [
                    'nome' =>'Gianni Bianchi',
                    'ora_arrivo' => '10:00',
                ],
                '3' => [
                    'nome' =>'Luigi Verdi',
                    'ora_arrivo' => '16:00',
                ]
            ],
            '2020-10-04' => [
                '1' => [
                    'nome' =>'Mario Rossi',
                ],
                '3' => [
                    'nome' =>'Luigi Verdi',
                    'ora_partenza' => '10:00',
                ]
            ],
            '2020-10-05' => [
                '1' => [
                    'nome' =>'Mario Rossi',
                    'ora_partenza' => '15:30',
                ]
            ],
        ];
    ?>
    <div class="row">
        <div class="col-2">
            <span class="badge" style="background-color: lightgreen;">&nbsp&nbsp</span> camera disponobile 
        </div>
        <div class="col-2">
            <span class="badge" style="background-color: yellow;">&nbsp&nbsp</span> camera occupate
        </div>
        <div class="col-3">
            <button class="btn btn-primary btn-sm" disabled>INFO</button> visualizza le info delle camere
        </div>
        <div class="col-5">
            <button class="btn btn-primary btn-sm" disabled>Aggiungi</button> permette di creare una nuova prenotazione
        </div>
    </div>
    <hr>
    <div class="float-right">
        <form action="">
            Selezione un giorno : <input type="date" min="<?php echo e(date('Y-m-d')); ?>">
            <button class="btn btn-primary" type="submit">Cerca</button>
        </form>
    </div>
    <br><br>
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
                    $status = '';
                    if(empty($array[$date->format('Y-m-d')])) {
                        $status = 'lightgreen';
                    } elseif (count($array[$date->format('Y-m-d')]) < 3) {
                        $status = 'lightgreen';
                    } elseif (count($array[$date->format('Y-m-d')]) == 3) {
                        $status = 'yellow';
                    }
                ?>
                <tr style="background-color: <?php echo e($status); ?>;">
                    <th>
                        <b><?php echo e($date->format('d/m/Y')); ?></b>
                    </th>
                    <th>
                        <?php
                            if (!empty($array[$date->format('Y-m-d')]) && count($array[$date->format('Y-m-d')]) <= 3) {
                                $min_date = null;
                                $count = 0;
                                foreach ($array[$date->format('Y-m-d')] as $camera => $item) {
                                    if (isset($item['ora_arrivo'])) {
                                        if ($count > 0) {
                                           if ($item['ora_arrivo'] < $min_date) {
                                                $min_date = $item['ora_arrivo'];
                                           }
                                        } else {
                                            $min_date = $item['ora_arrivo'];
                                        }
                                    }
                                    $count++;
                                }
                            } else {
                                $libero = 'Libero';
                            }
                        ?>
                        <?php if(!empty($array[$date->format('Y-m-d')])): ?>
                            camere occupate : <?php echo e(count($array[$date->format('Y-m-d')])); ?>

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
                                        <ul>
                                            <?php $__currentLoopData = $array[$date->format('Y-m-d')]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $camera => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <li>
                                                    Camera <?php echo e($camera); ?> occupata da <?php echo e($item['nome']); ?>

                                                    <?php if(isset($item['ora_arrivo'])): ?>
                                                        dalle <?php echo e($item['ora_arrivo']); ?> <b class="text-success">arrivo</b>
                                                    <?php elseif(isset($item['ora_partenza'])): ?>
                                                        fino alle <?php echo e($item['ora_partenza']); ?> <b class="text-danger">partenza</b>
                                                    <?php else: ?>
                                                        tutto il giorno
                                                    <?php endif; ?>
                                                </li>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </ul>
                                        <?php endif; ?>
                                    </div>
                                  </div>
                                </div>
                            </div>
                        <?php endif; ?>
                    </th>
                    <th>
                        <a class="btn btn-primary btn-sm" href="">
                            Aggiungi
                        </a>
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

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\laragon\www\test\resources\views/home.blade.php ENDPATH**/ ?>