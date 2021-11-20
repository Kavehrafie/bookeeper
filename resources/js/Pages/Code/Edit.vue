<template>
    <AppLayout>
        <template #title>
            Code ID: {{ code.id }}
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button variant="secondary" @click="$inertia.get(route('codes.index'))">Cancel</t-button>
                <t-button @click="$inertia.put(route('codes.update', code.id), form)">Update</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto">
            <Section description="Enter the passage here." header="Body">
                <jet-label class="hidden" for="body" value="Passage"></jet-label>
                <editor v-model="form.body" :autofocus="true"></editor>
            </Section>

            <Section description="Select or create a new reference." header="Reference">

                <div class="flex space-x-4">
                    <div class="w-2/3">
                        <jet-label for="select" value="Reference"></jet-label>
                        <t-select
                            v-model="form.reference_id"
                            :options="refOptions"
                            placeholder="Select a reference"
                            required
                        ></t-select>
                    </div>
                    <div class="flex-1">
                        <jet-label value="Page"/>
                        <t-input id="pages" v-model="form.pages" autocomplete="pages" type="text"/>
                    </div>
                </div>
            </Section>
            <Section description="Enter tags for future search." header="Tags">
                <jet-label for="tags" value="Tags"/>
                <tag-input id="tags" v-model="form.tags" :search="tags"></tag-input>
            </Section>
        </form>
    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Editor from "@/Components/Editor";
import Section from "@/Components/Section";
import TagInput from "@/Components/TagInput";
import JetLabel from "@/Jetstream/Label";


export default {

    components: {TagInput, Section, Editor, AppLayout, JetLabel},
    props: {
        code: null,
        references: null,
        tags: null,
    },
    data() {
        return {
            form: {
                body: this.code.body,
                reference_id: this.code.reference_id,
                tags: this.code.tags.map(el => el.name.en),
                pages: this.code.pages
            }
        }
    },
    mounted() {

    },
    computed: {
        refOptions() {
            return this.references.map(el => ({
                value: el.id,
                text: Object.values(el.authors).reduce(
                    (acc, cur, index) => acc + (index ? '; ' : '') + cur, '') + '. ' + el.year + '. ' + el.title
            }))
        },
    },
    methods: {}
}
</script>

<style scoped>

</style>
