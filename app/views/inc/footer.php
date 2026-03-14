    <?php $layoutFull = isset($data['layout_full']) ? $data['layout_full'] : false; ?>
    <?php if (!$layoutFull) : ?>
        </div>
    <?php endif; ?>

    <!-- Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <!-- FullCalendar JS -->
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.js'></script>
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/locales/es.js'></script>
    <!-- Custom JS -->
    <script src="<?php echo URLROOT; ?>/js/main.js"></script>
</body>
</html>
