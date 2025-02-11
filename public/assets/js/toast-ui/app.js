/* eslint-disable no-var,prefer-destructuring,prefer-template,no-undef,object-shorthand,no-console */
// for testing IE11 compatibility, this file doesn't use ES6 syntax.
class CalendarInit {

  constructor(events, calendars, projects){
    var cal;
    this.calendars = calendars;
    this.projects = projects;
    // Constants
    // var CALENDAR_CSS_PREFIX = 'toastui-calendar-';
    // var cls = function (className) {
    //   return CALENDAR_CSS_PREFIX + className;
    // };
  
    this.events = events;
  
    // Elements
    this.navbarRange = $('.tui-calendar-event .tui-navbar--range');
    this.prevButton = $('.tui-calendar-event .prev');
    this.nextButton = $('.tui-calendar-event .next');
    this.todayButton = $('.tui-calendar-event .today');
    this.dropdown = $('.tui-calendar-event .dropdown');
    this.dropdownTrigger = $('.tui-calendar-event .dropdown-toggle');
    // var dropdownTriggerIcon = $('.tui-calendar-event .dropdown-icon');
    this.dropdownContent = $('.tui-calendar-event .dropdown-menu');
    this.checkboxCollapse = $('.tui-calendar-event .checkbox-collapse');
    this.sidebar = $('.tui-calendar-event .tui-sidebar');
  
    // App State
    this.appState = {
      activeCalendarIds: MOCK_CALENDARS.map(function (calendar) {
        return calendar.id;
      }),
      isDropdownActive: false,
    };

    this.init();
    return {tui_calendar: this.tui_calendar, calendar: this};
  }
  

  // functions to handle calendar behaviors
  reloadEvents() {
    // var randomEvents;

    this.tui_calendar.clear();
    // randomEvents = generateRandomEvents(
    //   cal.getViewName(),
    //   cal.getDateRangeStart(),
    //   cal.getDateRangeEnd()
    // );
    
    // console.log(randomEvents);
    // console.log(events)
    this.tui_calendar.createEvents(this.events);
  }

  getReadableViewName(viewType) {
    switch (viewType) {
      case 'month':
        return 'Mensuelle';
      case 'week':
        return 'Chaque semaine';
      case 'day':
        return 'Journalier';
      default:
        throw new Error('no view type');
    }
  }

  displayRenderRange() {
    var rangeStart = this.tui_calendar.getDateRangeStart();
    var rangeEnd = this.tui_calendar.getDateRangeEnd();

    // navbarRange.textContent = getNavbarRange(cal.getDateRangeStart(), cal.getDateRangeEnd(), 'month');
    this.navbarRange.textContent = getNavbarRange(rangeStart, rangeEnd, this.tui_calendar.getViewName());
  }

  setDropdownTriggerText() {
    var viewName = this.tui_calendar.getViewName();
    var buttonText = $('.dropdown .button-text');
    buttonText.textContent = this.getReadableViewName(viewName);
  }

  toggleDropdownState(self) {
    self.appState.isDropdownActive = !self.appState.isDropdownActive;
    self.dropdown.classList.toggle('is-active', self.appState.isDropdownActive);
    // dropdownTriggerIcon.classList.toggle(cls('open'), appState.isDropdownActive);
  }

  setAllCheckboxes(checked) {
    var checkboxes = $('.sidebar-item > input[type="checkbox"]');

    checkboxes.forEach(function (checkbox) {
      checkbox.checked = checked;
      this.setCheckboxBackgroundColor(checkbox);
    });
  }



  update() {
    this.setDropdownTriggerText();
    this.displayRenderRange();
    this.reloadEvents();
  }

  bindAppEvents() {
    const self = this;
    this.dropdownTrigger.addEventListener('click', this.toggleDropdownState(self));

    this.prevButton.addEventListener('click', function () {
      self.tui_calendar.prev();
      self.update();
    });

    this.nextButton.addEventListener('click', function () {
      self.tui_calendar.next();
      self.update();
    });

    this.todayButton.addEventListener('click', function () {
      self.tui_calendar.today();
      self.update();
    });

    this.dropdownContent.addEventListener('click', function (e) {
      var targetViewName;

      if ('viewName' in e.target.dataset) {
        targetViewName = e.target.dataset.viewName;
        self.tui_calendar.changeView(targetViewName);
        console.log(self.checkboxCollapse)
        console.log(self)
        // self.checkboxCollapse.disabled = targetViewName === 'month';
        self.toggleDropdownState(self);
        self.update();
      }
    });

    this.checkboxCollapse?.addEventListener('change', function (e) {
      if ('checked' in e.target) {
        self.tui_calendar.setOptions({
          week: {
            collapseDuplicateEvents: !!e.target.checked,
          },
          useDetailPopup: !e.target.checked,
        });
      }
    });

    this.sidebar.addEventListener('click', function (e) {
      if ('value' in e.target) {
        if (e.target.value === 'all') {
          // console.log(appState.activeCalendarIds);
          if (self.appState.activeCalendarIds.length > 0) {
            self.tui_calendar.setCalendarVisibility(self.appState.activeCalendarIds, false);
            self.appState.activeCalendarIds = [];
            self.setAllCheckboxes(false);
          } else {
            self.appState.activeCalendarIds = MOCK_CALENDARS.map(function (calendar) {
              return calendar.id;
            });
            self.tui_calendar.setCalendarVisibility(self.appState.activeCalendarIds, self);
            self.setAllCheckboxes(true);
          }
        } else if (self.appState.activeCalendarIds.indexOf(e.target.value) > -1) {
          self.appState.activeCalendarIds.splice(self.appState.activeCalendarIds.indexOf(e.target.value), 1);
          self.tui_calendar.setCalendarVisibility(e.target.value, false);
          self.setCheckboxBackgroundColor(e.target);
        } else {
          self.appState.activeCalendarIds.push(e.target.value);
          self.tui_calendar.setCalendarVisibility(e.target.value, true);
          self.setCheckboxBackgroundColor(e.target);
        }
      }
    });
  }

  bindInstanceEvents() {
    const self = this;
    this.tui_calendar.on({
      clickMoreEventsBtn: function (btnInfo) {
        console.log('clickMoreEventsBtn', btnInfo);
      },
      clickEvent: function (eventInfo) {
        console.log('clickEvent', eventInfo);
      },
      clickDayName: function (dayNameInfo) {
        console.log('clickDayName', dayNameInfo);
      },
      selectDateTime: function (dateTimeInfo) {
        console.log('selectDateTime', dateTimeInfo);
      },
      beforeCreateEvent: function (event) {
        console.log('beforeCreateEvent', event);
        event.id = chance.guid();

        self.tui_calendar.createEvents([event]);
        self.tui_calendar.clearGridSelections();
      },
      beforeUpdateEvent: function (eventInfo) {
        var event, changes;

        console.log('beforeUpdateEvent', eventInfo);

        event = eventInfo.event;
        changes = eventInfo.changes;

        self.tui_calendar.updateEvent(event.id, event.calendarId, changes);
      },
      beforeDeleteEvent: function (eventInfo) {
        console.log('beforeDeleteEvent', eventInfo);

        self.tui_calendar.deleteEvent(eventInfo.id, eventInfo.calendarId);
      },
    });
  }

  setCheckboxBackgroundColor(checkbox) {
    console.log(checkbox);
    // return true;
    var calendarId = checkbox.value;
    var label = checkbox.nextElementSibling;
    var calendarInfo = this.calendars.find(function (calendar) {
      return calendar.id === calendarId;
    });

    if (!calendarInfo) {
      calendarInfo = {
        backgroundcalColor: '#2a4fa7',
      };
    }

    label.style.setProperty(
      '--checkbox-' + calendarId,
      checkbox.checked ? calendarInfo.backgroundColor : '#fff'
    );
  }

  initCheckbox() {
    // {
    //   id: '1',
    //   name: 'Projects 1',
    //   color: '#ffffff',
    //   borderColor: '#9e5fff',
    //   backgroundColor: '#9e5fff',
    //   dragBackgroundColor: '#9e5fff',
    // },

    // <div class="sidebar-item">
    //   <input type="checkbox" id="1" value="1" checked />
    //   <label class="checkbox checkbox-calendar checkbox-1" for="1">Projects</label>
    // </div>

    let cat_content = $('.sidbar-category');
    var cat_calendar = MOCK_CALENDARS;
    cat_calendar.forEach(function(elem){
      let cat = `<div class="sidebar-item">
              <input type="checkbox" id="${elem.id}" value="${elem.id}" checked />
              <label class="checkbox checkbox-calendar checkbox-${elem.id}" for="${elem.id}" style="--checkbox-${elem.id}: ${elem.backgroundColor}">${elem.name}</label>
            </div>`;
      cat_content.innerHTML += cat;
    });

    // var checkboxes = $('.sidbar-category input[type="checkbox"]');

    // checkboxes.forEach(function (checkbox) {
    //   setCheckboxBackgroundColor(checkbox);
    // });
  }

  getEventTemplate(event, isAllday) {
    var html = [];
    var start = moment(event.start.toDate().toUTCString());
    if (!isAllday) {
      html.push('<strong>' + start.format('HH:mm') + '</strong> ');
    }

    if (event.isPrivate) {
      html.push('<span class="calendar-font-icon ic-lock-b"></span>');
      html.push(' Private');
    } else {
      if (event.recurrenceRule) {
        html.push('<span class="calendar-font-icon ic-repeat-b"></span>');
      } else if (event.attendees.length > 0) {
        html.push('<span class="calendar-font-icon ic-user-b"></span>');
      } else if (event.location) {
        html.push('<span class="calendar-font-icon ic-location-b"></span>');
      }
      html.push(' ' + event.title);
    }

    return html.join('');
  }
  displayEvents() {
    // var events = generateRandomEvents(
    //   cal.getViewName(),
    //   cal.getDateRangeStart(),
    //   cal.getDateRangeEnd()
    // );
    this.tui_calendar.clear();
    this.tui_calendar.createEvents(this.events);
  }

  setDateDay(date){
    let viewName = 'day';
    this.tui_calendar.changeView(viewName);
    // console.log(this)

    if(this.checkboxCollapse){
      this.checkboxCollapse.disabled = (viewName === 'month');
    }
    this.toggleDropdownState(this);
    this.tui_calendar.setDate(date);
    this.setDropdownTriggerText();
  }

  setDateMonth(date){
    console.log(date);
    this.tui_calendar.changeView('month');
    this.tui_calendar.setDate(date);
    this.update();
  }

  // Calendar instance with options
  // eslint-disable-next-line no-undef
  // cal = Calendar

  init(){
    this.tui_calendar = new tui.Calendar('#app', {
      calendars: this.calendars,
      projects: this.projects,
      defaultView: 'month',  // month | week | day
      // taskView: true,
      useFormPopup: true,
      useDetailPopup: true,
      month: {
          visibleWeeksCount: 4,
      },
      week: {
          // taskView: true,
          // eventView: false,
      },
    });
  
    // Init
    this.displayEvents();
    // this.bindInstanceEvents();
    this.initCheckbox();
    this.bindAppEvents();
    this.update();
  }
}
