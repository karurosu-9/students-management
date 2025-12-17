<script setup>
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

defineProps({
    classes: {
        type: Object,
        required: true // コントローラー側からのデータの受取り必須のオプション
    },
});

const form = useForm({// useFormの場合はエラーメッセージの保持など色々と便利
    name: "",         // router.postではなく、form.postでフォームの値を送信できる
    email: "",
    class_id: "",
    section_id: ""
});

let sections = ref({});

watch(
    // ここが監視対象を指定
    () => form.class_id,
    //　監視対象の値が変更されたとら、変更された値をgetSectins()に渡す
    (newValue) => {
        getSections(newValue);
    }
);

// classに紐づくsectionの取得
const getSections = async (class_id) => {
    try {
        // axiosでapiルート「sections」を経由してコントローラーに「class_id(key), x(value)」で値を渡して、コントローラーで$request->class_idで受け取った値から紐づくsectionの値を取得
        await axios.get('/api/sections', {
            params: { // params:で?class_id=${search.value}の変わりをしている
                class_id: class_id
            }
        })
            .then(response => { // responseの中にはApi/SectionControllerから返ってきた値が入っている
                console.log(response.data);
                sections.value = response.data;
            })
    } catch (e) {
        console.log(e);
    }
}

const createStudent = () => {
    form.post(route('students.store'));
};
</script>

<template>
    <Head title="Create Student" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Create Student
            </h2>
        </template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="createStudent">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3
                                        class="text-lg leading-6 font-medium text-gray-900"
                                    >
                                        Student Information
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to create a new student.
                                    </p>
                                </div>

                                <!-- name -->
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.name" />
                                        <label
                                            for="name"
                                            class="block text-sm font-medium text-gray-700"
                                            >Name</label
                                        >
                                        <input
                                            v-model="form.name"
                                            type="text"
                                            id="name"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300' : form.errors.name}"
                                        />
                                    </div>

                                    <!-- email -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.email" />
                                        <label
                                            for="email"
                                            class="block text-sm font-medium text-gray-700"
                                            >Email Address</label
                                        >
                                        <input
                                            v-model="form.email"
                                            type="email"
                                            id="email"
                                            autocomplete="email"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300' : form.errors.email}"
                                        />
                                    </div>

                                    <!-- class_id -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.class_id" />
                                        <label
                                            for="class_id"
                                            class="block text-sm font-medium text-gray-700"
                                            >Class</label
                                        >
                                        <select
                                            v-model="form.class_id"
                                            id="class_id"
                                            class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300' : form.errors.class_id}"
                                        >
                                            <option value="">
                                                Select a Class
                                            </option>
                                            <option
                                                v-for="item in classes.data" :key="item.id"
                                                :value="item.id">{{ item.name }}</option>
                                        </select>
                                    </div>

                                    <!-- section_id -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.section_id" />
                                        <label
                                            for="section_id"
                                            class="block text-sm font-medium text-gray-700"
                                            >Section</label
                                        >
                                        <select
                                            v-model="form.section_id"
                                            id="section_id"
                                            class="mt-1 block w-full bg-white border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300' : form.errors.section}"
                                        >
                                            <option value="">
                                                Select a Section
                                            </option>
                                            <option
                                                v-for="section in sections.data" :key="section.id" :value="section.id"
                                            >
                                                    {{ section.name }}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                            >
                                <a
                                    href="#"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                                >
                                    Cancel
                                </a>
                                <button
                                    type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    Save
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
