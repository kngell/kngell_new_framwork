import Chartjs from '../chart/chartjs.js';

class DemoChartjs {
  constructor() {}

  init() {
    let chart = new Chartjs();
    chart.lineChart('line-chartjs');
    chart.doughnutChart('doughnut-chartjs');
    chart.progressBarChart('progress-bar-chartjs');
    chart.barChart('bar-chartjs');
  }
  
}

window.demoChartjs = new DemoChartjs();
window.demoChartjs.init();