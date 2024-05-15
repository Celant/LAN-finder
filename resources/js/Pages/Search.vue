<template>
    <Head title="Search" />

    <div class="flex grow">
        <div class="grow h-full" style="width:600px">
            <EventMap :events="events" :location="location"></EventMap>
        </div>

        <div class="flex flex-col w-2/5 overflow-y-scroll">
            <EventCard v-for="event in events" :key="event.id" :event="event"></EventCard>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Head, useForm} from '@inertiajs/vue3'
import EventMap from "../Components/EventMap.vue";
import EventCard from "../Components/EventCard.vue";

const props = defineProps<{
    events: {
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
        slug: string
    }[],
    location: {
        lat: string,
        long: string,
    }
}>()

const postcodeSearchForm = useForm({
    postcode: null,
});

const postcodeSearch = () => {
    const opts = {
        preserveScroll: true,
        preserveState: true,
    };
    postcodeSearchForm.post(route('search'), opts);
}
</script>

<script lang="ts">
import Public from '../Layouts/Public.vue';
export default {
    layout: Public,
}
</script>
