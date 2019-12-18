<div class="grid-2x1fr">
  <?php if(isset($elements[0])): ?>
    <div class="span">
      <a href="<?php echo ImageHelper::get($elements[0]->image->name, 'lg'); ?>" data-fancybox="gallery" data-caption="<?php echo e($elements[0]->image->caption); ?>">
        <img src="<?php echo ImageHelper::get($elements[0]->image->name, 'lg'); ?>"
          width="687"
          height="940"
          alt="<?php echo e($elements[0]->image->caption); ?>">
      </a>
    </div>
  <?php endif; ?>
  <?php if(isset($elements[1]) || isset($elements[2])): ?>
    <div class="span">
      <div class="grid-stack">
        <?php if(isset($elements[1])): ?>
          <div>
            <a href="<?php echo ImageHelper::get($elements[1]->image->name, 'lg'); ?>" data-fancybox="gallery" data-caption="<?php echo e($elements[1]->image->caption); ?>">
              <img src="<?php echo ImageHelper::get($elements[1]->image->name, 'md'); ?>"
                width="687"
                height="458"
                alt="<?php echo e($elements[1]->image->caption); ?>">
            </a>
          </div>
        <?php endif; ?>
        <?php if(isset($elements[2])): ?>
          <div>
            <a href="<?php echo ImageHelper::get($elements[2]->image->name, 'lg'); ?>" data-fancybox="gallery" data-caption="<?php echo e($elements[2]->image->caption); ?>">
              <img src="<?php echo ImageHelper::get($elements[2]->image->name, 'md'); ?>"
                width="687"
                height="458"
                alt="<?php echo e($elements[2]->image->caption); ?>">
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  <?php endif; ?>
</div><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/partials/grids/projects/1fr1fr_stacked.blade.php ENDPATH**/ ?>