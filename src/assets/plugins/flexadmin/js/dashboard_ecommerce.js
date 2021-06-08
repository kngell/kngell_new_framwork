import "plugins/modules/jqvmap/jquery.vmap";
import "plugins/modules/jqvmap/maps/jquery.vmap.world.js";
import Chartjs from "./chart/chartjs.js";

class DemoDashboardEcommerce {
  init() {
    this._applyChart();
    this._applyDataTable();
    this._applyMap();
  }

  _applyChart = () => {
    let chart = new Chartjs();
    chart.lineChart("dashboard-line-chartjs");
    chart.doughnutChart("dashboard-doughnut-chartjs");
    chart.progressBarChart("dashboard-progress-bar-chartjs");
    chart.barChart("dashboard-bar-chartjs");
  };

  _applyDataTable = () => {
    let element = document.getElementById("ecommerce-datatable");
    if (!element) return false;
    let table = $(element).DataTable({
      responsive: true,
      pageLength: 10,
      order: [],
      columnDefs: [
        {
          targets: "no-sort",
          orderable: false,
        },
      ],
    });
  };

  _applyMap = () => {
    var activeColor = window.colors.blue;
    var selectedCountries = ["us", "ru"];
    var colors = { us: activeColor, ru: activeColor, au: activeColor };
    $("#world_map").vectorMap({
      map: "world_en",
      backgroundColor: "transparent",
      borderColor: "#818181",
      borderOpacity: 0.25,
      borderWidth: 1,
      color: window.colors.gray,
      enableZoom: true,
      hoverColor: "#ccc",
      hoverOpacity: null,
      normalizeFunction: "linear",
      scaleColors: ["#b6d6ff", "#005ace"],
      selectedColor: "#c9dfaf",
      selectedRegions: null,
      showTooltip: true,
      colors: colors,
      hoverOpacity: 0.7,
    });
  };
}

new DemoDashboardEcommerce().init();
