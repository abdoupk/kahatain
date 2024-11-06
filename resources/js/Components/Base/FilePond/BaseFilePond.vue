<script lang="ts" setup>
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
import 'filepond/dist/filepond.min.css'
import ar_AR from 'filepond/locale/ar-ar.js'
import { ref } from 'vue'
import vueFilePond, { setOptions } from 'vue-filepond'

const props = defineProps<{
    files?: string[]
}>()

const server = {
    process: (fieldName, file, metadata, load, error, progress) => {
        if (!hasFiles.value) {
            const formData = new FormData()

            formData.append(fieldName, file, file.name)

            axios
                .post(route('tenant.upload.file'), formData, {
                    onUploadProgress: (e) => {
                        progress(e.lengthComputable ? (e.loaded / e.total) * 100 : 0)
                    }
                })
                .then((response) => {
                    load(response.data)

                    emit('update:files', [response.data])
                })
                .catch((error) => {
                    error(error.message)
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

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview)

setOptions(ar_AR)

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
            accepted-file-types="image/jpeg, image/png"
            v-bind="$attrs"
            @init="handleInit"
            @removefile="handleRemoveFile"
        />
    </no-ssr>
</template>
