<?php $__env->startSection('seo_title', 'Downloads'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG zeigt in verschieden Publikationen eine breite Palette an ausgeführten Gebäuden: Schulgebäude, Private Wohnbauten und Siedlungen, Produktions- und Verwaltungsgebäude.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content downloads">
  <h1>Downloads</h1>
  <div class="downloads__grid">
    <div class="span">
      <article>
        <h2>Projektdokumentationen</h2>
        <?php if($projects): ?>
          <?php $__currentLoopData = $projects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project_category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php $__currentLoopData = $project_category; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php if(array_key_exists($category->id, $categories)): ?>
                  <div class="download-group is-article">
                    <h3><?php echo e($category->name); ?></h3>
                    <a href="<?php echo e(route('pdf.concat.category', [$category->id, str_slug($category->name)])); ?>" 
                      class="icon-file"
                      target="_blank"
                      title="Projektdokumentationen <?php echo e($category->name); ?>">
                      <span>Alle <?php echo e($category->name); ?></span>
                    </a>
                    <?php $__currentLoopData = $category->activeTypes; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $type): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                      <?php if(array_key_exists($type->id, $types)): ?>
                        <?php if($category->show_types): ?>
                          <div class="download-group__item">
                            <h4><?php echo e($type->name_plural); ?></h4>
                            <?php $__currentLoopData = $type->activeProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($project->downloads): ?>
                                <?php $__currentLoopData = $project->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($file->name): ?>
                                    <div>
                                      <a href="<?php echo e(asset('storage/media/downloads/' . $file->name)); ?>" 
                                        class="icon-file"
                                        target="_blank"
                                        title="Projektdokumentation <?php echo e($project->name); ?>, <?php echo e($project->location); ?>">
                                        <span><?php echo e($project->name); ?>, <?php echo e($project->location); ?></span>
                                      </a>
                                    </div>
                                  <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                        <?php else: ?>
                          <div class="download-group__item">
                            <?php $__currentLoopData = $type->activeProjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <?php if($project->downloads): ?>
                                <?php $__currentLoopData = $project->downloads; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $file): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <?php if($file->name): ?>
                                    <div>
                                      <a href="<?php echo e(asset('storage/media/downloads/' . $file->name)); ?>" 
                                        class="icon-file"
                                        target="_blank"
                                        title="Projektdokumentation <?php echo e($project->name); ?>, <?php echo e($project->location); ?>">
                                        <span><?php echo e($project->name); ?>, <?php echo e($project->location); ?></span>
                                      </a>
                                    </div>
                                  <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              <?php endif; ?>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </div>
                        <?php endif; ?>
                      <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                <?php endif; ?>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        <?php endif; ?>
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Werkliste</h2>
        <div class="download-group has-offset">
        <div><a href="<?php echo e(route('pdf.works.all')); ?>" class="icon-file" target="_blank"><span>Gesamt</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.living')); ?>" class="icon-file" target="_blank"><span>Wohnen</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.business')); ?>" class="icon-file" target="_blank"><span>Gewerbe</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.public')); ?>" class="icon-file" target="_blank"><span>Öffentlich</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.competition')); ?>" class="icon-file" target="_blank"><span>Wettbewerb</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.state')); ?>" class="icon-file" target="_blank"><span>Nach Status</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.year')); ?>" class="icon-file" target="_blank"><span>Nach Jahr</span></a></div>
          <div><a href="<?php echo e(route('pdf.works.type')); ?>" class="icon-file" target="_blank"><span>Nach Typ</span></a></div>
        </div>
      </article>
    </div>
    <div class="span">
      <article>
        <h2>Jobs</h2>
        <?php if($jobs->isNotEmpty()): ?>
          <div class="download-group has-offset">
            <?php $__currentLoopData = $jobs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $j): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <div>
                <?php if($j->media): ?>
                  <a href="<?php echo e(asset('storage/media/downloads/' . $j->media)); ?>" 
                     class="icon-file"
                     target="_blank"
                     title="Ausschreibung <?php echo e($j->title); ?>">
                     <span><?php echo e($j->title); ?></span>
                  </a>
                <?php endif; ?>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </div>
        <?php else: ?>
          <p>Zur Zeit sind alle unsere Stellen besetzt.</p>
        <?php endif; ?>
      </article>
    </div>    
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/publications/downloads.blade.php ENDPATH**/ ?>