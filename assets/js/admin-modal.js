/**
 * FAN HUB PLUS - REUSABLE MODAL ENGINE
 */
document.addEventListener("DOMContentLoaded", () => {
  // Modal Trigger Handlers
  document.addEventListener("click", (e) => {
    const trigger = e.target.closest("[data-modal-target]");
    if (trigger) {
      const targetId = trigger.getAttribute("data-modal-target");
      const modal = document.getElementById(targetId);
      if (modal) modal.classList.add("fh-modal-backdrop--active");
    }

    const dismissBtn = e.target.closest("[data-modal-dismiss]");
    if (dismissBtn) {
      const modal = dismissBtn.closest(".fh-modal-backdrop");
      if (modal) modal.classList.remove("fh-modal-backdrop--active");
    }
  });
});