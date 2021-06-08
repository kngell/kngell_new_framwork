import { Calendar } from "@fullcalendar/core";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";
import Chartjs from "./chart/chartjs.js";
import "plugins/modules/jqvmap/jquery.vmap.min.js";
import "plugins/modules/jqvmap/maps/jquery.vmap.world.js";

class DemoDashboardAnalytics {
  constructor() {
    this.calendarEl = document.getElementById("demo-calendar");
    this.calendarObject = null;
  }

  init() {
    this._applyChart();
    this._applyCalendar();
    this._applyBrowserUsageChart();
    this._applySessionsOverviewChart();
    this._applyMap();
  }

  _applyChart = () => {
    let chart = new Chartjs();
    chart.barChart("dashboard-bar-chartjs");
  };

  _applySessionsOverviewChart = () => {
    let ctx = document
      .getElementById("analytics-session-overview")
      .getContext("2d");
    let gradient = ctx.createLinearGradient(0, 0, 0, 225);
    gradient.addColorStop(0, "rgba(13, 198, 253, 1)");
    gradient.addColorStop(1, "rgba(13, 198, 253, 0)");
    new Chart(document.getElementById("analytics-session-overview"), {
      type: "line",
      data: {
        labels: [
          "Jan",
          "Feb",
          "Mar",
          "Apr",
          "May",
          "Jun",
          "Jul",
          "Aug",
          "Sep",
          "Oct",
          "Nov",
          "Dec",
        ],
        datasets: [
          {
            label: "Sales ($)",
            fill: true,
            backgroundColor: gradient,
            borderColor: window.colors.green,
            data: [211, 156, 258, 189, 158, 392, 556, 144, 280, 743, 191, 332],
          },
        ],
      },
      options: {
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        hover: {
          intersect: true,
        },
        scales: {
          xAxes: [
            {
              reverse: true,
              gridLines: {
                color: "rgba(0,0,0,0.0)",
              },
            },
          ],
          yAxes: [
            {
              ticks: {
                stepSize: 100,
              },
              display: true,
              borderDash: [2, 2],
              gridLines: {
                color: "rgba(0,0,0,0.0)",
              },
            },
          ],
        },
      },
    });
  };

  _applyBrowserUsageChart = () => {
    new Chart(document.getElementById("analytics-browser-usage"), {
      type: "pie",
      data: {
        labels: ["Chrome", "Firefox", "IE"],
        datasets: [
          {
            data: [2398, 1359, 254],
            backgroundColor: [
              window.colors.blue,
              window.colors.yellow,
              window.colors.red,
            ],
            borderWidth: 5,
          },
        ],
      },
      options: {
        responsive: !window.MSInputMethodContext,
        maintainAspectRatio: false,
        legend: {
          display: false,
        },
        cutoutPercentage: 75,
      },
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

  _applyCalendar = () => {
    let self = this;
    let date = new Date();
    let d = date.getDate();
    let m = date.getMonth();
    let y = date.getFullYear();

    this.calendarObject = new Calendar(this.calendarEl, {
      plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
      header: {
        left: "prev,next today",
        center: "title",
        right: "dayGridMonth,timeGridWeek,timeGridDay,listWeek",
      },
      navLinks: true, // can click day/week names to navigate views
      editable: true,
      eventLimit: true, // allow "more" link when too many events
      events: this._defaultEvent(),
    });
    document.addEventListener("DOMContentLoaded", function () {
      self.calendarObject.render();
    });
  };

  _defaultEvent = () => {
    let form = "";
    let today = new Date($.now());
    let defaultEvents = [
      {
        title: "All Day Event",
        start: new Date($.now()),
        className: "bg-warning",
      },
      {
        title: "Lunch",
        start: new Date($.now() + 24 * 60 * 60 * 1000),
        className: "bg-warning",
      },
      {
        title: "Meeting",
        start: new Date($.now() + 4 * 24 * 60 * 60 * 1000),
        className: "bg-success",
      },
      {
        title: "Happy Hour",
        start: new Date($.now() + 8 * 24 * 60 * 60 * 1000),
        className: "bg-warning",
      },
      {
        title: "Dinner",
        start: new Date($.now() + 13 * 24 * 60 * 60 * 1000),
        className: "bg-info",
      },
      {
        title: "Birthday Party",
        start: new Date($.now() + 15 * 24 * 60 * 60 * 1000),
        className: "bg-success",
      },
      {
        title: "Click for Homepage",
        url: "/",
        start: new Date($.now() + 16 * 24 * 60 * 60 * 1000),
        className: "bg-danger",
      },
    ];
    return defaultEvents;
  };
}

new DemoDashboardAnalytics().init();
