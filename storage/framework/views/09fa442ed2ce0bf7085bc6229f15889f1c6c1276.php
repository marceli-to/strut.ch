<?php $__env->startSection('seo_title', 'Vorträge'); ?>
<?php $__env->startSection('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content lectures">
  <h1>Vorträge</h1>
  <div class="lectures-list">
    <?php if($lectures): ?>
      <?php $__currentLoopData = $lectures; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecture_year_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="span">
          <article class="lecture-group">
            <?php $__currentLoopData = $lecture_year_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $lecture_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <h2><?php echo e($year); ?></h2>
              <?php $__currentLoopData = $lecture_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lecture): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="lecture <?php if($lecture['file'] || $lecture['url']): ?> has-link <?php endif; ?>">
                  <h3>
                    <?php if($lecture['file']): ?>
                      <a href="<?php echo e(asset('storage/media/downloads/' . $lecture['file'])); ?>" target="_blank" title="<?php echo e($lecture['title']['de']); ?>">
                        <?php echo e($lecture['title']['de']); ?>

                      </a>
                    <?php elseif($lecture['url']): ?>
                      <a href="<?php echo e($lecture['url']); ?>" target="_blank" title="<?php echo e($lecture['title']['de']); ?>">
                        <?php echo e($lecture['title']['de']); ?>

                      </a>
                    <?php else: ?>
                      <?php echo e($lecture['title']['de']); ?>

                    <?php endif; ?>
                  </h3>
                  <div><?php echo e($lecture['description']['de']); ?></div>
                  <?php if($lecture['media']): ?>
                    <figure>
                      <img src="<?php echo ImageHelper::get($lecture['media'], 'xs'); ?>" width="600" height="400" alt="<?php echo e($lecture['title']['de']); ?>">
                    </figure>
                  <?php endif; ?>
                </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </article>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/about/lectures.blade.php ENDPATH**/ ?>