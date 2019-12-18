<article class="news">
  <?php if($news->date): ?>
    <div class="news__date"><?php echo e($news->date); ?></div>
  <?php endif; ?>
  <div class="news__body <?php if($news->date): ?> has-date <?php endif; ?>">
    <h2><?php echo e($news->title); ?></h2>
    <?php if($news->subtitle): ?>
      <p class="news-subtitle"><?php echo e($news->subtitle); ?></p>
    <?php endif; ?>
    <?php if($news->text): ?>
      <p><?php echo e($news->text); ?></p>
    <?php endif; ?>
    <?php if($news->media): ?>
      <figure>
        <img src="<?php echo ImageHelper::get($news->media, 'xs'); ?>" width="500" height="350" alt="<?php echo e($news->title); ?>">
      </figure>
    <?php endif; ?>
    <?php if($news->link && $news->linkText): ?>
      <p>
        <a href="<?php echo e($news->link); ?>" class="icon-arrow">
          </span><?php echo e($news->linkText); ?></a>
        </a>
      </p>
    <?php endif; ?>
  </div>
</article><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/partials/news.blade.php ENDPATH**/ ?>