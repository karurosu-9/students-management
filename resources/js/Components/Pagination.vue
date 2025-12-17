<script setup>
import { router } from '@inertiajs/vue3';

defineProps({
    linkData: {              // ここのlinkDataはLaravelのpaginate()が返す値のこと
        type: Object,
        required: true
    }
});

const updatedPageNumber = (link) => {
    if (!link.url) return;

    router.visit(link.url, {
        preserveScroll: true, // リンクを押した際にスクロールが上部に行かないように、位置を保持するオプション
        preserveState: true, // 検索入力欄や表示状態も保つオプション
        replace: true, // ページネーションのリンクや「戻る」ボタンを押しても、検索の履歴の維持
    });
}

// ページネーションの最初と最後の文言を「前」と「次」への表示に変換
const convertLabel = (label) => {
    if (label.includes("pagination.previous")) {
        return "前";
    }
    if (label.includes("pagination.next")) {
        return "次";
    }
    return label;
};
</script>

<template>
    <div class="max-w-7xl mx-auto py-6">
        <div class="max-w-none mx-auto">
            <div class="bg-white overflow-hidden shadow sm:rounded-lg">
                <div
                    class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6"
                >
                    <div class="flex-1 flex justify-between sm:hidden" />
                    <div
                        class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between"
                    >
                        <div>
                            <p class="text-sm text-gray-700">
                                総表示件数
                                <!-- space -->
                                <span class="font-medium">{{ linkData.meta.total }}</span>
                                <!-- space -->
                                 件中　　
                                <!-- space -->
                                <span class="font-medium">{{ linkData.meta.from }}</span>
                                <!-- space -->
                                〜
                                <!-- space -->
                                <span class="font-medium">{{ linkData.meta.to }}</span>
                                <!-- space -->
                                件表示
                            </p>
                        </div>
                        <div>
                            <nav
                                class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px"
                                aria-label="Pagination"
                            >
                                <button
                                    @click.prevent="updatedPageNumber(link)"
                                    v-for="(link, index) in linkData.meta.links"
                                    :key="index"
                                    :disabled="link.active || !link.url"
                                    class="relative inline-flex items-center px-4 py-2 border text-sm font-medium"
                                    :class="{
                                        'z-10 bg-indigo-50 border-indigo-500 text-indigo-600': link.active,
                                        'bg-white border-gray-300 text-gray-500 hover:bg-gray-50': !link.active,
                                    }"
                                >
                                    <span v-html="convertLabel(link.label)"></span>
                                </button>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
