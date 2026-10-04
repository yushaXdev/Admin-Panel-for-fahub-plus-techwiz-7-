/* =========================================================
   FAN HUB PLUS — DASHBOARD
   Chart.js powered. Backend dev will replace demo data.
   ========================================================= */
(function () {
  'use strict';

  if (typeof Chart === 'undefined') return;

  /* ---------- Theme tokens (sync with CSS) ---------- */
  const T = {
    text:      '#B6A9CE',
    textMuted: '#7C7099',
    grid:      'rgba(90,69,120,0.18)',
    surface:   '#121837',
    accent:    '#8237AC',
    accentDeep:'#691A82',
    indigo:    '#22217A',
  };

  Chart.defaults.font.family = "'Plus Jakarta Sans', system-ui, sans-serif";
  Chart.defaults.font.size   = 12;
  Chart.defaults.color       = T.text;

  /* ---------- 1. Platform Activity (line chart) ---------- */
  const activityEl = document.getElementById('activityChart');
  if (activityEl) {
    const ctx = activityEl.getContext('2d');

    const visitorsGrad = ctx.createLinearGradient(0, 0, 0, 260);
    visitorsGrad.addColorStop(0, 'rgba(130,55,172,0.35)');
    visitorsGrad.addColorStop(1, 'rgba(130,55,172,0)');

    const usersGrad = ctx.createLinearGradient(0, 0, 0, 260);
    usersGrad.addColorStop(0, 'rgba(34,33,122,0.55)');
    usersGrad.addColorStop(1, 'rgba(34,33,122,0)');

    new Chart(ctx, {
      type: 'line',
      data: {
        labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
        datasets: [
          {
            label: 'Visitors',
            data: [1240, 1580, 1420, 1890, 2100, 2450, 2280],
            borderColor: T.accent,
            backgroundColor: visitorsGrad,
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: T.accent,
            pointBorderColor: '#161931',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
          },
          {
            label: 'Registered users',
            data: [420, 510, 480, 640, 720, 880, 810],
            borderColor: '#5A4578',
            backgroundColor: usersGrad,
            borderWidth: 2.5,
            tension: 0.4,
            fill: true,
            pointBackgroundColor: '#5A4578',
            pointBorderColor: '#161931',
            pointBorderWidth: 2,
            pointRadius: 4,
            pointHoverRadius: 6,
          },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        interaction: { intersect: false, mode: 'index' },
        plugins: {
          legend: {
            position: 'top',
            align: 'end',
            labels: {
              boxWidth: 8,
              boxHeight: 8,
              usePointStyle: true,
              pointStyle: 'circle',
              padding: 16,
              color: T.text,
              font: { size: 11.5, weight: '500' },
            },
          },
          tooltip: {
            backgroundColor: '#1A1C59',
            borderColor: '#452454',
            borderWidth: 1,
            titleColor: '#EDE9F5',
            bodyColor: '#B6A9CE',
            padding: 12,
            cornerRadius: 8,
            displayColors: true,
            boxPadding: 4,
          },
        },
        scales: {
          x: {
            grid: { display: false },
            border: { display: false },
            ticks: { color: T.textMuted, font: { size: 11 } },
          },
          y: {
            beginAtZero: true,
            grid: { color: T.grid, drawTicks: false },
            border: { display: false },
            ticks: {
              color: T.textMuted,
              font: { size: 11 },
              padding: 8,
              callback: (v) => v >= 1000 ? (v / 1000) + 'K' : v,
            },
          },
        },
      },
    });
  }

  /* ---------- 2. Category Distribution (doughnut) ---------- */
  const catEl = document.getElementById('categoryChart');
  if (catEl) {
    const ctx = catEl.getContext('2d');

    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: ['Anime', 'Gaming', 'Movies', 'TV Shows', 'K-Pop', 'Comics', 'Manga', 'Cosplay'],
        datasets: [{
          data: [218, 176, 142, 98, 87, 64, 51, 28],
          backgroundColor: [
            '#E85D3D', // anime
            '#7B5FA8', // gaming
            '#8237AC', // movies
            '#22217A', // tv
            '#D96FA0', // kpop
            '#E8A33D', // comics
            '#5A4578', // manga
            '#653C9E', // cosplay
          ],
          borderColor: '#121837',
          borderWidth: 3,
          hoverOffset: 6,
        }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        cutout: '68%',
        plugins: {
          legend: {
            position: 'right',
            labels: {
              boxWidth: 8,
              boxHeight: 8,
              usePointStyle: true,
              pointStyle: 'circle',
              padding: 12,
              color: T.text,
              font: { size: 11.5, weight: '500' },
            },
          },
          tooltip: {
            backgroundColor: '#1A1C59',
            borderColor: '#452454',
            borderWidth: 1,
            titleColor: '#EDE9F5',
            bodyColor: '#B6A9CE',
            padding: 12,
            cornerRadius: 8,
            callbacks: {
              label: (c) => ` ${c.label}: ${c.parsed} items`,
            },
          },
        },
      },
    });
  }

  /* ---------- 3. Range tabs (visual only) ---------- */
  document.querySelectorAll('.panel-tabs .tab').forEach((tab) => {
    tab.addEventListener('click', function () {
      this.parentElement.querySelectorAll('.tab').forEach((t) => t.classList.remove('is-active'));
      this.classList.add('is-active');
      // Backend dev will refetch chart data based on this.dataset.range
    });
  });

})();