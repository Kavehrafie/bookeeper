<template>
    <t-modal
        v-model="isModal"
        header="Create a New Project"
        variant="large"
        @before-close="cancel"
    >
        <jet-label for="title">Title <span class="text-red-500">*</span></jet-label>
        <t-input v-model="form.title" label="Title"></t-input>
        <jet-input-error :message="errors.title" class="mt-2"/>

        <label class="text-gray-500">Description</label>
        <div>
            <editor v-model="form.description"/>
        </div>
        <template v-slot:footer>
            <div class="flex justify-end space-x-2">
                <t-button type="button" variant="secondary" @click="cancel">
                    Cancel
                </t-button>
                <t-button type="button" @click.prevent="update">
                    Update
                </t-button>
            </div>
        </template>
    </t-modal>
</template>

<script>
import Label from "@/Jetstream/Label";
import InputError from "@/Jetstream/InputError";
import Editor from "@/Components/Editor";

export default {
    props: ['errors'],
    components: {
        JetLabel: Label,
        JetInputError: InputError,
        Editor,

    },
    data() {
        return {
            isModal: true,
            form: this.$inertia.form({
                title: this.$page.props.project.title,
                description: this.$page.props.project.description,
            })
        }
    },

    methods: {
        cancel() {
            this.$inertia.get(route('projects.index'))

        },
        update() {
            this.form.put(route('projects.update', this.$page.props.project.id))
        }
    }
}
</script>

<style scoped>

</style>
