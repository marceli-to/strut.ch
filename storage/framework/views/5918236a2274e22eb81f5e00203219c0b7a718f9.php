<?php $__env->startSection('seo_title', 'Bücher'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG zeigt in verschieden Publikationen eine breite Palette an ausgeführten Gebäuden: Schulgebäude, Private Wohnbauten und Siedlungen, Produktions- und Verwaltungsgebäude.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content books">
  <h1>Bücher</h1>
  <div class="books__grid js-msnry">
      <?php $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="book js-msnry-item">
          <article>
              <header>
                <h3><?php echo e($b->title); ?></h3>
                <figure>
                  <img src="<?php echo ImageHelper::get($b->media, 'sm'); ?>" width="600" height="400" alt="<?php echo e($b->title); ?>">
                </figure>
                <div class="book__detail">
                  <p><?php echo nl2br($b->description) ?></p>
                  <div>
                    <a href="javascript:;" class="icon-toggle is-reverse js-msnry-btn">
                      <span>Info</span>
                    </a>
                    <div class="book__info" style="display:none"><?php echo $b->info; ?></div>
                    <?php if($b->url): ?>
                      <div class="book__order">
                        <?php if (strpos($b->url, '@') != FALSE): ?>
                          <a href="mailto:<?php echo e($b->url); ?>?subject=Bestellung <?php echo e($b->title); ?>&body=Ich bestelle 1 Exemplar '<?php echo e($b->title); ?>'" 
                             title="Buch «<?php echo e($b->title); ?>» Bestellen" class="icon-arrow">
                            <span>Bestellen</span>
                          </a>
                        <?php else: ?>
                          <a href="<?php echo e($b->url); ?>" 
                             target="_blank" 
                             title="Buch «<?php echo e($b->title); ?>» Bestellen" class="icon-arrow">
                             <span>Bestellen</span>
                          </a>
                        <?php endif; ?>
                      </div>
                    <?php endif; ?>
                  </div>
                </div>
              </header>
          </article>
        </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/publications/books.blade.php ENDPATH**/ ?>