<template>
    <AppLayout>
        <template #title>
            Create a new Code
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button variant="secondary" @click="$inertia.get(route('codes.index'))">Cancel</t-button>
                <t-button @click="$inertia.post(route('codes.store'), form)">Create</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto">
            <Section description="Enter the passage here." header="Main">
                <jet-label class="hidden" for="body" value="Passage"></jet-label>
                <editor id="body" :autofocus="true" v-model="form.body"></editor>
            </Section>

            <Section description="Select or create a new reference." header="Reference">
                <div class="flex space-x-4">
                    <div class="w-2/3">
                        <jet-label for="select" value="Reference"></jet-label>
                        <t-rich-select
                            id="select"
                            v-model="form.reference_id"
                            :options="refOptions"
                            placeholder="Select multiple options"
                        ></t-rich-select>
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

    components: {
        TagInput,
        Section, Editor, AppLayout, JetLabel
    },
    props: {
        references: null,
        tags: null,
    },
    data() {
        return {
            form: {
                body: '',
                notes: null,
                reference_id: null,
                tags: [],
                pages: ''
            }
        }
    },
    mounted() {

    },
    computed: {
        refOptions() {
            let options = {}
            this.references.forEach(el => {
                let arr = Object.values(el.authors)
                if (Array.isArray(arr) && arr.length > 0) {
                    options[el.id] = arr.reduce((acc, cur) => acc + ' & ' + cur) + '. ' + el.year + '. ' + el.title
                }
            })
            return options
        }
    },
    methods: {

    }
}
</script>

<style scoped>

</style>
