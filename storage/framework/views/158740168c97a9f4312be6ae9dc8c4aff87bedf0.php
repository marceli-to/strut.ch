<?php $__env->startSection('seo_title', 'Werkliste'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG entwickelt und plant anspruchsvolle Wohn- und Gewerbebauten. Das Büro kann auf erfolgreiche Projekte und mehr als 20-jährige Erfahrungen zurückgreifen.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content works">
  <?php echo $__env->make('web.pages.works.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="works-list">
    <?php if($projects): ?>
      <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_year_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="span">
          <article class="work-group">
            <?php $__currentLoopData = $project_year_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $year => $project_group): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <h2><?php echo e($year); ?></h2>
              <?php $__currentLoopData = $project_group; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="work-item <?php echo e($p['has_detail'] ? 'has-link' : ''); ?>">
                  <h3>
                    <?php if($p['has_detail']): ?>
                      <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($p); ?>">
                        <?php echo e($p['name']['de']); ?>, <?php echo e($p['location']['de']); ?>

                      </a>
                    <?php else: ?>
                      <?php echo e($p['name']['de']); ?>, <?php echo e($p['location']['de']); ?>

                    <?php endif; ?>
                  </h3>
                  <?php $__currentLoopData = $p['images']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($img['is_preview_year']): ?>
                      <figure>
                        <img src="<?php echo ImageHelper::get($img['name'], 'sm'); ?>" 
                             width="600"
                             height="400"
                             alt="<?php if($img['caption']['de']): ?><?php echo e($img['caption']['de']); ?> – <?php endif; ?><?php echo e($p['name']['de']); ?>, <?php echo e($p['location']['de']); ?>">
                      </figure>
                      <?php break; ?>
                    <?php endif; ?>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/works/year.blade.php ENDPATH**/ ?>