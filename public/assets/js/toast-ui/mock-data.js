/* eslint-disable */
var MOCK_CALENDARS = [
  {
    id: '1',
    name: 'Projects',
    color: '#ffffff',
    borderColor: '#9e5fff',
    backgroundColor: '#9e5fff',
    dragBackgroundColor: '#9e5fff',
  },
  {
    id: '2',
    name: 'Work',
    color: '#ffffff',
    borderColor: '#00a9ff',
    backgroundColor: '#00a9ff',
    dragBackgroundColor: '#00a9ff',
  },
  {
    id: '3',
    name: 'Family',
    color: '#ffffff',
    borderColor: '#DB473F',
    backgroundColor: '#DB473F',
    dragBackgroundColor: '#DB473F',
  },
  {
    id: '4',
    name: 'Tâches',
    color: '#ffffff',
    borderColor: '#03bd9e',
    backgroundColor: '#03bd9e',
    dragBackgroundColor: '#03bd9e',
  },
  {
    id: '5',
    name: 'Event',
    color: '#ffffff',
    borderColor: '#bbdc00',
    backgroundColor: '#bbdc00',
    dragBackgroundColor: '#bbdc00',
  },
];
var PROJECT_CALENDARS = [
  {
    id: '323',
    name: 'project 1',
    color: '#ccc',
  },
  {
    id: '456',
    name: 'project 2',
    color: '#eee'
  }
];


var EVENT_CATEGORIES = ['milestone', 'task'];

function generateRandomEvent(calendar, renderStart, renderEnd) {
  function generateTime(event, renderStart, renderEnd) {
    var startDate = moment(renderStart.getTime());
    var endDate = moment(renderEnd.getTime());
    var diffDate = endDate.diff(startDate, 'days');

    event.isAllday = chance.bool({ likelihood: 30 });
    if (event.isAllday) {
      event.category = 'allday';
    } else if (chance.bool({ likelihood: 30 })) {
      event.category = EVENT_CATEGORIES[chance.integer({ min: 0, max: 1 })];
      if (event.category === EVENT_CATEGORIES[1]) {
        event.dueDateClass = 'morning';
      }
    } else {
      event.category = 'time';
    }

    startDate.add(chance.integer({ min: 0, max: diffDate }), 'days');
    startDate.hours(chance.integer({ min: 0, max: 23 }));
    startDate.minutes(chance.bool() ? 0 : 30);
    event.start = startDate.toDate();

    endDate = moment(startDate);
    if (event.isAllday) {
      // endDate.add(chance.integer({ min: 0, max: 3 }), 'days');
    }

    event.end = endDate.add(chance.integer({ min: 1, max: 4 }), 'hour').toDate();

    if (!event.isAllday && chance.bool({ likelihood: 20 })) {
      event.goingDuration = chance.integer({ min: 30, max: 120 });
      event.comingDuration = chance.integer({ min: 30, max: 120 });

      if (chance.bool({ likelihood: 50 })) {
        event.end = event.start;
      }
    }
  }

  function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({ min: 1, max: 10 });

    for (; i < length; i += 1) {
      names.push(chance.name());
    }

    return names;
  }

  var id = chance.guid();
  var calendarId = calendar.id;
  var title = chance.sentence({ words: 3 });
  var body = chance.bool({ likelihood: 20 }) ? chance.sentence({ words: 10 }) : '';
  var isReadOnly = chance.bool({ likelihood: 20 });
  var isPrivate = chance.bool({ likelihood: 20 });
  var location = chance.address();
  var attendees = chance.bool({ likelihood: 70 }) ? generateNames() : [];
  var recurrenceRule = '';
  var state = chance.bool({ likelihood: 50 }) ? 'Busy' : 'Free';
  var goingDuration = chance.bool({likelihood: 20}) ? chance.integer({ min: 30, max: 120 }) : 0;
  var comingDuration = chance.bool({likelihood: 20}) ? chance.integer({ min: 30, max: 120 }) : 0;
  var raw = {
    memo: chance.sentence(),
    creator: {
      name: chance.name(),
      avatar: chance.avatar(),
      email: chance.email(),
      phone: chance.phone(),
    },
  };

  var event = {
    id: id,
    calendarId: calendarId,
    title: title,
    body: body,
    isReadOnly: isReadOnly,
    isPrivate: isPrivate,
    location: location,
    attendees: attendees,
    recurrenceRule: recurrenceRule,
    state: state,
    goingDuration: goingDuration,
    comingDuration: comingDuration,
    raw: raw,
  }

  generateTime(event, renderStart, renderEnd);

  if (event.category === 'milestone') {
    event.color = '#000'
    event.backgroundColor = 'transparent';
    event.borderColor = 'transparent';
    event.dragBackgroundColor = 'transparent';
  }

  return event;
}

function generateRandomEvents(viewName, renderStart, renderEnd) {
  var i, j;
  var event, duplicateEvent;
  var events = [];

  MOCK_CALENDARS.forEach(function(calendar) {
    for (i = 0; i < chance.integer({ min: 20, max: 50 }); i += 1) {
      event = generateRandomEvent(calendar, renderStart, renderEnd);
      events.push(event);

      if (i % 5 === 0) {
        for (j = 0; j < chance.integer({min: 0, max: 2}); j+= 1) {
          duplicateEvent = JSON.parse(JSON.stringify(event));
          duplicateEvent.id += `-${j}`;
          duplicateEvent.calendarId = chance.integer({min: 1, max: 5}).toString();
          duplicateEvent.goingDuration = 30 * chance.integer({min: 0, max: 4});
          duplicateEvent.comingDuration = 30 * chance.integer({min: 0, max: 4});
          events.push(duplicateEvent);
        }
      }
    }
  });

  function generateNames() {
    var names = [];
    var i = 0;
    var length = chance.integer({ min: 1, max: 10 });

    for (; i < length; i += 1) {
      names.push(chance.name());
    }

    return names;
  }

  let my_event = [
    {
      id: chance.guid(),
      calendarId: "1",
      projectId: '323',
      title: 'work from home',
      body: 'work from home is easy to day',
      isReadOnly: false,
      isPrivate: false,
      location: "Algeria, Alger",
      attendees: ['badni Abdelwahab', 'yassin sami'],
      recurrenceRule: '',
      start: moment('2024-11-12 09:40').format(), //"2024-09-12T16:00:00.000Z",
      end: moment('2024-11-12 10:40').format(),//"2024-09-12T19:00:00.000Z",
      goingDuration: 0,
      comingDuration: 0,
      raw: {
        memo: chance.sentence(),
        creator: {
          name: chance.name(),
          avatar: chance.avatar(),
          email: chance.email(),
          phone: chance.phone(),
        },
      },

      isAllday: false,
      // EVENT_CATEGORIES = ['milestone', 'task'];
      category: 'time',   // ['allday','milestone', 'task', 'time' ]
      dueDateClass: 'morning',
      state: 'dfdf',      // Busy | Free
    },
    {
      "id": "62f0d305-40bf-5b24-a867-5cb699820068",
      "calendarId": "1",
      'projectId': '456',
      "title": "Ifousiziw ko rekovi.",
      "body": "Gezuhja kinnohima kiz embow pafvi wekev ok rewepbam buw jilepef.",
      "isReadOnly": false,
      "isPrivate": false,
      "location": "362 Opla Ridge",
      "attendees": [
          "Grace Gibbs",
          "Dennis Herrera",
          "Sylvia Leonard",
          "Gussie Thompson",
          "Seth Harmon"
      ],
      "recurrenceRule": "",
      "state": "Free",
      "goingDuration": 0,
      "comingDuration": 0,
      "raw": {
          "memo": "Wewjol kobrenug tucjohus imaezu jan dapihlad itjakdo hofo coffo zow fuj lufsena ineina bi ceselov tabki lo.",
          "creator": {
              "name": "Susan Casey",
              "avatar": "//www.gravatar.com/avatar/778fb5f7bb187be47c40b5f9bd3def9b",
              "email": "leba@gursilfu.ck",
              "phone": "(785) 894-3405"
          }
      },
      "isAllday": false,
      "category": "task", // 'milestone' | 'task' | 'allday' | 'time';
      "start": "2024-11-19T16:00:00.000Z",
      "end": "2024-11-19T19:00:00.000Z"
  },
  {
    "id": "62f0d305-40bf-5b24-a80o-5cb699820068",
    "calendarId": "5",
    "title": "Ifousiziw ko rekovi.",
    "body": "Gezuhja kinnohima kiz embow pafvi wekev ok rewepbam buw jilepef.",
    "isReadOnly": false,
    "isPrivate": false,
    "location": "362 Opla Ridge",
    "attendees": [
        "Grace Gibbs",
        "Dennis Herrera",
        "Sylvia Leonard",
        "Gussie Thompson",
        "Seth Harmon"
    ],
    "recurrenceRule": "",
    "state": "Free",
    "goingDuration": 0,
    "comingDuration": 0,
    "raw": {
        "memo": "Wewjol kobrenug tucjohus imaezu jan dapihlad itjakdo hofo coffo zow fuj lufsena ineina bi ceselov tabki lo.",
        "creator": {
            "name": "Susan Casey",
            "avatar": "//www.gravatar.com/avatar/778fb5f7bb187be47c40b5f9bd3def9b",
            "email": "leba@gursilfu.ck",
            "phone": "(785) 894-3405"
        }
    },
    "isAllday": false,
    "category": "milestone", // 'milestone' | 'task' | 'allday' | 'time';
    "start": "2024-09-20T16:00:00.000Z",
    "end": "2024-09-20T19:00:00.000Z"
  },
  {
    "id": "62f0d305-40bf-5b24-a8kj-5cb699820068",
    "calendarId": "5",
    "title": "Ifousiziw ko rekovi.",
    "body": "Gezuhja kinnohima kiz embow pafvi wekev ok rewepbam buw jilepef.",
    "isReadOnly": false,
    "isPrivate": false,
    "location": "362 Opla Ridge",
    "attendees": [
        "Grace Gibbs",
        "Dennis Herrera",
        "Sylvia Leonard",
        "Gussie Thompson",
        "Seth Harmon"
    ],
    "recurrenceRule": "",
    "state": "Free",
    "goingDuration": 0,
    "comingDuration": 0,
    "raw": {
        "memo": "Wewjol kobrenug tucjohus imaezu jan dapihlad itjakdo hofo coffo zow fuj lufsena ineina bi ceselov tabki lo.",
        "creator": {
            "name": "Susan Casey",
            "avatar": "//www.gravatar.com/avatar/778fb5f7bb187be47c40b5f9bd3def9b",
            "email": "leba@gursilfu.ck",
            "phone": "(785) 894-3405"
        }
    },
    "isAllday": true,
    "category": "task", // 'milestone' | 'task' | 'allday' | 'time';
    "start": "2024-11-23T16:00:00.000Z",
    "end": "2024-11-23T19:00:00.000Z"
  },
  {
    "id": "62f0d305-40bf-5b24-a821-5cb699820068",
    "calendarId": "5",
    "title": "Ifousiziw ko rekovi.",
    "body": "Gezuhja kinnohima kiz embow pafvi wekev ok rewepbam buw jilepef.",
    "isReadOnly": false,
    "isPrivate": false,
    "location": "362 Opla Ridge",
    "attendees": [
        "Grace Gibbs",
        "Dennis Herrera",
        "Sylvia Leonard",
        "Gussie Thompson",
        "Seth Harmon"
    ],
    "recurrenceRule": "",
    "state": "Free",
    "goingDuration": 0,
    "comingDuration": 0,
    "raw": {
        "memo": "Wewjol kobrenug tucjohus imaezu jan dapihlad itjakdo hofo coffo zow fuj lufsena ineina bi ceselov tabki lo.",
        "creator": {
            "name": "Susan Casey",
            "avatar": "//www.gravatar.com/avatar/778fb5f7bb187be47c40b5f9bd3def9b",
            "email": "leba@gursilfu.ck",
            "phone": "(785) 894-3405"
        }
    },
    "isAllday": false,
    "category": "milestone", // 'milestone' | 'task' | 'allday' | 'time';
    "start": "2024-09-22T16:00:00.000Z",
    "end": "2024-09-22T19:00:00.000Z"
  }
  ];
  return my_event;
}
