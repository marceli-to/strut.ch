<?php echo $__env->make('web.pdf.partials.header', array('title' => $title), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<span class="date"><?php echo e($date); ?></span>
<span class="title">Werkliste Gesamt</span>
<div class="content">
  <?php if($projects): ?>
    <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <?php $__currentLoopData = $project_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php if(count($category->activeTypes) > 0): ?>
          <span class="content-title"><?php echo e($category->name); ?></span>
          <div class="content-items">
          <?php $__currentLoopData = $category->activeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <?php if($category->show_types && count($type->activeProjects) > 0): ?>
                <div class="content-item"><strong><?php echo e($type->name_plural); ?></strong></div>
                <?php
                  $activeProjects = collect($type->activeProjects);
                  $sortedProjects = $activeProjects->sortByDesc('year');
                ?>
                <?php $__currentLoopData = $sortedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="content-item"><?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->year); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <br>
            <?php else: ?>
                <?php
                  $activeProjects = collect($type->activeProjects);
                  $sortedProjects = $activeProjects->sortByDesc('year');
                ?>
                <?php $__currentLoopData = $sortedProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <div class="content-item"><?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->year); ?></div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php endif; ?>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>

  <?php if(isset($competition['1. Preis']) || isset($competition['2. Preis']) || isset($competition['Andere'])): ?>
    <span class="content-title">Wettbewerbe</span>
    <div class="content-items">
      <?php if(isset($competition['1. Preis'])): ?>
        <div class="content-item"><strong>1. Preis</strong></div>
        <?php $__currentLoopData = $competition['1. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="content-item">
            <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <br>
      <?php endif; ?>

      <?php if(isset($competition['2. Preis'])): ?>
        <div class="content-item"><strong>2. Preis</strong></div>
        <?php $__currentLoopData = $competition['2. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="content-item">
            <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <br>
      <?php endif; ?>

      <?php if(isset($competition['Andere'])): ?>
        <div class="content-item"><strong>Andere</strong></div>
        <?php $__currentLoopData = $competition['Andere']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <div class="content-item">
            <?php echo e($project->name); ?>, <?php echo e($project->location); ?> – <?php echo e($project->categoryType->name_singular); ?>, <?php echo e($project->year); ?>

          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php endif; ?>
    </div>
  <?php endif; ?>
</div>

<?php echo $__env->make('web.pdf.partials.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pdf/all.blade.php ENDPATH**/ ?>