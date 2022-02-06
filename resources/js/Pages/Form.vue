<template>
    <Head title="Form" />
    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{formData['name']}}
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
<!--                        <h1 class="title is-1" v-text="formData['name']"></h1>-->
<!--                        <h1 class="title is-1" v-text="form.formName"></h1>-->

                        <div class="columns">
                            <div class="column">
                                <form
                                    v-bind:action="postUrl"
                                    method="post"
                                >
                                <!--    TODO: use object for FormData instead of array   -->
                                <!--    TODO: Check if dynamic code can be generated instead of static html using laravel functions or forming the tag in string  -->
                                <!--    TODO: Modularize and use the vue smaller components                                -->
                                    <div v-for="(field, fieldId) in formData['fields']">
                                        <label class="label">{{field['label']}}</label>
                                        <div class="control">
                                            <template v-if="field['input_type'] === 'number'">
                                                <template v-if="field['min'] != null && field['max'] != null">
                                                    <input class="input" :name="'f'+fieldId" type="number" :required="field['required']" :min="field['min']" :max="field['max']"/>
                                                </template>
                                                <template v-else-if="field['min'] != null">
                                                    <input class="input" :name="'f'+fieldId" type="number" :required="field['required']" :min="field['min']"/>
                                                </template>
                                                <template v-else-if="field['max'] != null">
                                                    <input class="input" :name="'f'+fieldId" type="number" :required="field['required']" :max="field['max']"/>
                                                </template>
                                            </template>
                                            <template v-if="field['input_type'] === 'email'">
                                                <input class="input" :name="'f'+fieldId" type="email" :required="field['required']"/>
                                            </template>
                                            <template v-if="field['input_type'] === 'text'">
                                                <input class="input" :name="'f'+fieldId" type="text" :required="field['required']"/>
                                            </template>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="submit"/>
                                </form>
                            </div>
<!--    JSON                        -->
<!--                            <div class="column">-->
<!--                                <h5>-->
<!--                                    JSON-->
<!--                                </h5>-->
<!--                                <pre><code>{{form}}</code></pre>-->
<!--                            </div>-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import {Head} from "@inertiajs/inertia-vue3";
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'

    export default {
        name: "Form",
        components: {
            Head,
            BreezeAuthenticatedLayout
        },
        props: {
            formData: Array,
            postUrl: String,
        },

        methods: {
        }
    }
</script>

<style scoped>
    .margin-bottom {
        margin-bottom: 15px;
    }

    .fade-enter, .fade-leave-active {
        opacity: 0;
    }

    .fade-enter-active, .fade-leave-active {
        transition: opacity .5s;
    }
</style>
