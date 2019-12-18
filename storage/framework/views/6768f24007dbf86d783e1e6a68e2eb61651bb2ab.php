<?php $__env->startSection('seo_title', 'Home'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG aus Winterthur, Schweiz. Gegründet im Jahre 2015 durch Roger Studerus, Felix Rutishauser und Peter Kunz.'); ?>
<?php $__env->startSection('content'); ?>
<section class="home">
  <?php if($highlight): ?>
    <figure class="is-highlight">
      <a href="<?php echo e(route('page.projects')); ?>/<?php echo e($highlight['slug']); ?>" title="<?php echo e(config('app.name')); ?> - <?php echo e($highlight['title']); ?>">
        <figcaption>
          <?php if($highlight['title']): ?>
            <span><?php echo e($highlight['title']); ?></span>
          <?php else: ?>
            <span><?php echo e($highlight['name']); ?></span>
          <?php endif; ?>
        </figcaption>
        <img src="<?php echo ImageHelper::get($highlight['image'], 'lg'); ?>" 
          width="1600" 
          height="1066"
          alt="<?php echo e($highlight['name']); ?>">
      </a>
    </figure>
  <?php endif; ?>
  <div class="home__grids">
    <div class="ratio-boxes">

      <?php $__currentLoopData = $grids; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $g): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <?php if($g['key'] == '1fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '2fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.2fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '3fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.3fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>
        
        <?php if($g['key'] == '3fr-landscape'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.3fr_landscape', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '2fr-1fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.2fr1fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr-2fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr2fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '2fr-1fr_stacked'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.2fr1fr_stacked', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>
        
        <?php if($g['key'] == '1fr_stacked-2fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr_stacked2fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr-1fr-1fr_stacked'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr1fr1fr_stacked', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr-1fr_stacked-1fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr1fr_stacked1fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

        <?php if($g['key'] == '1fr_stacked-1fr-1fr'): ?>
          <?php if(isset($g['elements'])): ?>
            <?php echo $__env->make('web.partials.grids.home.1fr_stacked1fr1fr', array('elements' => $g['elements']), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endif; ?>
        <?php endif; ?>

      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/home/index.blade.php ENDPATH**/ ?>