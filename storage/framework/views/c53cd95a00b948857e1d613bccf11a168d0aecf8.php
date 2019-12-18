<div class="box-3x1fr">
  <div>
    <div class="box__e">
      <?php if(isset($elements[0])): ?>
        <?php if($elements[0]->project_image_id): ?>
          <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($elements[0]->projectimage->project); ?>">
            <figure>
              <?php echo $__env->make('web.partials.grids.home.caption', array('element' => $elements[0]), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <img src="<?php echo ImageHelper::get($elements[0]->projectimage->name, 'md'); ?>" 
                height="616" 
                width="450" 
                alt="<?php echo e($elements[0]->projectimage->caption); ?>">
            </figure>
          </a>
        <?php endif; ?>
        <?php if($elements[0]->news_id): ?>
          <?php echo $__env->make('web.partials.news', array('news' => $elements[0]->news), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <div class="box__e">
      <?php if(isset($elements[1])): ?>
        <?php if($elements[1]->project_image_id): ?>
          <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($elements[1]->projectimage->project); ?>">
            <figure>
              <?php echo $__env->make('web.partials.grids.home.caption', array('element' => $elements[1]), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <img src="<?php echo ImageHelper::get($elements[1]->projectimage->name, 'md'); ?>" 
                height="616" 
                width="450" 
                alt="<?php echo e($elements[1]->projectimage->caption); ?>">
            </figure>
          </a>
        <?php endif; ?>
        <?php if($elements[1]->news_id): ?>
          <?php echo $__env->make('web.partials.news', array('news' => $elements[1]->news), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
  <div>
    <div class="box__e">
      <?php if(isset($elements[2])): ?>
        <?php if($elements[2]->project_image_id): ?>
          <a href="<?php echo e(route('page.projects')); ?>/<?php echo AppHelper::getSlug($elements[2]->projectimage->project); ?>">
            <figure>
              <?php echo $__env->make('web.partials.grids.home.caption', array('element' => $elements[2]), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
              <img src="<?php echo ImageHelper::get($elements[2]->projectimage->name, 'md'); ?>" 
                height="616" 
                width="450" 
                alt="<?php echo e($elements[2]->projectimage->caption); ?>">
            </figure>
          </a>
        <?php endif; ?>
        <?php if($elements[2]->news_id): ?>
          <?php echo $__env->make('web.partials.news', array('news' => $elements[2]->news), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
      <?php endif; ?>
    </div>
  </div>
</div><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/partials/grids/home/3fr.blade.php ENDPATH**/ ?>