<template>
    <div>
        <!--        TODO: refracture such that the function to work independent of jet fields -->
        <jet-label :for="id">{{ label }} <span v-if="required" class="text-red-500">*</span></jet-label>
        <t-input :value="value"
                 :id="id"
                 ref="input"
                 v-bind="$attrs"
                 :variant="{'danger': error}"
                 name="title" required
                 @input="$emit('input', $event)"
        />
        <jet-input-error :message="error" class="mt-2"/>
    </div>
</template>
<script>
import JetInputError from "@/Jetstream/InputError"
import JetLabel from "@/Jetstream/Label"

export default {
    name: 'TextInput',
    components: {JetInputError, JetLabel},
    props: {
        label: {
            type: String,
            default: ""
        },
        error: {},
        value: {
            type: String,
            required: true
        },
        id: {
            type: String,
            default() {
                return `text-input-${this._uid}`
            },
        },
        required: {
            type: Boolean,
            default: false
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        select() {
            this.$refs.input.select()
        },
        setSelectionRange(start, end) {
            this.$refs.input.setSelectionRange(start, end)
        },
    }
}
</script>
