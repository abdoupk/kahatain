<script lang="ts" setup>
import { type CalendarOptions, EventSourceInput } from '@fullcalendar/core'
import '@fullcalendar/core/index.js'
import arLocale from '@fullcalendar/core/locales/ar'
import frLocale from '@fullcalendar/core/locales/fr'
import dayGridPlugin from '@fullcalendar/daygrid'
import interactionPlugin from '@fullcalendar/interaction'
import listPlugin from '@fullcalendar/list'
import timeGridPlugin from '@fullcalendar/timegrid'
import FullCalendar from '@fullcalendar/vue3'

import { getLocale } from '@/utils/i18n'

const props = defineProps<{ events: EventSourceInput | undefined }>()

// eslint-disable-next-line array-element-newline
const emit = defineEmits(['dateClick', 'eventDrop', 'eventClick', 'eventResize'])

const options: CalendarOptions = {
    // eslint-disable-next-line array-element-newline
    plugins: [interactionPlugin, dayGridPlugin, timeGridPlugin, listPlugin],
    droppable: true,
    editable: true,
    locales: [arLocale, frLocale],
    locale: getLocale(),
    direction: getLocale() === 'ar' ? 'rtl' : 'ltr',
    headerToolbar: {
        left: 'prev,next today',
        center: 'title',
        right: 'dayGridMonth,timeGridWeek,timeGridDay,listWeek'
    },

    initialDate: new Date(),
    navLinks: true,
    dayMaxEvents: true,
    eventDrop({ event }) {
        emit('eventDrop', event)
    },
    dateClick(arg) {
        emit('dateClick', arg)
    },
    eventResize(arg) {
        emit('eventResize', arg.event)
    },
    eventClick: function ({ event }) {
        emit('eventClick', event)
    },
    events: props.events,
    drop: function (info) {
        if (
            document.querySelectorAll('#checkbox-events').length &&
            (document.querySelectorAll('#checkbox-events')[0] as HTMLInputElement)?.checked
        ) {
            ;(info.draggedEl.parentNode as HTMLElement).remove()

            if (document.querySelectorAll('#calendar-events')[0].children.length == 1) {
                document.querySelectorAll('#calendar-no-events')[0].classList.remove('hidden')
            }
        }
    }
}
</script>

<template>
    <div class="full-calendar">
        <FullCalendar :options="options" />
    </div>
</template>

<style lang="postcss">
@import url('/resources/css/components/base/_full-calendar.css');
</style>
