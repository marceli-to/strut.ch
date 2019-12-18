<?php $__env->startSection('seo_title', $project->name . ', ' . $project->location .' - '. $project->categoryType->name_singular); ?>
<?php $__env->startSection('seo_description', substr(strip_tags($project->description),0,255)); ?>
<?php $__env->startSection('og_image', url('/') . ImageHelper::get($og_image, 'lg')); ?>
<?php $__env->startSection('content'); ?>
<style>
.label-preview {
  background-color: rebeccapurple;
  color: #fff;
  display: inline-block;
  right: 5px;
  top: 5px;
  padding: 10px 15px;
  line-height: 1;
  position: fixed;
  width: auto;
  z-index: 1000;
}
</style>
<span class="label-preview">Vorschau</span>
<section class="project js-project">
  <header class="project__header">
    <div>
      <h2><?php echo e($project->categoryType->name_singular); ?></h2>
      <nav class="project-browse">
        <span data-label-prev style="display:none">Vorheriges Projekt</span>
        <span data-label-next style="display:none">Nächstes Projekt</span>
        <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($browse['prev']); ?>" class="icon-browse-prev" data-prev></a>
        <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($browse['next']); ?>" class="icon-browse-next" data-next></a>
      </nav>
    </div>
  </header>
  <article>
    <a href="javascript:;" 
       class="btn-project-toggle" 
       data-toggle=".project__description"
       title="Projektbeschreibung anzeigen">
      <span>Info</span>
    </a>
    <h1><?php echo e($project->name); ?>, <?php echo e($project->location); ?></h1>
    <div class="project__images">
      <?php $__currentLoopData = $grids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <?php if($g['key'] == '2fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.projects.2fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr_stacked-1fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.projects.1fr_stacked1fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr-1fr_stacked'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.projects.1fr1fr_stacked', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
    <div class="project__description">
      <div>
        <div class="span project__description-body"><?php echo $project->description; ?></div>
        <div class="span">
            <?php echo $project->info; ?>

            <?php if($project->downloads): ?>
              <p>
                <?php $__currentLoopData = $project->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $download): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <a href="/storage/media/downloads/<?php echo e($download->name); ?>" 
                    target="_blank"
                    class="icon-file" 
                    title="Download Projektdokumentation">
                    <span><?php echo e($project->name); ?>, <?php echo e($project->location); ?></span>
                  </a>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </p>
            <?php endif; ?>
        </div>
      </div>
    </div>
    <div class="project__nav">
      <article>
        <a href="<?php echo e(route('page.projects')); ?>/<?php echo e($browse['next']->id); ?>" title="Nächstes Projekt">
          <span>Nächstes Projekt</span>
          <h3><?php echo e($browse['next']->name); ?>, <?php echo e($browse['next']->location); ?></h3>
          <?php if($browse['next']->images): ?>
            <?php $__currentLoopData = $browse['next']->activeImages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $image): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <figure>
                <img src="<?php echo ImageHelper::get($image->name, 'sm'); ?>" width="900" height="500" alt="<?php echo e($browse['next']->name); ?>, <?php echo e($browse['next']->location); ?>">
              </figure>
              <?php break; ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endif; ?>
        </a>
      </article>
    </div>
  </article>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/projects/preview.blade.php ENDPATH**/ ?>