<template>
    <div class="drawer">
        <input id="my-drawer-3" type="checkbox" class="drawer-toggle" />
        <div class="drawer-content flex flex-col h-screen">
            <!-- Navbar -->
            <div class="w-full navbar bg-base-300">
                <div class="flex-none lg:hidden">
                    <label for="my-drawer-3" aria-label="open sidebar" class="btn btn-square btn-ghost">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="inline-block w-6 h-6 stroke-current"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path></svg>
                    </label>
                </div>
                <div class="flex-1 px-2 mx-2">UK LANs Finder</div>
                <div class="flex-none hidden lg:block">
                    <ul class="menu menu-horizontal">
                        <!-- Navbar menu content here -->
                        <input
                            type="text"
                            placeholder="Postcode"
                            class="input w-full max-w-xs"
                            v-model="v$.postcode.$model"
                            v-on:keyup.enter="postcodeSearch"
                            :class="{'input-error': v$.postcode.$error}"
                        />
                    </ul>
                </div>
            </div>

            <slot>
            </slot>
        </div>
        <div class="drawer-side">
            <label for="my-drawer-3" aria-label="close sidebar" class="drawer-overlay"></label>
            <ul class="menu p-4 w-80 min-h-full bg-base-200">
                <!-- Sidebar content here -->
            </ul>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {useForm, usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import {required} from "@vuelidate/validators";
import useVuelidate from "@vuelidate/core";

const state = useForm({
    postcode: null,
});
const rules = computed(() => ({
    postcode: { required }
}))
const $externalResults = computed(() => {
    return usePage().props.errors;
});
const v$ = useVuelidate(rules, state, { $externalResults });

const postcodeSearch = () => {
    v$.value.$touch();
    if (v$.value.$invalid) return;
    state.post(route('search'));
}
</script>
