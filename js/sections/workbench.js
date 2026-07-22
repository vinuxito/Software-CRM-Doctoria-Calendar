document.addEventListener('keydown', function (e) {
    // Alt + N: New Appointment
    if (e.altKey && (e.key === 'n' || e.key === 'N')) {
        e.preventDefault();
        var asideBtn = document.querySelector('.quick-appointment-box');
        if (asideBtn) asideBtn.scrollIntoView({ behavior: 'smooth' });
    }
    // Alt + P: Go to Patients
    if (e.altKey && (e.key === 'p' || e.key === 'P')) {
        e.preventDefault();
        var url = (window.URLROOT || '') + '/dashboard/patients';
        window.location.href = url;
    }
});
