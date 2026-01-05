<script setup>
import InputError from '@/Components/InputError.vue';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import VSelect from 'vue-select';

const props = defineProps({
    role: {
        type: Object,
        required: true // コントローラー側からのデータの受取り必須のオプション
    },
    permissions: {
        type: Object,
        required: true // コントローラー側からのデータの受取り必須のオプション
    },
    errors: Object
});

const form = useForm({                           // useFormの場合はエラーメッセージの保持など色々と便利
    title: props.role.data.title,                // router.postではなく、form.postでフォームの値を送信できる
    selectedPermissions: props.role.data.permissions.map( // map()で、配列の中身をpermissionのidのみに変換する
        (permission) => permission.id
    ),
});

const updateRole = () => {
    form.put(route('roles.update', props.role.data.id));
};
</script>

<template>
    <Head title="Update Role" />

    <AuthenticatedLayout>
        <template #header>
            <h2
                class="text-xl font-semibold leading-tight text-gray-800"
            >
                Update Role
            </h2>
        </template>
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
            <div class="lg:grid lg:grid-cols-12 lg:gap-x-5">
                <div class="space-y-6 sm:px-6 lg:px-0 lg:col-span-12">
                    <form @submit.prevent="updateRole">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="bg-white py-6 px-4 space-y-6 sm:p-6">
                                <div>
                                    <h3
                                        class="text-lg leading-6 font-medium text-gray-900"
                                    >
                                        Role Information
                                    </h3>
                                    <p class="mt-1 text-sm text-gray-500">
                                        Use this form to create a new role.
                                    </p>
                                </div>

                                <!-- title -->
                                <div class="grid grid-cols-6 gap-6">
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.title" />
                                        <label
                                            for="name"
                                            class="block text-sm font-medium text-gray-700"
                                            >Title</label
                                        >
                                        <input
                                            v-model="form.title"
                                            type="text"
                                            id="title"
                                            class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                                            :class="{'text-red-900 focus:ring-red-500 focus:border-red-500 border-red-300' : form.errors.title}"
                                        />
                                    </div>

                                    <!-- permission -->
                                    <div class="col-span-6 sm:col-span-3">
                                        <InputError :message="form.errors.selectedPermissions" />
                                        <label for="permissions" class="block text-sm font-medium text-gray-700">
                                            Permissions
                                        </label>

                                        <!-- :reduceは、選択された承認アクションのIDだけを渡すようにする -->
                                        <v-select
                                            v-model="form.selectedPermissions"
                                            multiple
                                            :reduce="permission => permission.id"
                                            :options="permissions.data"
                                            label="title"
                                            class="block w-full rounded-md shadow-sm py-2 focus:outline-none
                                                   focus:ring-indigo-500 focus:border-indigo-500"
                                        ></v-select>
                                    </div>
                                </div>
                            </div>
                            <div
                                class="px-4 py-3 bg-gray-50 text-right sm:px-6"
                            >
                                <Link
                                    :href="route('roles.index')"
                                    class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-indigo-700 bg-indigo-100 hover:bg-indigo-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 mr-4"
                                >
                                    Cancel
                                </Link>
                                <button
                                    type="submit"
                                    class="bg-indigo-600 border border-transparent rounded-md shadow-sm py-2 px-4 inline-flex justify-center text-sm font-medium text-white hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                                >
                                    更新
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
