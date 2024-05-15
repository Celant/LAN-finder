<script lang="ts" setup>
import {computed, ref} from "vue";
import {DateTime} from "luxon";

const props = defineProps<{
    event: {
        id: number,
        name: string,
        location: {
            type: string,
            coordinates: [number, number]
        },
        location_name: string,
        starts_at: string,
        ends_at: string,
        image: string,
        link: string,
        slug: string,
    }
}>()

const eventDate = computed(() => {
    const starts = DateTime.fromISO(props.event.starts_at)
    const ends = DateTime.fromISO(props.event.ends_at)
    const startsOpts = {...DateTime.DATE_MED, year: undefined}
    const endsOpts = {...DateTime.DATE_MED}
    return `${starts.toLocaleString(startsOpts)} - ${ends.toLocaleString(endsOpts)}`
});
const eventImage = computed(() => props.event.image || 'https://fakeimg.pl/128x128?text=Event+Image')
</script>

<template>
    <div class="bg-neutral">
        <div class="flex">
            <div class="flex-shrink-0">
                <img class="h-32 w-32 object-cover" :src="eventImage" alt="Event image">
            </div>
            <div class="flex flex-col pl-4 pt-3 pb-1">
                <div class="uppercase tracking-wide text-lg text-indigo-500 font">
                    {{ event.name }}
                </div>
                <p class="block mt-1 text-sm leading-tight font-medium font-semibold">{{ event.location_name }}</p>
                <p class="mt-2 text-gray-500">{{ eventDate }}</p>
                <div class="grow"></div>
                <a class="link link-primary" :href="event.link">Website</a>
            </div>
        </div>
    </div>
</template>
