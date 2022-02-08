<template>
    <Head title="Form List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Created Forms
            </h2>
        </template>
        <!--   TODO: Fix Layout     -->
        <form :action="route('form-create')">
            <Button>Create Form</Button>
        </form>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="form in data" class="p-6 bg-white border-b border-gray-200">
                        <a :href="form['stats_url']"
                           class="underline text-sm text-gray-600 hover:text-gray-900 p-5">
                            {{form['name']}}
                        </a>
                        <a target="_blank" :href="form['form_url']" class="underline text-sm text-gray-600 hover:text-gray-900 p-5">URL</a>
                        <span class="p-5">{{form['submit_count'] ?? 0}} / {{form['open_count']??0}}</span>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';
import Button from "../Components/Button";

export default {
    components: {
        Button,
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        data: Array
    },
}
</script>
