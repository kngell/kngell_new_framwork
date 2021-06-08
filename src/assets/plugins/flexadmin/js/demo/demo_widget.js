import Chartjs from '../chart/chartjs.js';

class DemoWidget {
  init() {
    $(document).ready(function () {
      let chart = new Chartjs();
      chart.barChart('widget-bar-chartjs-1');
      chart.barChart('widget-bar-chartjs-2');
      chart.barChart('widget-bar-chartjs-3');
    });
  }
}

window.demoWidget = new DemoWidget();
window.demoWidget.init();
