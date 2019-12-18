<?php $__env->startSection('seo_title', 'Werkliste'); ?>
<?php $__env->startSection('seo_description', 'Strut Architekten AG entwickelt und plant anspruchsvolle Wohn- und Gewerbebauten. Das Büro kann auf erfolgreiche Projekte und mehr als 20-jährige Erfahrungen zurückgreifen.'); ?>
<?php $__env->startSection('content'); ?>
<section class="content works">
  <?php echo $__env->make('web.pages.works.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
  <div class="works-list">
    <?php if(isset($projects['Ausgeführt'])): ?>
      <div class="span">
        <article class="work-group">
          <h2>Ausgeführt</h2>
          <?php $__currentLoopData = $projects['Ausgeführt']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
             <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </article>
      </div>
    <?php endif; ?>
    <?php if(isset($projects['In Planung']) || isset($projects['Studie'])): ?>
      <div class="span">
        <?php if(isset($projects['In Planung'])): ?>
          <article class="work-group">
            <h2>In Planung</h2>
            <?php $__currentLoopData = $projects['In Planung']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </article>
        <?php endif; ?>
        <?php if(isset($projects['Studie'])): ?>
          <article class="work-group">
            <h2>Studie</h2>
            <?php $__currentLoopData = $projects['Studie']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
              <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
          </article>
        <?php endif; ?>
      </div>
    <?php endif; ?>

    <?php if(isset($competition['1. Preis']) || isset($competition['2. Preis']) || isset($competition['Andere'])): ?>
      <div class="span">
        <article class="is-competition">
          <h2>Wettbewerb</h2>
          <?php if(isset($competition['1. Preis'])): ?>
            <article class="work-group">
              <div class="article">
                <h3>1. Preis</h3>
                <?php $__currentLoopData = $competition['1. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </article>
          <?php endif; ?>
          <?php if(isset($competition['2. Preis'])): ?>
            <article class="work-group is-competition">
              <div class="article">
                <h3>2. Preis</h3>
                <?php $__currentLoopData = $competition['2. Preis']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </article>
          <?php endif; ?>
          <?php if(isset($competition['Andere'])): ?>
            <article class="work-group is-competition">
              <div class="article">
                <h3>Andere</h3>
                <?php $__currentLoopData = $competition['Andere']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $project): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php echo $__env->make('web.pages.works.partials.item', array('project' => $project, 'image_by' => 'status'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </div>
            </article>
          <?php endif; ?>      
        </article>      
      </div> 
    <?php endif; ?>   
  </div>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('web.layout.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Users/marceli.to/Jamon.digital/Webroot/strut.ch/resources/views/web/pages/works/state.blade.php ENDPATH**/ ?>