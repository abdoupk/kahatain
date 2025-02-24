<script setup lang="ts">
/* eslint-disable array-element-newline */
import { type CkeditorElement, type CkeditorEmit, type CkeditorProps as GlobalCkeditorProps, init } from './ckeditor'

import ClassicEditor from '@ckeditor/ckeditor5-build-classic'
import '@ckeditor/ckeditor5-build-classic/build/translations/ar'
import '@ckeditor/ckeditor5-build-classic/build/translations/fr'
import { inject, onMounted, ref } from 'vue'

import { getLocale } from '@/utils/i18n'

export type ProvideClassicEditor = (el: CkeditorElement) => void

interface CkeditorProps extends GlobalCkeditorProps {
    as?: string | object
}

const props = withDefaults(defineProps<CkeditorProps>(), {
    as: 'div',
    config: () => ({
        language: getLocale(),
        toolbar: {
            items: [
                'undo',
                'redo',
                '|',
                'heading',
                '|',
                'fontfamily',
                'fontsize',
                'fontColor',
                'fontBackgroundColor',
                '|',
                'bold',
                'italic',
                'strikethrough',
                'subscript',
                'superscript',
                'code',
                '|',
                'link',
                'insertTable',
                'blockQuote',
                '|',
                'alignment',
                '|',
                'bulletedList',
                'numberedList',
                'todoList',
                'outdent',
                'indent'
            ],
            shouldNotGroupWhenFull: true
        }
    })
})

const emit = defineEmits<CkeditorEmit>()

const editorRef = ref<CkeditorElement>()

const cacheData = ref('')

const bindInstance = (el: CkeditorElement) => {
    if (props.refKey) {
        const bind = inject<ProvideClassicEditor>(`bind[${props.refKey}]`)

        if (bind) {
            bind(el)
        }
    }
}

const vEditorDirective = {
    mounted(el: CkeditorElement) {
        init(el, ClassicEditor, { props, emit, cacheData })
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
