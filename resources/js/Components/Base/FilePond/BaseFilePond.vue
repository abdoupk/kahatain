<script lang="ts" setup>
import axios from 'axios'
import FilePondPluginFileValidateType from 'filepond-plugin-file-validate-type'
import FilePondPluginImagePreview from 'filepond-plugin-image-preview'
import 'filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css'
import 'filepond/dist/filepond.min.css'
import vueFilePond from 'vue-filepond'

defineProps<{
    files?: string[]
}>()

const FilePond = vueFilePond(FilePondPluginFileValidateType, FilePondPluginImagePreview)

const server = {
    process: (fieldName, file, metadata, load, error, progress) => {
        const formData = new FormData()

        formData.append(fieldName, file, file.name)

        axios
            .post(route('tenant.upload.logo'), formData, {
                onUploadProgress: (e) => {
                    progress(e.lengthComputable, e.loaded, e.total)
                }
            })
            .then((response) => {
                load(response.data.filepath)
            })
            .catch(() => {
                error('Upload failed')
            })

        return {
            abort: () => {
                // Handle aborting the request
            }
        }
    },
    revert: (filename, load) => {
        axios
            .delete(route('tenant.delete.logo'))
            .then(() => {
                load(filename)
            })
            .catch(() => {
                load(filename)
            })
    },
    load: (source, load, error, progress, abort) => {
        axios.get(source).then((response) => {
            load(response.data)
        })
    }
}

const handleFilePondInit = () => {
    console.log('FilePond has initialized')
}
</script>

<template>
    <no-ssr>
        <file-pond
            ref="pond"
            :credits="false"
            :files
            :server
            accepted-file-types="image/jpeg, image/png"
            allow-multiple="false"
            allow-replace="true"
            @init="handleFilePondInit"
        />
    </no-ssr>
</template>
