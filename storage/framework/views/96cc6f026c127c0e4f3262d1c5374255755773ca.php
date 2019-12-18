<?php $__env->startSection('seo_title', 'Kontakt'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG aus Winterthur, Schweiz. Gegründet im Jahre 2015 durch Roger Studerus, Felix Rutishauser und Peter Kunz.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content contact">
  <?php if($contact): ?>
    <div class="contact-grid">
      <div class="span">
        <h1><?php echo e($contact->title); ?></h1>
        <article>
          <?php echo $contact->text; ?>

        </article>
        <?php if($imprint): ?>
          <div class="contact__imprint">
            <a href="javascript:;" class="icon-toggle js-btn-toggle">
              <span>Impressum</span>
            </a>
            <div style="display:none">
                <?php echo $imprint->text; ?>

            </div>
          </div>
        <?php endif; ?>
      </div>
      <div class="span has-media">
        <div class="contact__maps" id="js-maps"></div>
        <div><a href="https://goo.gl/maps/iP116gayDdwGiKFm7" target="_blank" rel="noopener">Auf Google Maps anzeigen</a></div>
      </div>
    </div>
  <?php endif; ?>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/pages/contact/index.blade.php ENDPATH**/ ?>