<script lang="ts" setup>
import {LGeoJson, LMap, LTileLayer} from "@vue-leaflet/vue-leaflet";
import {computed, ref} from "vue";
import {circleMarker, marker} from "leaflet";

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
    location?: {
        lat: string,
        long: string,
    }
}>()

const geoJson = computed(() => {
    const points = props.events.map((event) => {
        return {
            "type": "Feature",
            "properties": {
                "type": "event",
                "name": event.name,
            },
            "geometry": {
                "type": "Point",
                "coordinates": [event.location.coordinates[0], event.location.coordinates[1]]
            }
        }
    });

    if (props.location) {
        points.push(selfLocation.value);
    }
    return points;
});
const zoom = computed(() => props.location ? 9 : 7);
const center = computed(() => props.location ? [props.location.lat, props.location.long] : [52.866, -1.406])

const selfLocation = computed(() => ({
    "type": "Feature",
    "properties": {
        "type": "self",
        "name": "You",
    },
    "geometry": {
        "type": "Point",
        "coordinates": [props.location.long, props.location.lat]
    }
}));


const geoJsonOptions = {
    pointToLayer: (feature, latlng) => {
        switch (feature.properties.type) {
            case 'event':
                return circleMarker(latlng, {radius: 4});
            default:
                return marker(latlng);
        }
    },
    //pointToLayer: (feature, latlng) => marker(latlng),
};
const geoJsonStyler = (feature) => {
    switch (feature.properties.type) {
        default: return {color: "#ff0000", fillOpacity: 1}
    }
};

</script>

<template>
    <l-map ref="map" v-model:zoom="zoom" :center="center">
        <l-tile-layer
            url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
            layer-type="base"
            name="OpenStreetMap"
        ></l-tile-layer>
        <l-geo-json :geojson="geoJson" :options="geoJsonOptions" :options-style="geoJsonStyler" />
    </l-map>
</template>
