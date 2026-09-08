

<?php $__env->startSection('title', 'Calendario'); ?>

<?php $__env->startSection('breadcrumb'); ?>
  <li class="breadcrumb-item"><a href="<?php echo e(route('todo.index')); ?>">Tareas</a></li>
  <li class="breadcrumb-item active">Calendario</li>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page_title', 'Calendario de tareas'); ?>

<?php $__env->startSection('page_actions'); ?>
  <a href="<?php echo e(route('todo.create')); ?>" class="btn btn-primary btn-sm">
    <i class="fas fa-plus mr-1"></i> Nueva tarea
  </a>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
  <?php
    $tareasCollection = collect($tareas);
    $today = \Carbon\Carbon::today();
    $upcoming = $tareasCollection->sortBy('fechaLimite')->take(5);
    $hoyCount = $tareasCollection->filter(function ($tarea) use ($today) {
      return \Carbon\Carbon::parse($tarea->fechaLimite)->isSameDay($today);
    })->count();
    $vencidasCount = $tareasCollection->filter(function ($tarea) use ($today) {
      return \Carbon\Carbon::parse($tarea->fechaLimite)->lt($today);
    })->count();
  ?>

  <div class="container-fluid px-3">
    <div class="card border-0 shadow-sm overflow-hidden mb-3">
      <div class="card-body py-4" style="background: linear-gradient(135deg, #0f172a, #2563eb); color: #ffffff;">
        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
          <div>
            <p class="text-uppercase small mb-2" style="letter-spacing:.14em; opacity:.75;">Vista semanal</p>
            <h2 class="h4 font-weight-bold mb-1">Planifica seguimientos con contexto temporal</h2>
            <p class="mb-0" style="opacity:.82; max-width:44rem;">Consulta vencimientos, compromisos del día y próximas tareas desde una agenda visual orientada a operación comercial.</p>
          </div>
          <div class="d-flex flex-wrap gap-2">
            <span class="badge badge-light px-3 py-2"><?php echo e(count($eventos)); ?> eventos</span>
            <span class="badge badge-warning px-3 py-2"><?php echo e($hoyCount); ?> hoy</span>
            <span class="badge badge-danger px-3 py-2"><?php echo e($vencidasCount); ?> vencidas</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-xl-8 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-3 p-lg-4">
            <div id="calendar"></div>
          </div>
        </div>
      </div>
      <div class="col-12 col-xl-4 mb-3">
        <div class="card border-0 shadow-sm h-100">
          <div class="card-body p-4">
            <h3 class="h5 font-weight-bold mb-3">Próximos compromisos</h3>
            <?php $__empty_1 = true; $__currentLoopData = $upcoming; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tarea): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
              <div class="border rounded px-3 py-3 mb-3" style="background:#f8fafc;">
                <div class="d-flex align-items-start justify-content-between gap-2">
                  <div>
                    <div class="font-weight-bold text-dark"><?php echo e($tarea->nombre); ?></div>
                    <div class="small text-muted"><?php echo e($tarea->cliente ?: 'Sin cliente'); ?></div>
                  </div>
                  <span class="badge badge-light border"><?php echo e($tarea->todo_tipo); ?></span>
                </div>
                <div class="small text-muted mt-2"><?php echo e(\Carbon\Carbon::parse($tarea->fechaLimite)->format('d/m/Y h:i A')); ?></div>
              </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
              <div class="text-center py-4">
                <i class="fas fa-calendar-day text-muted mb-3" style="font-size: 1.8rem;"></i>
                <p class="text-muted mb-0">No hay tareas pendientes para mostrar.</p>
              </div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('js'); ?>
  <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.14/index.global.min.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      var calendarEl = document.getElementById('calendar');

      if (!calendarEl) {
        return;
      }

      var calendar = new FullCalendar.Calendar(calendarEl, {
        events: <?php echo json_encode($eventos, 15, 512) ?>,
        initialView: window.innerWidth < 768 ? 'listWeek' : 'timeGridWeek',
        slotMinTime: '08:00:00',
        locale: 'es',
        headerToolbar: {
          left: 'prev,next today',
          center: 'title',
          right: 'dayGridMonth,timeGridWeek,listWeek'
        },
        height: 'auto',
        firstDay: 1,
        eventTimeFormat: {
          hour: 'numeric',
          minute: '2-digit',
          meridiem: 'short'
        },
        slotLabelFormat: {
          hour: 'numeric',
          minute: '2-digit',
          hour12: true
        }
      });

      calendar.render();
    });
  </script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layoutadmin', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH D:\xampp3\htdocs\realestate_dev\resources\views\admin\todos\calendario.blade.php ENDPATH**/ ?>