<?php echo $__env->make('web.pdf.partials.header', array('title' => $title), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<span class="date"><?php echo e($date); ?></span>
<span class="title">Werkliste nach Status</span>
<div class="content">
  <?php if(isset($projects['Ausgeführt'])): ?>
    <span class="content-title">Ausgeführt</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['Ausgeführt']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>

  <?php if(isset($projects['In Planung'])): ?>
    <span class="content-title">In Planung</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['In Planung']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>

  <?php if(isset($projects['Studie'])): ?>
    <span class="content-title">Studie</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['Studie']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>

  

</div>

<?php echo $__env->make('web.pdf.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pdf/state.blade.php ENDPATH**/ ?>