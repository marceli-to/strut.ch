<div class="work-item <?php echo e($project->has_detail ? 'has-link' : ''); ?>">
  <h3>
    <?php if($project->has_detail): ?>
      <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($project); ?>">
        <?php echo e($project->name); ?>, <?php echo e($project->location); ?>

      </a>
    <?php else: ?>
      <?php echo e($project->name); ?>, <?php echo e($project->location); ?>

    <?php endif; ?>
  </h3>
  <?php $__currentLoopData = $project->images; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $img): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php if($image_by == 'type'): ?>
      <?php if($img->is_preview_type): ?>
        <figure>
          <img src="<?php echo ImageHelper::get($img->name, 'sm'); ?>" 
              width="600"
              height="400"
              alt="<?php if($img->caption): ?><?php echo e($img->caption); ?> – <?php endif; ?><?php echo e($project->name); ?>, <?php echo e($project->location); ?>">
        </figure>
        <?php break; ?>
      <?php endif; ?>
    <?php endif; ?>
    <?php if($image_by == 'status'): ?>
      <?php if($img->is_preview_status): ?>
        <figure>
          <img src="<?php echo ImageHelper::get($img->name, 'sm'); ?>" 
              width="600"
              height="400"
              alt="<?php if($img->caption): ?><?php echo e($img->caption); ?> – <?php endif; ?><?php echo e($project->name); ?>, <?php echo e($project->location); ?>">
        </figure>
        <?php break; ?>
      <?php endif; ?>
    <?php endif; ?>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
</div><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/works/partials/item.blade.php ENDPATH**/ ?>