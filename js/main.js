// Doctoria CRM — Global Utilities
'use strict';

/**
 * URL root for AJAX calls — injected by PHP in header metadata
 * Falls back to auto-detection from current URL
 */
window.URLROOT = document.querySelector('meta[name="urlroot"]')
    ? document.querySelector('meta[name="urlroot"]').content
    : window.location.origin + '/naxielly';

console.log('CRM Loaded, URLROOT:', window.URLROOT);
