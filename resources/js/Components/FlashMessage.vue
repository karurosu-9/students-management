<script setup>
import { usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

// status に応じてクラスを返す
const flashClass = computed(() => {
    const status = page.props.flash.status

    if (status === 'success') return 'bg-green-500 text-white' // 成功のステータス
    if (status === 'delete')  return 'bg-red-500 text-white'   // 削除のステータス
    if (status === 'error')   return 'bg-red-700 text-white'   // エラーのステータス
});
</script>

<template>
    <div v-if="page.props.flash.message"
        :class="flashClass"
        class="p-4"
    >
        {{ $page.props.flash.message }}
    </div>
</template>
