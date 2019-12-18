<nav class="work-groups">
  <div class="span">
    <ul>
      <li>
        <a href="<?php echo e(route('page.works.status')); ?>" <?php if($listBy == 'status'): ?> class="is-active" <?php endif; ?>>Status</a>
      </li>
      <li>
        <a href="<?php echo e(route('page.works.year')); ?>" <?php if($listBy == 'year'): ?> class="is-active" <?php endif; ?>>Jahr</a>
      </li>
      <li>
        <a href="<?php echo e(route('page.works.type')); ?>" <?php if($listBy == 'type'): ?> class="is-active" <?php endif; ?>>Typ</a>
      </li>
    </ul>
  </div>
  <div class="span">
      <?php if($listBy == 'status'): ?>
        <a href="<?php echo e(route('pdf.works.state')); ?>" target="_blank" class="icon-file"><span>Werkliste nach Status</span></a>
      <?php endif; ?>
      <?php if($listBy == 'year'): ?>
        <a href="<?php echo e(route('pdf.works.year')); ?>" target="_blank" class="icon-file"><span>Werkliste nach Jahr</span></a>
      <?php endif; ?>
      <?php if($listBy == 'type'): ?>
        <a href="<?php echo e(route('pdf.works.type')); ?>" target="_blank" class="icon-file"><span>Werkliste nach Typ</span></a>
      <?php endif; ?>
    </a>
  </div>
</nav><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/works/nav.blade.php ENDPATH**/ ?>