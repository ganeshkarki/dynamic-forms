<template>
    <Head title="Create Form"/>

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create Form
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div id="content" class="p-5">
                        <div>
                        <form @submit.prevent="submit" method="post">
                            <div class="vue-form">
                                <fieldset>
                                    <div>
                                        <label class="label" for="formname">Form Name</label>
                                        <input type="text" name="formname" id="formname" required
                                               v-model="form.specification.name"
                                               placeholder="Survey, Application, etc.">
                                    </div>
                                </fieldset>
                            </div>

                            <div class="vue-form" v-for="(field, counter) in form.specification.fields"
                                 v-bind:key="counter">
                                <fieldset>
                                    <label class="label">Field {{counter+1}}</label>
                                    <hr>
                                    <div>
                                        <label class="label" for="name">Label</label>
                                        <input type="text" :name="name(counter)" id="name" required
                                               v-model="field.label"
                                               placeholder="Enter form field">
                                    </div>
                                    <div>
                                        <h4>Type</h4>
                                        <p class="select">
                                            <select :name="type(counter)" class="budget" v-model="field.input_type">
                                                <option value="text">Text</option>
                                                <option value="number">Numeric</option>
                                                <option value="email">Email</option>
                                            </select>
                                        </p>
                                    </div>

                                    <div>
                                        <h4>Validations</h4>
                                        <ul class="vue-form-list">
                                            <li>
                                                <input type="radio" :name="required(counter)" id="radio-1" value="true"
                                                       v-model="field.required">
                                                <label for="radio-1">Required</label>
                                            </li>
                                            <li>
                                                <input type="radio" :name="required(counter)" id="radio-2" value="false"
                                                       v-model="field.required">
                                                <label for="radio-2">Optional</label>
                                            </li>
                                        </ul>
                                    </div>

                                    <div v-if="field.input_type === 'number'">
                                        <label class="label" for="min">Min</label>
                                        <input type="number" :name="number_min(counter)" id="min"
                                               v-model="field.min">
                                    </div>
                                    <div v-if="field.input_type === 'number'">
                                        <label class="label" for="max">Max</label>
                                        <input type="number" :name="number_max(counter)" id="max"
                                               v-model="field.max">
                                    </div>
                                    <hr>
                                    <br>
                                    <Button type="button" @click="addField">Add Field</Button>
                                    <Button class="mx-5 bg-red-600" type="button" v-if="counter != 0"
                                            @click="deleteField(counter)">Delete Field
                                    </Button>
                                </fieldset>
                            </div>
                            <input type="hidden" name="data" :value="data">
                            <Button class="bg-indigo-500">Create Form</Button>
                        </form>
                        </div>
                        <div class="p-5">
                            <FormRenderer :formData="form.specification" :canSubmit="false">
                                <span class="text-center"> Preview </span>
                            </FormRenderer>
                            <div class="debug">
                                <pre><code>{{ $data['form']['specification'] }}</code></pre>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script>
    import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue'
    import {Head} from '@inertiajs/inertia-vue3';
    import Button from "../Components/Button";
    import Input from "../Components/Input";
    import FormRenderer from "../Components/FormRenderer";

    export default {
        components: {
            Input,
            Button,
            BreezeAuthenticatedLayout,
            Head,
            FormRenderer,

        },
        props: {
            data: Array
        },
        data() {
            return {
                form: this.$inertia.form({
                    specification: {
                        name: "Untitled Form",
                        count: 1,
                        version: null,
                        fields: [
                            {
                                label: "Label",
                                input_type: "text", // text|number|email
                                required: true,
                                min: null,
                                max: null,
                            }
                        ],
                    }
                }),
            }
        },
        methods: {
            name(counter) {
                var val = counter + 1;
                return 'name' + val;
            },
            type(counter) {
                var val = counter + 1;
                return 'type' + val;
            },
            required(counter) {
                var val = counter + 1;
                return 'required' + val;
            },
            number_min(counter) {
                var val = counter + 1;
                return 'number_min' + val;
            },
            number_max(counter) {
                var val = counter + 1;
                return 'number_max' + val;
            },
            addField() {
                this.form.specification.fields.push({
                    label: "Label",
                    input_type: "text", // text|number|email
                    required: true,
                    min: null,
                    max: null,
                });
                this.updateCount();
            },
            deleteField(counter) {
                this.form.specification.fields.splice(counter, 1);
                this.updateCount();
            },
            updateCount() {
                this.form.specification.count = this.form.specification.fields.length;
            },
            submit() {
                this.form.post(this.route('form-submit'));
            }

        }
    }
</script>

<style scoped>
    @import url("https://fonts.googleapis.com/css?family=Source+Code+Pro:300,400");

    *,
    *::after,
    *::before {
        box-sizing: border-box;
    }

    body {
        color: #fff;
        background: #949c4e;
        background: linear-gradient(
            115deg,
            rgba(86, 216, 228, 1) 10%,
            rgba(159, 1, 234, 1) 90%
        );
        font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto,
        Oxygen-Sans, Ubuntu, Cantarell, "Helvetica Neue", Helvetica, Arial,
        sans-serif;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
    }

    html,
    body,
    .container {
        min-height: 100vh;
    }

    .center {
        display: flex;
        justify-content: center;
        align-items: center;
    }

    a {
        color: #2c3e50;
        text-decoration: none;
    }

    header {
        position: relative;
        height: 150px;
        padding-top: 100px;
    }

    header h1 {
        text-align: center;
        font-size: 2.4rem;
        font-weight: 300;
    }

    #content {
        display: flex;
    }

    .vue-form {
        font-size: 16px;
        width: 500px;
        padding: 15px 30px;
        border-radius: 4px;
        margin: 10px auto;
        background-color: #fff;
        box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.3);
    }

    .vue-form fieldset {
        margin: 24px 0 0 0;
    }

    .vue-form legend {
        padding-bottom: 10px;
        border-bottom: 1px solid #ecf0f1;
    }

    .vue-form div {
        position: relative;
        margin: 20px 0;
    }

    .vue-form h4,
    .vue-form .label {
        color: #94aab0;
        margin-bottom: 10px;
    }

    .vue-form .label {
        display: block;
    }

    .vue-form input,
    .vue-form textarea,
    .vue-form select,
    .vue-form label {
        color: #2b3e51;
    }

    .vue-form input[type="text"],
    .vue-form input[type="email"],
    .vue-form textarea,
    .vue-form select,
    .vue-form legend {
        display: block;
        width: 100%;
        appearance: none;
    }

    .vue-form input[type="text"],
    .vue-form input[type="email"],
    .vue-form textarea,
    .vue-form select {
        padding: 12px;
        border: 1px solid #cfd9db;
        background-color: #ffffff;
        border-radius: 0.25em;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.08);
    }

    .vue-form input[type="text"]:focus,
    .vue-form input[type="email"]:focus,
    .vue-form textarea:focus,
    .vue-form select:focus {
        outline: none;
        border-color: #2c3e50;
        box-shadow: 0 0 5px rgba(44, 151, 222, 0.2);
    }

    .vue-form .select {
        position: relative;
    }

    .vue-form .select::after {
        content: "";
        position: absolute;
        z-index: 1;
        right: 16px;
        top: 50%;
        margin-top: -8px;
        display: block;
        width: 16px;
        height: 16px;
        background: url("data:image/svg+xml;charset=utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%0D%0A%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%0D%0A%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0D%0A%09%20width%3D%2216px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2016%2016%22%20enable-background%3D%22new%200%200%2016%2016%22%20xml%3Aspace%3D%22preserve%22%3E%0D%0A%3Cg%3E%0D%0A%09%3Cpolygon%20fill%3D%22%232c3e50%22%20points%3D%220.9%2C5.5%203.1%2C3.4%208%2C8.3%2012.9%2C3.4%2015.1%2C5.5%208%2C12.6%20%09%22%2F%3E%0D%0A%3C%2Fg%3E%0D%0A%3C%2Fsvg%3E") no-repeat center center;
        pointer-events: none;
    }

    .vue-form select {
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08);
        cursor: pointer;
    }

    .vue-form select::-ms-expand {
        display: none;
    }

    .vue-form .vue-form-list {
        margin-top: 16px;
    }

    .vue-form .vue-form-list::after {
        clear: both;
        content: "";
        display: table;
    }

    .vue-form .vue-form-list li {
        display: inline-block;
        position: relative;
        user-select: none;
        margin: 0 26px 16px 0;
        float: left;
    }

    .vue-form input[type="radio"],
    .vue-form input[type="checkbox"] {
        position: absolute;
        left: 0;
        top: 50%;
        transform: translateY(-50%);
        margin: 0;
        padding: 0;
        opacity: 0;
        z-index: 2;
    }

    .vue-form input[type="radio"] + label,
    .vue-form input[type="checkbox"] + label {
        padding-left: 24px;
    }

    .vue-form input[type="radio"] + label::before,
    .vue-form input[type="radio"] + label::after,
    .vue-form input[type="checkbox"] + label::before,
    .vue-form input[type="checkbox"] + label::after {
        content: "";
        display: block;
        position: absolute;
        left: 0;
        top: 50%;
        margin-top: -8px;
        width: 16px;
        height: 16px;
    }

    .vue-form input[type="radio"] + label::before,
    .vue-form input[type="checkbox"] + label::before {
        border: 1px solid #cfd9db;
        background: #ffffff;
        box-shadow: inset 0 1px 1px rgba(0, 0, 0, 0.08);
    }

    .vue-form input[type="radio"] + label::before,
    .vue-form input[type="radio"] + label::after {
        border-radius: 50%;
    }

    .vue-form input[type="checkbox"] + label::before,
    .vue-form input[type="checkbox"] + label::after {
        border-radius: 0.25em;
    }

    .vue-form input[type="radio"] + label::after,
    .vue-form input[type="checkbox"] + label::after {
        background-color: #2c3e50;
        background-position: center center;
        background-repeat: no-repeat;
        box-shadow: 0 0 5px rgba(44, 151, 222, 0.4);
        display: none;
    }

    .vue-form input[type="radio"] + label::after {
        background-image: url("data:image/svg+xml;charset=utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%0D%0A%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%0D%0A%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0D%0A%09%20width%3D%2216px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2016%2016%22%20enable-background%3D%22new%200%200%2016%2016%22%20xml%3Aspace%3D%22preserve%22%3E%0D%0A%3Ccircle%20fill%3D%22%23FFFFFF%22%20cx%3D%228%22%20cy%3D%228%22%20r%3D%223%22%2F%3E%0D%0A%3C%2Fsvg%3E");
    }

    .vue-form input[type="checkbox"] + label::after {
        background-image: url("data:image/svg+xml;charset=utf-8,%3C%3Fxml%20version%3D%221.0%22%20encoding%3D%22utf-8%22%3F%3E%0D%0A%3C%21--%20Generator%3A%20Adobe%20Illustrator%2018.1.1%2C%20SVG%20Export%20Plug-In%20.%20SVG%20Version%3A%206.00%20Build%200%29%20%20--%3E%0D%0A%3C%21DOCTYPE%20svg%20PUBLIC%20%22-%2F%2FW3C%2F%2FDTD%20SVG%201.1%2F%2FEN%22%20%22http%3A%2F%2Fwww.w3.org%2FGraphics%2FSVG%2F1.1%2FDTD%2Fsvg11.dtd%22%3E%0D%0A%3Csvg%20version%3D%221.1%22%20id%3D%22Layer_1%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%20x%3D%220px%22%20y%3D%220px%22%0D%0A%09%20width%3D%2216px%22%20height%3D%2216px%22%20viewBox%3D%220%200%2016%2016%22%20enable-background%3D%22new%200%200%2016%2016%22%20xml%3Aspace%3D%22preserve%22%3E%0D%0A%3Cpolyline%20fill%3D%22none%22%20stroke%3D%22%23FFFFFF%22%20stroke-width%3D%222%22%20stroke-linecap%3D%22square%22%20stroke-miterlimit%3D%2210%22%20points%3D%225%2C8%207%2C10%2011%2C6%20%22%2F%3E%0D%0A%3C%2Fsvg%3E");
    }

    .vue-form input[type="radio"]:focus + label::before,
    .vue-form input[type="checkbox"]:focus + label::before {
        box-shadow: 0 0 5px rgba(44, 151, 222, 0.6);
    }

    .vue-form input[type="radio"]:checked + label::after,
    .vue-form input[type="checkbox"]:checked + label::after {
        display: block;
    }

    .vue-form input[type="radio"]:checked + label::before,
    .vue-form input[type="radio"]:checked + label::after,
    .vue-form input[type="checkbox"]:checked + label::before,
    .vue-form input[type="checkbox"]:checked + label::after {
        animation: cd-bounce 0.3s;
    }

    .vue-form textarea {
        min-height: 120px;
        resize: vertical;
        overflow: auto;
    }

    .vue-form input[type="submit"] {
        border: none;
        background: #2c3e50;
        border-radius: 0.25em;
        padding: 12px 20px;
        color: #ffffff;
        font-weight: bold;
        float: right;
        cursor: pointer;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        appearance: none;
    }

    .no-touch .vue-form input[type="submit"]:hover {
        background: #42a2e1;
    }

    .vue-form input[type="submit"]:focus {
        outline: none;
        background: #2b3e51;
    }

    .vue-form input[type="submit"]:active {
        transform: scale(0.9);
    }

    .vue-form .error-message {
        height: 35px;
        margin: 0px;
    }

    .vue-form .error-message p {
        background: #e94b35;
        color: #ffffff;
        font-size: 1.4rem;
        text-align: center;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
        border-radius: 0.25em;
        padding: 16px;
    }

    .vue-form .error {
        border-color: #e94b35 !important;
    }

    .vue-form .counter {
        color: #2c3e50;
        position: absolute;
        right: 0px;
        top: 0px;
        font-size: 10px;
        padding: 4px;
    }

    .debug {
        border-radius: 4px;
        margin: 50px auto;
        width: 500px;
        background-color: #000;
        padding: 50px;
        background: rgba(0, 0, 0, 0.8);
        box-shadow: 0 4px 6px 0 rgba(0, 0, 0, 0.3);
    }

    .debug pre {
        color: #ffffff;
        font-size: 18px;
        line-height: 30px;
        font-family: "Source Code Pro", monospace;
        font-weight: 300;
        white-space: pre-wrap;
    }

    @-webkit-keyframes cd-bounce {
        0%,
        100% {
            -webkit-transform: scale(1);
        }
        50% {
            -webkit-transform: scale(0.8);
        }
    }

    @-moz-keyframes cd-bounce {
        0%,
        100% {
            -moz-transform: scale(1);
        }
        50% {
            -moz-transform: scale(0.8);
        }
    }

    @keyframes cd-bounce {
        0%,
        100% {
            transform: scale(1);
        }
        50% {
            transform: scale(0.8);
        }
    }

</style>


