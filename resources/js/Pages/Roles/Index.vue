<script setup>
import { Link, Head, useForm, router, usePage } from "@inertiajs/vue3";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    roles: {
        type: Object,
        required: true, // コントローラー側からデータの送信が必須になるので、これを設定　※開発者ツールに警告が出る
    },
});

// コントローラーのdestroyアクションに送信するために変数にしている
const deleteForm = useForm();

/**
 * usePage()の中身は
 * component: "Students/Index",
 * url: "/students?search=abc",
 * props: {
 *   students: {...},
 *   classes: {...},
 *   filters: {...},
 *   auth: {
 *     user: {...}
 *   },
 *   can: {
 *     student_create: true,
 *     student_edit: false,
 *   },
 *   flash: {
 *     message: "保存しました"
 *   }
 * }
 * などのInertiaが既に持っている情報が入っている
 */
const page = usePage();

const deleteRole = (roleId) => {
    if (confirm("この権限を削除してもよろしいですか？")) {
        deleteForm.delete(route("roles.destroy", roleId), { // deleteForm.delete()はform.delete()のようなことをしている
            preserveScroll: true // 画面の削除後もスクロール位置を保つ
        });
    }
};
</script>

<template>
    <Head title="Students List" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Roles List
            </h2>
        </template>
        <div class="bg-gray-100 py-10">
            <div class="mx-auto max-w-7xl">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto">
                            <h1 class="text-xl font-semibold text-gray-900">
                                Roles
                            </h1>
                            <p class="mt-2 text-sm text-gray-700">
                                A list of all the Roles.
                            </p>
                        </div>

                        <div class="mt-4 sm:mt-0 sm:ml-16 sm:flex-none">
                            <Link
                                v-if="page.props.can.role_create"
                                :href="route('roles.create')"
                                class="inline-flex items-center justify-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 sm:w-auto"
                            >
                                Add Role
                            </Link>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-col">
                        <div
                            class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8"
                        >
                            <div
                                class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8"
                            >
                                <div
                                    class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg relative"
                                >
                                    <table
                                        class="min-w-full divide-y divide-gray-300"
                                    >
                                        <thead class="bg-gray-50">
                                            <tr>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    ID
                                                </th>
                                                <th
                                                    scope="col"
                                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                                >
                                                    Title
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody
                                            class="divide-y divide-gray-200 bg-white"
                                        >
                                            <tr
                                                v-for="role in roles.data"
                                                :key="role.id"
                                            >
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ role.id }}
                                                </td>
                                                <td
                                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                                >
                                                    {{ role.title }}
                                                </td>
                                                <td
                                                    class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6"
                                                >
                                                    <Link
                                                        :href="
                                                            route(
                                                                'roles.edit',
                                                                role.id
                                                            )
                                                        "
                                                        class="text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Edit
                                                    </Link>
                                                    <button
                                                        @click="
                                                            deleteRole(role.id)"
                                                        class="ml-2 text-indigo-600 hover:text-indigo-900"
                                                    >
                                                        Delete
                                                    </button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
