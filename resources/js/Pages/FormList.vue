<template>
    <Head title="Form List" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Created Forms
            </h2>
        </template>
        <!--   TODO: Fix Layout     -->
        <Link :href="route('form-create')" class="underline">
            Create Form
        </Link>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div v-for="form in data" class="p-6 bg-white border-b border-gray-200">
                        <a :href="form['url']">{{form['name']}}</a>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
import {Head, Link} from '@inertiajs/inertia-vue3';

export default {
    components: {
        BreezeAuthenticatedLayout,
        Head,
        Link,
    },
    props: {
        data: Array
    },
}
</script>
