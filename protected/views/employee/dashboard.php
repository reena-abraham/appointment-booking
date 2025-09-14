
<div id="calendar" class="max-w-5xl mx-auto p-4 bg-white rounded shadow"></div>

<script>
    $(document).ready(function() {
    var calendarEl = $('#calendar');

    calendarEl.fullCalendar({
        header: {
            left: 'prev,next today',
            center: 'title',
            right: 'month,agendaWeek,agendaDay'
        },
        events: [
            <?php
            foreach ($events as $event) {
                echo "{ 
                    title: '{$event['title']}', 
                    start: '{$event['start']}', 
                    end: '{$event['end']}', 
                    description: '{$event['description']}'
                },";
            }
            ?>
        ],
        eventClick: function(info) {
            alert('Event: ' + info.title);
        }
    });
});
</script>
