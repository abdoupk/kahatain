import { computed, useAttrs } from 'vue'

export const useComputedAttrs = () => {
    return computed(() => {
        const { ['class']: className, ...attrs } = useAttrs()

        return { class: className, attrs }
    }).value
}
