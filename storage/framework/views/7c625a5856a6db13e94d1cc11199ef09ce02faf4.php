<?php $__env->startSection('seo_title', 'Über uns'); ?>
<?php $__env->startSection('seo_description', 'Roger Studerus und Felix Rutishauser tragen gemeinsam die Verantwortung für die Strut Architekten AG. Im Team mit Peter Kunz werden eigenständige Projekte entwickelt, welche den Menschen ins Zentrum rücken.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content about">
  <?php if($content): ?>
    <div class="about-grid">
      <div class="span">
        <h1><?php echo e($content->title); ?></h1>
        <article>
          <?php echo $content->text; ?>

        </article>
      </div>
      <div class="span has-media">
        <?php $__currentLoopData = $content->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <figure class="about-image">
            <a href="<?php echo ImageHelper::get($image->name, 'lg'); ?>" data-fancybox="single">
              <img src="<?php echo ImageHelper::get($image->name, 'md'); ?>" width="960" height="650" alt="<?php echo e(config('app.name')); ?> - Team">
            </a>
          </figure>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </div>
    </div>
  <?php endif; ?>
  <h2>Team</h2>
  <div class="about__team js-msnry">
    <?php $__currentLoopData = $team; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="team-member js-msnry-item">
        <article>
          <header>
            <?php if($t->email): ?>
              <h3>
                <a href="mailto:<?php echo e($t->email); ?>"><?php echo e($t->firstname); ?> <?php echo e($t->name); ?></a>
              </h3>
            <?php else: ?>
              <h3>
                <?php echo e($t->firstname); ?> <?php echo e($t->name); ?>

              </h3>
            <?php endif; ?>
            <?php if($t->role): ?> <?php echo e($t->role); ?><br><?php endif; ?>
            <?php if($t->position): ?> <?php echo e($t->position); ?><br><?php endif; ?>
          </header>
          <figure>
            <img src="<?php echo ImageHelper::get($t->media, 'sm'); ?>" width="432" height="500" alt="<?php echo e(config('app.name')); ?> - <?php echo e($t->firstname); ?> <?php echo e($t->name); ?>">
          </figure>
          <div>
            <?php if($t->phone): ?> <?php echo e($t->phone); ?><br> <?php endif; ?>
            <?php if($t->email): ?> <a href="mailto:<?php echo e($t->email); ?>" class="anchor-dark"><?php echo e($t->email); ?></a> <?php endif; ?>
          </div>
          <a href="javascript:;" class="icon-toggle js-msnry-btn">
            <span>Lebenslauf</span>
          </a>
          <div class="team-member__cv" style="display:none"><?php echo $t->cv; ?></div>
        </article>
      </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/about/about.blade.php ENDPATH**/ ?>