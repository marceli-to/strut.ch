<?php echo $__env->make('web.pdf.partials.header', array('title' => $title), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<span class="date"><?php echo e($date); ?></span>
<span class="title">Werkliste nach Typ</span>
<div class="content">
    <?php if($projects): ?>
      <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php $__currentLoopData = $project_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <span class="content-title"><?php echo e($category->name); ?></span>
          <div class="content-items">
          <?php $__currentLoopData = $category->activeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($category->show_types): ?>
              <?php
                $activeProjects = collect($type->activeProjects);
                $sortedProjects = $activeProjects->sortByDesc('year');
              ?>
              <?php if($activeProjects->count() > 0): ?>
                <div class="content-item"><strong><?php echo e($type->name_plural); ?></strong></div>
                <?php $__currentLoopData = $sortedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="content-item"><?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->year); ?>, <?php echo config('status.' .$project->status); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <br>
              <?php endif; ?>
            <?php else: ?>
                <?php
                  $activeProjects = collect($type->activeProjects);
                  $sortedProjects = $activeProjects->sortByDesc('year');
                ?>
                <?php $__currentLoopData = $sortedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="content-item"><?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->year); ?>, <?php echo config('status.' .$project->status); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endif; ?>
</div>

<?php echo $__env->make('web.pdf.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pdf/type.blade.php ENDPATH**/ ?>