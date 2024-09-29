<script setup lang="ts">
import { type CkeditorElement, type CkeditorEmit, type CkeditorProps as GlobalCkeditorProps, init } from './ckeditor'

import DocumentEditor from '@ckeditor/ckeditor5-build-decoupled-document'
import { inject, onMounted, ref } from 'vue'

import { getLocale } from '@/utils/i18n'

export type ProvideDocumentEditor = (el: CkeditorElement) => void

interface CkeditorProps extends GlobalCkeditorProps {
    as?: string | object
}

const props = withDefaults(defineProps<CkeditorProps>(), {
    as: 'div',
    config: () => ({
        language: getLocale()
    })
})

const emit = defineEmits<CkeditorEmit>()

const editorRef = ref<CkeditorElement>()

const cacheData = ref('')

const bindInstance = (el: CkeditorElement) => {
    if (props.refKey) {
        const bind = inject<ProvideDocumentEditor>(`bind[${props.refKey}]`)

        if (bind) {
            bind(el)
        }
    }
}

const vEditorDirective = {
    mounted(el: CkeditorElement) {
        init(el, DocumentEditor, { props, emit, cacheData })
    }
}

onMounted(() => {
    if (editorRef.value) {
        bindInstance(editorRef.value)
    }
})
</script>

<template>
    <component :is="props.as" ref="editorRef" v-editor-directive class="select"></component>
</template>
<style lang="postcss">
@import '/resources/css/vendors/ckeditor.css';
</style>
