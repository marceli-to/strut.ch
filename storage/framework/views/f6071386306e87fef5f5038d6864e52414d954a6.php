<?php $__env->startSection('seo_title', 'Werkliste'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG entwickelt und plant anspruchsvolle Wohn- und Gewerbebauten. Das Büro kann auf erfolgreiche Projekte und mehr als 20-jährige Erfahrungen zurückgreifen.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content works">
  <?php echo $__env->make('web.pages.works.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="works-list">
    <?php if($projects): ?>
      <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $project_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="span">
            <article class="is-type">
              <?php if(array_key_exists($category->id, $categories)): ?>
                <h2><?php echo e($category->name); ?></h2>
                <?php $__currentLoopData = $category->activeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if(array_key_exists($type->id, $types)): ?>
                    <?php if($category->show_types): ?>
                      <article>
                        <h3><?php echo e($type->name_plural); ?></h3>
                        <?php $__currentLoopData = $type->activeProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'type'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </article>
                    <?php else: ?>
                      <div>
                        <?php $__currentLoopData = $type->activeProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'type'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </div>
                    <?php endif; ?>
                  <?php endif; ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              <?php endif; ?>
            </article>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/works/type.blade.php ENDPATH**/ ?>