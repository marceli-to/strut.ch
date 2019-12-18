<figcaption>
  <?php if($element->projectimage->project->title): ?>
    <span><?php echo e($element->projectimage->project->title); ?></span>
  <?php else: ?>
    <span><?php echo e($element->projectimage->project->name); ?>, <?php echo e($element->projectimage->project->location); ?></span>
  <?php endif; ?>
</figcaption><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/partials/grids/home/caption.blade.php ENDPATH**/ ?>