<template>
    <AppLayout>
        <template #title>
            <div class="flex">
                <h2 class="font-semibold text-2xl text-indigo-800 leading-tight">
                    <span class="text-gray-400">Edit</span> Code ID: {{code.id }}
                </h2>
            </div>
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button @click="$inertia.get(route('codes.index'))" variant="secondary">Cancel</t-button>
                <t-button @click="$inertia.put(route('codes.update', code.id), form)">Update</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto">
            <Section description="Enter the passage here." header="Body">
                <div class="border border-gray-200 px-3 py-4 rounded h-64">
                    <editor v-model="form.body"></editor>
                </div>
            </Section>

            <Section description="Select or create a new reference." header="Reference">

                <div class="flex m-4 space-x-4">
                    <div class="w-2/3">
                        <label class="text-gray-500">Reference</label>
                        <t-select
                            v-model="form.reference_id"
                            :options="refOptions"
                            placeholder="Select a reference"
                            required
                        ></t-select>
                    </div>
                    <div class="">
                        <label class="text-gray-500">Page number</label>
                        <t-input id="pages" autocomplete="pages" v-model="form.pages" type="text"/>
                    </div>
                </div>
            </Section>
            <Section description="Enter tags for future search." header="Tags">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="tags" value="Tags" />
                    <tag-input id="tags" :search="tags" v-model="form.tags"></tag-input>
                </div>
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
            return this.references.map( el => ({
                value: el.id,
                text: Object.values(el.authors).reduce(
                    (acc, cur, index) =>  acc + (index ? '; ' : '' ) + cur, '') + '. ' + el.year + '. '+ el.title
            }))
        },
    },
    methods: {
    }
}
</script>

<style scoped>

</style>
