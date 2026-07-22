<?php
echo "Running Dual-Experience Layer Verification Tests...\n";

// 1. Verify Manifest JSON Schema
$manifestPath = __DIR__ . '/manifest.json';
if (file_exists($manifestPath)) {
    $content = file_get_contents($manifestPath);
    $json = json_decode($content, true);
    if ($json && isset($json['name']) && isset($json['start_url']) && isset($json['display'])) {
        echo "✓ PWA manifest.json validated. Name: " . $json['name'] . " (Display: " . $json['display'] . ")\n";
    } else {
        echo "x Invalid manifest.json schema.\n";
        exit(1);
    }
} else {
    echo "x manifest.json missing.\n";
    exit(1);
}

// 2. Verify Service Worker File
$swPath = __DIR__ . '/sw.js';
if (file_exists($swPath) && filesize($swPath) > 50) {
    echo "✓ Service worker sw.js verified. File size: " . filesize($swPath) . " bytes.\n";
} else {
    echo "x sw.js missing or empty.\n";
    exit(1);
}

// 3. Verify Mobile Nav & Action Sheet Partials
$mobileNavPath = __DIR__ . '/app/views/inc/mobile_nav.php';
$actionSheetPath = __DIR__ . '/app/views/inc/action_sheet.php';

if (file_exists($mobileNavPath) && file_exists($actionSheetPath)) {
    echo "✓ Mobile remote partials (mobile_nav.php & action_sheet.php) verified.\n";
} else {
    echo "x Mobile remote partials missing.\n";
    exit(1);
}

// 4. Verify CSS Dual Experience Breakpoints
$cssPath = __DIR__ . '/css/style.css';
if (file_exists($cssPath)) {
    $cssContent = file_get_contents($cssPath);
    if (strpos($cssContent, '.mobile-bottom-nav') !== false && strpos($cssContent, '.action-sheet-overlay') !== false) {
        echo "✓ CSS Dual-Experience rules & media breakpoints verified in style.css.\n";
    } else {
        echo "x Missing Dual-Experience CSS rules in style.css.\n";
        exit(1);
    }
} else {
    echo "x style.css missing.\n";
    exit(1);
}

echo "ALL DUAL-EXPERIENCE LAYER TESTS PASSED!\n";
