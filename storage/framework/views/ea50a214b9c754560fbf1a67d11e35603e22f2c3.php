<!doctype html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title><?php if(trim($__env->yieldContent('seo_title'))): ?><?php echo $__env->yieldContent('seo_title'); ?> - <?php echo e(config('seo.title')); ?><?php else: ?><?php echo e(config('seo.title')); ?><?php endif; ?></title>
<meta name="description" content="<?php if(trim($__env->yieldContent('seo_description'))): ?><?php echo $__env->yieldContent('seo_description'); ?><?php else: ?><?php echo e(config('seo.description')); ?><?php endif; ?>">
<meta property="og:title" content="<?php if(trim($__env->yieldContent('seo_title'))): ?><?php echo $__env->yieldContent('seo_title'); ?> - <?php echo e(config('seo.title')); ?><?php else: ?><?php echo e(config('seo.title')); ?><?php endif; ?>">
<meta property="og:description" content="<?php if(trim($__env->yieldContent('seo_description'))): ?><?php echo $__env->yieldContent('seo_description'); ?><?php else: ?><?php echo e(config('seo.description')); ?><?php endif; ?>">
<meta property="og:url" content="<?php echo e(url()->current()); ?>">
<meta property="og:image" content="<?php if(trim($__env->yieldContent('og_image'))): ?><?php echo $__env->yieldContent('og_image'); ?><?php else: ?><?php echo e(asset('assets/img/strut.ch-og.png')); ?><?php endif; ?>">
<meta property="og:site_name" content="<?php echo e(config('seo.title')); ?>">
<link rel="apple-touch-icon" sizes="180x180" href="/assets/img/favicon/apple-touch-icon.png">
<link rel="icon" type="image/png" sizes="32x32" href="/assets/img/favicon/favicon-32x32.png">
<link rel="icon" type="image/png" sizes="16x16" href="/assets/img/favicon/favicon-16x16.png">
<link rel="manifest" href="/assets/img/favicon/site.webmanifest">
<link rel="mask-icon" href="/assets/img/favicon/safari-pinned-tab.svg" color="#666666">
<link rel="shortcut icon" href="/assets/img/favicon/favicon.ico">
<meta name="msapplication-TileColor" content="#ffffff">
<meta name="msapplication-config" content="/assets/img/favicon/browserconfig.xml">
<meta name="theme-color" content="#ffffff">
<meta name="csrf-token" value="<?php echo e(csrf_token()); ?>" />
<meta name="format-detection" content="telephone=no">
<link href="<?php echo e(asset('assets/css/app.v9.css')); ?>" type="text/css" rel="stylesheet" />
<script src="<?php echo e(asset('assets/js/modernizr.min.js')); ?>"></script>
</head>
<body>
<header class="site-header">
  <div>
    <a href="javascript:;" class="icon-menu js-btn-menu" title="Menü anzeigen"></a>
    <a href="/" class="brand" title="Home | strut.ch">
      <img src="/assets/img/logo-strut.svg" height="161" width="313" alt="<?php echo e(config('app.name')); ?>">
    </a>
  </div>
  <nav class="site-nav js-menu" role="navigation">
    <div>
      <ul>
        <li>
          <a href="javascript:;" 
             class="js-btn-sub-menu is-parent <?php echo e(request()->routeIs('page.project*') ? 'is-active' : ''); ?>"
          >Bauten</a>
          <ul class="is-projects">
            <?php if(isset($menu['projects']['items'])): ?>
              <?php $__currentLoopData = $menu['projects']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $c): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                    <a href="javascript:;" 
                      class="js-btn-sub-menu <?php echo e($c['is-active'] ? 'is-active' : ''); ?>">
                      <?php echo e($c['name']); ?>

                    </a>
                    <?php if($c['show_types']): ?>
                      <ul>
                        <?php if(isset($c['types'])): ?>
                          <?php $__currentLoopData = $c['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                              <a href="javascript:;" 
                                class="js-btn-sub-menu <?php echo e($t['is-active'] ? 'is-active' : ''); ?>">
                                <?php echo e($t['name']); ?>

                              </a>
                              <ul class="has-indent">
                                <?php $__currentLoopData = $t['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                  <li>
                                    <a href="<?php echo e(url($p['route'] .'/'. $p['slug'])); ?>" 
                                      title="<?php echo e($p['name']); ?>"
                                      class="<?php echo e($p['is-active'] ? 'is-active' : ''); ?>"
                                    >
                                      <?php echo e($p['name']); ?>

                                    </a>
                                  </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                              </ul>
                            </li>
                          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                      </ul>
                    <?php else: ?>
                      <?php if(isset($c['types'])): ?>
                        <?php $__currentLoopData = $c['types']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $t): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <ul class="has-indent">
                            <?php $__currentLoopData = $t['projects']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <li>
                                <a href="<?php echo e(url($p['route'] .'/'. $p['slug'])); ?>" 
                                  title="<?php echo e($p['name']); ?>"
                                  class="<?php echo e($p['is-active'] ? 'is-active' : ''); ?>">
                                  <?php echo e($p['name']); ?>

                                </a>
                              </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                          </ul>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      <?php endif; ?>
                    <?php endif; ?>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            <?php endif; ?>   
          </ul>
        </li>
        <li>
          <a href="<?php echo e(route($menu['works']['route'])); ?>" 
            class="<?php echo e($menu['works']['is-active'] ? 'is-active' : ''); ?>"
            title="<?php echo e($menu['works']['name']); ?>">
            <?php echo e($menu['works']['name']); ?>

          </a>
        </li>                
        <li>
            <a href="javascript:;" class="js-btn-sub-menu is-parent <?php echo e($menu['publications']['is-active'] ? 'is-active' : ''); ?>">
              Publikationen
            </a>
            <?php if(!empty($menu['publications']['items'])): ?>
              <ul>
                <?php $__currentLoopData = $menu['publications']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <li>
                    <a href="<?php echo e(route($m['route'])); ?>"
                      class="<?php echo e($m['is-active'] ? 'is-active' : ''); ?>"
                      title="<?php echo e($m['name']); ?>">
                      <?php echo e($m['name']); ?>

                    </a>
                  </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </ul>
            <?php endif; ?>
        </li>
        <li>
          <a href="javascript:;" 
            class="js-btn-sub-menu is-parent <?php echo e($menu['about']['is-active'] ? 'is-active' : ''); ?>"
          >
            Büro
          </a>
          <?php if(!empty($menu['about']['items'])): ?>
            <ul>
              <?php $__currentLoopData = $menu['about']['items']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $m): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li>
                  <a href="<?php echo e(route($m['route'])); ?>"
                    class="<?php echo e($m['is-active'] ? 'is-active' : ''); ?>"
                    title="<?php echo e($m['name']); ?>">
                    <?php echo e($m['name']); ?>

                  </a>
                </li>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
          <?php endif; ?>
        </li>
        <li>
          <a href="<?php echo e(route($menu['contact']['route'])); ?>" 
            class="<?php echo e($menu['contact']['is-active'] ? 'is-active' : ''); ?>"
            title="<?php echo e($menu['contact']['name']); ?>">
            <?php echo e($menu['contact']['name']); ?>

          </a>
        </li>
      </ul>
    </div>
  </nav>
</header>
<main class="site-content <?php echo e(request()->routeIs('page.home') ? 'site-content--home' : ''); ?>" role="main">
  <div><?php echo $__env->yieldContent('content'); ?></div>
</main>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyD87zTe10NbK_liZzlO93W17qHiFVwlU8c"></script>
<script src="<?php echo e(asset('assets/js/app.v8.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/fancybox.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/imagesloaded.min.js')); ?>" type="text/javascript"></script>
<script src="<?php echo e(asset('assets/js/packery.min.js')); ?>" type="text/javascript"></script>
</body>
<!-- made with ❤ by marceli.to -->
</html><?php /**PATH /home/archit10/www/strut.ch/resources/views/web/layout/app.blade.php ENDPATH**/ ?>