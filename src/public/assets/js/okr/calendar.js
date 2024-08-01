// Duplicated connection
function copyArticle(event) {
    const range = document.createRange();
    range.selectNode(document.getElementById('icalcontent'));
    const selection = window.getSelection();
    if (selection.rangeCount > 0) selection.removeAllRanges();
    selection.addRange(range);
    document.execCommand('copy');
    alert("Copy successful");
}
document.getElementById('copyBT').addEventListener('click', copyArticle, false);

// system time
var st_d = new Date();
var y = st_d.getFullYear();
var m = st_d.getMonth();
var d = st_d.getDay();
// Obtain a user
let calendar = document.getElementById('calendar');
var uid = calendar.dataset.uid;

// Introduce
// Personal new note
var evt = [];
$.ajax({
    url: 'api/user/' + uid + '/calendar',
    type: "GET",
    dataType: "JSON",
    async: false
}).done(function (r) {
    evt = r;
})
// Personal O execution period
var evo = [];
$.ajax({
    url: 'api/user/' + uid + '/objectives',
    type: "GET",
    dataType: "JSON",
    async: false
}).done(function (r) {
    evo = r;
})
// Personal Action deadline
var eac = [];
$.ajax({
    url: 'api/user/' + uid + '/actions',
    type: "GET",
    dataType: "JSON",
    async: false
}).done(function (r) {
    eac = r;
    console.log(eac);
})
//calendar
$("#calendar").fullCalendar({
    themeSystem: 'bootstrap4',
    header: { // Top layout
        left: "prev,next today", // Place the previous page, the next page, and today
        center: "title", // Place the title in the middle
        right: "month,basicWeek,listDay" //Month, week, and heavens on the right
    },
    editable: true, // Start Dragging Adjustment Date
    eventLimit: true, //  Start plural data source
    eventSources: [evo, evt, eac], // Multiple data format
    eventRender: function eventRender(event, element, view) {
        return ['all', event.school].indexOf($('#school_selector').val()) >= 0
    },
    dayClick: function (date, jsEvent, view, resourceObj) {
        $("#started_at").val(date.format());
        $("#mdlEvent").modal();
        $("#fin_date").val();
    },
    // customButtons: {
    //     myCustomButton: {
    //         text: '篩選',
    //         click: function () {
    //             $('#school_selector').on('change', function () {
    //                 $('#calendar').fullCalendar('rerenderEvents');
    //             })

    //         }
    //     },
    // }
});

$('#finished_at').datepicker({
    format: 'yyyy-mm-dd'
});
$('#school_selector').on('change', function () {
    $('#calendar').fullCalendar('rerenderEvents');
})


// $.get('api/calendar',{},function(data){
//     activities = data;
// console.log(activities[0]['title'])
// });

// $("#calendar").fullCalendar({

//     header: { // 頂部排版
//         left: "prev,next today", // 左邊放置上一頁、下一頁和今天
//         center: "title", // 中間放置標題
//         right: "month,basicWeek,basicDay" // 右邊放置月、周、天
//     },
//     editable: true, // 啟動拖曳調整日期

//     navLinks: true, // can click day/week names to navigate views
//     dayClick: function (date, event, view) {
//         console.log('add event');
//         console.log(date);
//         console.log(event);
//         console.log(view);
//     },
//     eventClick: function (date, event, view) {
//         console.log('modify event');
//         console.log(date);
//         console.log(event);
//         console.log(view);
//     },
//     events: [{
//         title: '昨天的活動',
//         start: moment().subtract(1, 'days').format('YYYY-MM-DD')
//     }, {
//         title: '持續一周的活動',
//         start: moment().add(7, 'days').format('YYYY-MM-DD'),
//         end: moment().add(14, 'days').format('YYYY-MM-DD'),
//         color: 'lightBlue'
//     }]
// });

// //動態產生活動釋例
// $('#calendar').fullCalendar('renderEvent', {
//     title: '明天的活動',
//     start: moment().add(1, 'days').format('YYYY-MM-DD')
// });

// $('#calendar').fullCalendar('renderEvent', {
//     id: 'eventGroup1',
//     title: '活動1',
//     start: moment().add(3, 'days').format('YYYY-MM-DD'),
//     textColor: 'black',
//     color: 'beige'
// });

// $('#calendar').fullCalendar('renderEvent', {
//     id: 'eventGroup1',
//     title: '活動2',
//     start: moment().add(5, 'days').format('YYYY-MM-DD'),
//     textColor: 'black',
//     color: 'beige'
// });
