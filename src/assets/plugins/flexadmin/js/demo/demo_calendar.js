import { Calendar } from "@fullcalendar/core";
import interactionPlugin, { Draggable } from "@fullcalendar/interaction";
import dayGridPlugin from "@fullcalendar/daygrid";
import timeGridPlugin from "@fullcalendar/timegrid";
import listPlugin from "@fullcalendar/list";

class DemoCalendar {
  constructor() {
    this.calendarEl = document.getElementById("demo-calendar");
    this.externalEventsContainer = document.getElementById(
      "calendar-external-events"
    );
    this.checkbox = document.getElementById("drop-remove");
    this.calendarObject = null;
    this.modal = $("#event-modal");
  }

  init = () => {
    let self = this;
    self._createNewExternalEvent();
    self._initExternalEvents();
    let date = new Date();
    let d = date.getDate();
    let m = date.getMonth();
    let y = date.getFullYear();
    new Draggable(self.externalEventsContainer, {
      itemSelector: ".external-event",
      eventData: function (eventEl) {
        return $(eventEl).data("event");
      },
    });
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
      droppable: true,
      drop: function (info) {
        if ($("#drop-remove").is(":checked")) {
          $(info.draggedEl).remove();
        }
      },
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

  _initExternalEvents = () => {
    $(this.externalEventsContainer)
      .children(".external-event")
      .each(function () {
        $(this).data("event", {
          title: $.trim($(this).text()),
          stick: true,
          classNames: [$(this).data("color-class")],
          description: [$(this).data("description")],
        });
      });
  };

  _createNewExternalEvent = () => {
    let self = this;
    $("#external-event-modal form")
      .unbind("submit")
      .on("submit", function (e) {
        e.preventDefault();
        let title = $("#external-event-title").val();
        let color = $("#external-event-color").val();
        let newExternalEvent = `<div class="external-event btn btn-${color} d-block mb-3 text-white text-start" data-color-class="bg-${color}" data-description="Lorem ipsum dolor amet ${color}">`;
        newExternalEvent += `<i class="fas fa-circle me-2"></i>${title}</div>`;
        $("#calendar-external-events").append(newExternalEvent);
        $("#external-event-modal").modal("hide");
        self._initExternalEvents();
        return false;
      });
  };
}

new DemoCalendar().init();
