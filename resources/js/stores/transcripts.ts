import type { Transcript } from '@/types/types'

import axios from 'axios'
import { defineStore } from 'pinia'

interface State {
    transcript: Transcript
    transcripts: Transcript[]
}

export const useTranscriptsStore = defineStore('transcripts', {
    state: (): State => ({
        transcript: {
            id: '',
            trimester: '',
            orphan_id: '',
            average: null,
            subjects: []
        }
    }),
    actions: {
        async getOrphanTranscript(orphanId: string, trimester: string) {
            await axios
                .get(route('tenant.transcripts.show'), {
                    params: {
                        orphan_id: orphanId,
                        trimester: trimester
                    }
                })
                .then((res) => {
                    this.transcript = res.data.transcript
                })
        },

        async getTranscriptSubjects(orphanId: string) {
            await axios.get(route('tenant.transcripts.transcript-subjects', orphanId)).then((res) => {
                console.log(res.data)

                this.transcript.subjects = res.data.subjects
            })
        }
    }
})
