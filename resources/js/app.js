
import './bootstrap';
import 'vanilla-toast/vanilla-toast.css';
import toast from 'vanilla-toast';

import Chart from 'chart.js/auto';

const charts = {};

function crearGrafico(canvasId, tipo, labels, values, titulo, borderColor, bgColor) {
  const ctx = document.getElementById(canvasId);

  if (ctx) {
    if (charts[canvasId] && typeof charts[canvasId].destroy === 'function') {
      charts[canvasId].destroy();
    }

    charts[canvasId] = new Chart(ctx, {
      type: tipo,
      data: {
        labels: labels,
        datasets: [{
          label: titulo,
          data: values,
          backgroundColor: Array.isArray(bgColor) ? bgColor : bgColor,
          borderColor: Array.isArray(borderColor) ? borderColor : borderColor,
          borderWidth: 1
        }]
      },
      options: {
        responsive: true,
        scales: {
          y: {
            beginAtZero: true
          }
        }
      }
    });
  }
} 

document.addEventListener('DOMContentLoaded', function () {
    Livewire.on('chart-updated', (event) => {
        const { id, datos } = event;
        crearGrafico(
            datos.canvasId,
            datos.tipo,
            datos.labels,
            datos.values,
            datos.titulo,
            datos.borderColor,
            datos.bgColor
        );
    });
});

  setInterval(showNotyToast, 1000);


/*const toastInterval = setInterval(() => {
    toast.show('sunshine' , {
        duration : 2000, fadeDuration:1000 , closeButton:false
    });
}, 5000); */ 
