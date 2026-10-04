// submission review — approve / reject
(function () {
  const approveBtn = document.getElementById('approveBtn');
  const rejectBtn = document.getElementById('rejectBtn');
  const note = document.getElementById('adminNote');

  approveBtn?.addEventListener('click', function () {
    // backend handoff: POST /admin/submissions/{id}/approve
    console.log('approve with note:', note?.value || '');
    window.location.href = 'fan-submissions.php';
  });

  rejectBtn?.addEventListener('click', function () {
    if (!confirm('Reject this submission? The user will be notified.')) return;
    // backend handoff: POST /admin/submissions/{id}/reject
    console.log('reject with note:', note?.value || '');
    window.location.href = 'fan-submissions.php';
  });
})();