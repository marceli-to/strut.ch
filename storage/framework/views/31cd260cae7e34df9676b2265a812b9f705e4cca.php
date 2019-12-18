<?php echo $__env->make('web.pdf.partials.header', array('title' => $title), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<span class="date"><?php echo e($date); ?></span>
<span class="title">Werkliste Wettbewerbe</span>
<div class="content">
  <?php if(isset($projects['1. Preis'])): ?>
    <span class="content-title">1. Preis</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['1. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
  <?php if(isset($projects['2. Preis'])): ?>
    <span class="content-title">2. Preis</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['2. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
  <?php if(isset($projects['Andere'])): ?>
    <span class="content-title">Andere</span>
    <div class="content-items">
      <?php $__currentLoopData = $projects['Andere']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="content-item">
          <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php endif; ?>
</div>
<?php echo $__env->make('web.pdf.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pdf/competition.blade.php ENDPATH**/ ?>