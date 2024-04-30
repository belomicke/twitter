import { onMounted, onUnmounted, ref } from 'vue'

interface Options {
	maxFiles: number,
	maxSize?: number
}

export function useFilePicker(options: Options) {
    const {
        maxFiles,
        maxSize
    } = options

    const files = ref<File[]>([])
    const mediaFilePicker = ref<HTMLInputElement>(document.createElement('input'))
    const acceptedMimeTypes = ['image/png', 'image/jpeg']

    function openFilePicker() {
        mediaFilePicker.value.click()
    }

    function filePickerInputHandler(e: InputEvent) {
        if (files.value.length === maxFiles) return

        const target = e.target as HTMLInputElement

        if (target.files) {
            const file = target.files[0]

            if (maxSize && file.size > maxSize) return

            if (acceptedMimeTypes.includes(file.type)) {
                files.value.push(target.files[0])
                mediaFilePicker.value.value = ''
            }
        }
    }

    function deleteFile(index: number) {
        files.value.splice(index, 1)
    }

    function clearFilePicker() {
        files.value = []
    }

    onMounted(() => {
        mediaFilePicker.value.type = 'file'
        mediaFilePicker.value.accept = 'image/png, image/jpeg'
        mediaFilePicker.value.addEventListener('input', filePickerInputHandler)
    })

    onUnmounted(() => {
        mediaFilePicker.value.removeEventListener('input', filePickerInputHandler)
    })

    return {
        files,
        openFilePicker,
        deleteFile,
        clearFilePicker
    }
}
