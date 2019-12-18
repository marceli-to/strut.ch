<?php $__env->startSection('seo_title', 'Jobs'); ?>
<?php $__env->startSection('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content jobs">
  <div class="jobs-grid">
    <div class="span">
      <h1>Jobs</h1>
      <?php if(!$jobs->isEmpty()): ?>
        <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <article class="job">
            <h2><?php echo e($j->title); ?></h2>
            <p class="job__lead"><?php echo e($j->lead); ?></p>
            <div class="job__description"><?php echo $j->info; ?></div>
          </article>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php else: ?>
        <?php if($content): ?>
          <article class="job">
            <?php echo $content->text; ?>

          </article>
        <?php endif; ?>
      <?php endif; ?>
    </div>
    <div class="span has-media">
      <?php if($content->images): ?>
        <?php $__currentLoopData = $content->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <figure>
            <a href="<?php echo ImageHelper::get($image->name, 'lg'); ?>" <?php if($content->images->count() > 1): ?>data-fancybox="gallery" <?php else: ?> data-fancybox="single" <?php endif; ?>>
              <img src="<?php echo ImageHelper::get($image->name, 'md'); ?>" width="960" height="650" alt="<?php echo e(config('app.name')); ?> - Jobs">
            </a>
          </figure>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/about/jobs.blade.php ENDPATH**/ ?>