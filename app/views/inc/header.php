<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo SITENAME; ?></title>
    <meta name="urlroot" content="<?php echo URLROOT; ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Outfit:wght@400;500;600;700&family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- FullCalendar CSS -->
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@5.11.0/main.min.css' rel='stylesheet' />
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/style.css">
</head>
<body class="<?php echo isset($data['body_class']) ? $data['body_class'] : ''; ?>">
    <?php $hideNavbar = isset($data['hide_navbar']) ? $data['hide_navbar'] : false; ?>
    <?php $layoutFull = isset($data['layout_full']) ? $data['layout_full'] : false; ?>
    <?php if (!$hideNavbar) : ?>
        <?php require APPROOT . '/views/inc/navbar.php'; ?>
    <?php endif; ?>
    <?php if (!$layoutFull) : ?>
        <div class="container-fluid">
    <?php endif; ?>
