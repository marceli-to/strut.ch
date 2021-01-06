<?php echo $__env->make('web.pdf.partials.header', array('title' => $title), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<span class="date"><?php echo e($date); ?></span>
<span class="title">Werkliste nach Jahr</span>
<div class="content">
  <?php if($projects): ?>
    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <span class="content-title"><?php echo e($year); ?></span>
      <div class="content-items">
        <?php $__currentLoopData = $projects[$year]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="content-item">
            <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo config('status.' .$project->status); ?>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <img src="<?php echo e(asset('assets/img/plan-1583428297.svg')); ?>" width="100" style="display: block; width: 1190.55px; height: 841.89px">

  <?php endif; ?>
</div>

<?php echo $__env->make('web.pdf.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pdf/year.blade.php ENDPATH**/ ?>