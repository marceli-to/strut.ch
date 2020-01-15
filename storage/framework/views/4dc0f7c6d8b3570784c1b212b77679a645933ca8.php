<?php $__env->startSection('seo_title', 'Presse'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG zeigt in verschieden Publikationen eine breite Palette an ausgeführten Gebäuden: Schulgebäude, Private Wohnbauten und Siedlungen, Produktions- und Verwaltungsgebäude.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content press">
  <h1>Presse</h1>
  <div class="press-list">
    <?php if($press): ?>
      <?php $__currentLoopData = $press; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $press_year_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="span">
          <article class="press-group">
            <?php $__currentLoopData = $press_year_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $press_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <h2><?php echo e($year); ?></h2>
              <?php $__currentLoopData = $press_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="press-item <?php if($p['file'] || $p['url']): ?> has-link <?php endif; ?>">
                  <h3>
                    <?php if($p['file']): ?>
                      <a href="<?php echo e(asset('storage/media/downloads/' . $p['file'])); ?>" target="_blank" title="<?php echo e($p['title']['de']); ?>">
                        <?php echo e($p['title']['de']); ?>

                      </a>
                    <?php elseif($p['url']): ?>
                      <a href="<?php echo e($p['url']); ?>" target="_blank" title="<?php echo e($p['title']['de']); ?>">
                        <?php echo e($p['title']['de']); ?>

                      </a>
                    <?php else: ?>
                      <?php echo e($p['title']['de']); ?>

                    <?php endif; ?>
                  </h3>
                  <div>
                    <?php echo e($p['description']['de']); ?><?php if($p['project']): ?>, <?php echo e($p['project']['name']['de']); ?> <?php echo e($p['project']['location']['de']); ?> (<?php echo e($p['project']['year']); ?>)<?php endif; ?>
                  </div>
                  <?php if($p['media']): ?>
                    <figure>
                      <img src="<?php echo ImageHelper::get($p['media'], 'xs'); ?>" width="600" height="400" alt="<?php echo e($p['title']['de']); ?>">
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


<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/publications/press.blade.php ENDPATH**/ ?>