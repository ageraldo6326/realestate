

<?php $__env->startSection('seo_title', 'Novedades — ' . ($inmo->titulo ?? 'Portal Inmobiliario')); ?>
<?php $__env->startSection('seo_description', 'Lee las últimas noticias y artículos sobre el mercado inmobiliario.'); ?>

<?php $__env->startSection('extra_styles'); ?>
    <style>
        .page-hero {
            background: linear-gradient(135deg, var(--clr-dark) 0%, var(--clr-dark-2) 100%);
            padding: 3rem 0 2.5rem;
        }

        .page-hero .page-hero-title {
            font-family: var(--ff-head);
            font-size: clamp(1.8rem, 4vw, 2.4rem);
            color: var(--clr-white);
            font-weight: 700;
            margin-bottom: .5rem;
        }

        .page-hero .breadcrumb {
            background: transparent;
            padding: 0;
            margin: 0;
            font-size: .85rem;
        }

        .page-hero .breadcrumb-item a {
            color: var(--clr-accent);
            text-decoration: none;
        }

        .page-hero .breadcrumb-item.active {
            color: rgba(255, 255, 255, .7);
        }

        .page-hero .breadcrumb-item+.breadcrumb-item::before {
            color: rgba(255, 255, 255, .4);
        }

        .blog-section {
            padding: 4rem 0;
            background: var(--clr-bg);
        }

        .blog-card {
            background: var(--clr-white);
            border-radius: var(--radius);
            border: 1px solid var(--clr-border);
            box-shadow: var(--shadow-sm);
            transition: var(--transition);
            overflow: hidden;
            height: 100%;
            display: flex;
            flex-direction: column;
        }

        .blog-card:hover {
            box-shadow: var(--shadow-lg);
            transform: translateY(-4px);
        }

        .blog-body {
            padding: 1.5rem;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .blog-date {
            font-size: .75rem;
            color: var(--clr-gray-lt);
            margin-bottom: .75rem;
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        .blog-title {
            font-family: var(--ff-head);
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--clr-dark);
            margin-bottom: .75rem;
            line-height: 1.4;
        }

        .blog-title a {
            color: inherit;
            text-decoration: none;
            transition: color .2s;
        }

        .blog-title a:hover {
            color: var(--clr-accent);
        }

        .blog-excerpt {
            font-size: .875rem;
            color: var(--clr-gray);
            line-height: 1.7;
            flex: 1;
        }

        .blog-footer {
            padding: 1rem 1.5rem;
            border-top: 1px solid var(--clr-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .blog-author {
            font-size: .78rem;
            color: var(--clr-gray);
        }

        .blog-author span {
            font-weight: 600;
            color: var(--clr-dark);
        }

        .btn-read-more {
            font-size: .8rem;
            font-weight: 600;
            color: var(--clr-accent);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .3rem;
            transition: gap .2s;
        }

        .btn-read-more:hover {
            gap: .6rem;
            color: var(--clr-accent);
        }

        .pagination .page-link {
            color: var(--clr-dark);
            border-radius: var(--radius-sm) !important;
            margin: 0 2px;
            border: 1.5px solid var(--clr-border);
            font-size: .85rem;
        }

        .pagination .page-item.active .page-link {
            background: var(--clr-accent);
            border-color: var(--clr-accent);
            color: var(--clr-dark);
            font-weight: 600;
        }

        .pagination .page-link:hover {
            background: var(--clr-bg);
            color: var(--clr-accent);
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

    <section class="page-hero" aria-label="Novedades">
        <div class="container">
            <h1 class="page-hero-title">Novedades</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('home')); ?>">Inicio</a></li>
                    <li class="breadcrumb-item active">Novedades</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="blog-section">
        <div class="container">
            <div class="text-center mb-5">
                <span class="section-badge">BLOG</span>
                <h2 class="section-title">Últimas Noticias</h2>
                <p class="section-subtitle">Mantente informado sobre el mercado inmobiliario y nuestras novedades.</p>
            </div>

            <div class="row g-4">
                <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-lg-4 col-md-6">
                        <article class="blog-card">
                            <div class="blog-body">
                                <div class="blog-date">
                                    <i class="far fa-calendar-alt"></i>
                                    <time
                                        datetime="<?php echo e($post->created_at->format('Y-m-d')); ?>"><?php echo e($post->created_at->format('d/m/Y')); ?></time>
                                </div>
                                <h2 class="blog-title">
                                    <a href="<?php echo e(route('post.show', $post->slug)); ?>"><?php echo e($post->titulo); ?></a>
                                </h2>
                                <p class="blog-excerpt"><?php echo Str::limit(strip_tags($post->contenido), 160); ?></p>
                            </div>
                            <div class="blog-footer">
                                <p class="blog-author mb-0">Por: <span><?php echo e($post->autor); ?></span></p>
                                <a href="<?php echo e(route('post.show', $post->slug)); ?>" class="btn-read-more">
                                    Leer más <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <div class="col-12 text-center py-5">
                        <i class="fas fa-newspaper fa-3x text-accent mb-3 d-block"></i>
                        <p class="text-muted">No hay artículos publicados aún.</p>
                    </div>
                <?php endif; ?>
            </div>

            <?php if($posts->hasPages()): ?>
                <div class="d-flex justify-content-center mt-5">
                    <?php echo e($posts->links('pagination::bootstrap-4')); ?>

                </div>
            <?php endif; ?>
        </div>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layout.layout-landing', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\frontend\blog.blade.php ENDPATH**/ ?>