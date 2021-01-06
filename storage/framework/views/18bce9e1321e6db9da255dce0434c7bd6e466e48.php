<?php $__env->startSection('seo_title', 'Auszeichnungen'); ?>
<?php $__env->startSection('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content awards">
  <h1>Auszeichnungen</h1>
  <div class="awards-list">
    <?php if($awards): ?>
      <?php $__currentLoopData = $awards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award_year_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="span">
          <article class="award-group">
            <?php $__currentLoopData = $award_year_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $award_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <h2><?php echo e($year); ?></h2>
              <?php $__currentLoopData = $award_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $award): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="award <?php if($award['file'] || $award['url']): ?> has-link <?php endif; ?>">
                  <h3>
                    <?php if($award['file']): ?>
                      <a href="<?php echo e(asset('storage/media/downloads/' . $award['file'])); ?>" target="_blank" title="<?php echo e($award['title']['de']); ?>">
                        <?php echo e($award['title']['de']); ?>

                      </a>
                    <?php elseif($award['url']): ?>
                      <a href="<?php echo e($award['url']); ?>" target="_blank" title="<?php echo e($award['title']['de']); ?>">
                        <?php echo e($award['title']['de']); ?>

                      </a>
                    <?php else: ?>
                      <?php echo e($award['title']['de']); ?>

                    <?php endif; ?>
                  </h3>
                  <div><?php echo e($award['description']['de']); ?></div>
                  <?php if($award['media']): ?>
                    <figure>
                      <img src="<?php echo ImageHelper::get($award['media'], 'xs'); ?>" width="600" height="400" alt="<?php echo e($award['title']['de']); ?>">
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
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/about/awards.blade.php ENDPATH**/ ?>