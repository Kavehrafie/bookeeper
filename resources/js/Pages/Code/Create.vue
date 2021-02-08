<template>
    <AppLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create a new Code
                </h2>
                <div class="flex ml-auto mr-0">
                    <!-- create a new code -->
                    <inertia-link  as="button" :href="route('codes.store')" method="post" :data="form">Create</inertia-link>
                </div>
            </div>
        </template>
        <form class="max-w-6xl mx-auto">
            <Section description="Enter the passage here." header="Body">
                <div class="border border-gray-200 px-3 py-4 rounded h-64">
                    <editor @input="bodyInput"></editor>
                </div>
            </Section>

            <Section description="Select or create a new reference." header="Reference">

                <div class="flex m-4 space-x-4">
                    <div class="w-2/3">
                        <label class="text-gray-500">Reference</label>
                        <t-rich-select
                            v-model="form.reference_id"
                            :options="refOptions"
                            placeholder="Select multiple options"
                        ></t-rich-select>
                    </div>
                    <div class="">
                        <label class="text-gray-500">Page number</label>
                        <t-input id="pages" autocomplete="pages" v-model="form.pages" type="text"/>
                    </div>
                </div>



                <!--                <div class="">-->
                <!--                    <t-button @click.prevent="$inertia.post(route('references.create.modal', form))">Add a new reference_id-->
                <!--                    </t-button>-->
                <!--                </div>-->

                <!--                <Component-->
                <!--                    v-bind="$page.props"-->
                <!--                    v-if="$root.modalComponent"-->
                <!--                    :is="$root.modalComponent"-->
                <!--                />-->

                <!--                    <inertia-link :href=">create</inertia-link>-->
            </Section>
            <Section description="Journal section keeps information about the journal publication." header="Authors">
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
        console.log(this.tags)
    },
    computed: {
        refOptions() {
            let options = {}
            this.references.forEach(el => {
                options[el.id] = Object.values(el.authors).reduce((acc, cur) =>  acc + ' & ' + cur) + '. ' + el.years + '. '+ el.title
            })
            console.log(options)
            return options
        }
    },
    methods: {
        bodyInput(body) {
            this.$set(this.form, 'body', body)
        }
    }
}
</script>

<style scoped>

</style>
