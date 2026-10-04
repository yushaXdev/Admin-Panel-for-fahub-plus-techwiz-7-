// feedback detail — resolve / reopen / delete
(function () {
  const reply = document.getElementById('adminReply');

  document.getElementById('resolveBtn')?.addEventListener('click', function () {
    // backend handoff: POST /admin/feedback/{id}/resolve
    console.log('resolve with reply:', reply?.value || '');
    window.location.href = 'feedback.php';
  });

  document.getElementById('reopenBtn')?.addEventListener('click', function () {
    // backend handoff: POST /admin/feedback/{id}/reopen
    console.log('reopen');
    window.location.href = 'feedback.php';
  });

  document.getElementById('deleteBtn')?.addEventListener('click', function () {
    if (!confirm('Delete this feedback? This cannot be undone.')) return;
    // backend handoff: DELETE /admin/feedback/{id}
    console.log('delete');
    window.location.href = 'feedback.php';
  });
})();