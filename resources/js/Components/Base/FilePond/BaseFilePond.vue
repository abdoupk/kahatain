<script lang="ts" setup>
import FilePondPluginFileValidateSize from 'filepond-plugin-file-validate-size'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
import 'filepond/dist/filepond.min.css'
import ar_AR from 'filepond/locale/ar-ar.js'
import { ref } from 'vue'
import vueFilePond, { setOptions } from 'vue-filepond'

const props = defineProps<{
    files?: string[]
    isPicture?: boolean
}>()

const server = {
    process: (fieldName, file, metadata, load, error, progress) => {
        if (!hasFiles.value) {
            // Related to aborting the request
            const CancelToken = axios.CancelToken

            const source = CancelToken.source()

            const formData = new FormData()

            formData.append(fieldName, file, file.name)

            // The request itself
            axios({
                method: 'post',
                url: route('tenant.upload.file'),
                data: formData,
                cancelToken: source.token,
                onUploadProgress: (e) => {
                    // Updating progress indicator
                    progress(e.lengthComputable, e.loaded, e.total)
                }
            }).then((response) => {
                // Passing the file id to FilePond
                load(response.data)

                emit('update:files', [response.data])
            })
        } else {
            progress(1)

            load(props.files)
        }
    },

    revert: (filename, load) => {
        load()
    }
}

const emit = defineEmits(['update:files'])

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview, FilePondPluginFileValidateSize)

setOptions({
    ...ar_AR
})

function handleRemoveFile() {
    hasFiles.value = false

    emit('update:files', [])
}

const hasFiles = ref(false)

function handleInit() {
    if (props.files) {
        hasFiles.value = true
    }
}
</script>

<template>
    <no-ssr>
        <file-pond
            :credits="false"
            :files
            :server
            :styleButtonProcessItemPosition="isPicture ? 'center bottom' : undefined"
            :styleButtonRemoveItemPosition="isPicture ? 'center bottom' : undefined"
            :styleLoadIndicatorPosition="isPicture ? 'center bottom' : undefined"
            :stylePanelLayout="isPicture ? 'compact circle' : undefined"
            :styleProgressIndicatorPosition="isPicture ? 'center bottom' : undefined"
            accepted-file-types="image/jpeg, image/png"
            maxFileSize="10MB"
            v-bind="$attrs"
            @init="handleInit"
            @removefile="handleRemoveFile"
        />
    </no-ssr>
</template>
<style lang="postcss">
@import '/resources/css/vendors/filepond.css';
</style>
