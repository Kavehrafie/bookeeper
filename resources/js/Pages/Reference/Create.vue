<template>
    <AppLayout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Create a new reference
                </h2>
                <div class="flex ml-auto mr-0">
                    <!-- create a new code -->
<!--                    <inertia-link ></inertia-link>-->
<!--                    <t-toolbar-button type="button" :data="form" :href="route('references.store')" method="post">Create</t-toolbar-button>-->
                    <inertia-link  as="button" :href="route('references.store')" method="post" :data="form">Save</inertia-link>
                </div>
            </div>
        </template>
        <form class="max-w-6xl mx-auto pb-10" >
            <Section description="Enter the primary fields." header="Primary fields">
                <div class="my-2 mx-4">
                    <jet-label for="type" value="Type" />
                    <t-select
                        id="type"
                        name="type"
                        placeholder="Select an entry type"
                        :options="types"
                        v-model="form.type"
                    ></t-select>
                </div>
            </Section>
            <Section description="Enter the primary fields." header="Primary fields">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="title" value="Title" />
                    <t-input id="title" name="title" v-model="form.title" />
                    <jet-input-error :message="errors.title" class="mt-2" />
                </div>
                <div class="mt-2 mb-4 mx-4" v-show="form.type === 'book chapter'">
                    <jet-label for="book_title" value="Book Title" />
                    <t-input id="book_title" name="book_title" v-model="form.book_title" />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="year" value="Year" />
                    <t-select
                        id="year"
                        name="year"
                        placeholder="Select an entry year"
                        :options="years"
                        v-model="form.year"
                    ></t-select>
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="city" value="City" />
                    <t-input id="city" name="city" v-model="form.city" />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="publisher" value="Publisher" />
                    <autocomplete  :items="publishers"
                                   v-model="form.publisher"
                                  />
<!--                    <tag-input id="publisher" :search="publishers" v-model="form.publisher" ></tag-input>-->
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="volume" value="Volume" />
                    <t-input id="volume" name="volume" v-model="form.volume" />
                </div>
                <div v-show="form.type === 'book chapter'" class="mt-2 mb-4 mx-4">
                    <jet-label for="pages" value="Pages" />
                    <t-input id="pages" name="pages" v-model="form.pages" />
                </div>
            </Section>
            <Section description="Journal section keeps information about the journal publication." header="Authors">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="authors" value="Authors" />
                    <tag-input id="authors" :search="authors" v-model="form.authors" @input="setCitationKey"></tag-input>
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="editors" value="Editors" />
                    <tag-input id="editors" :search="authors" v-model="form.editors" @input="setCitationKey"></tag-input>
                </div>
            </Section>
            <Section v-show="form.type === 'article'" description="Journal section keeps information about the journal publication." header="Journal fields">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="journal" value="Journal" />
                    <t-input id="journal" name="journal" v-model="form.journal" />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="issue" value="Issue" />
                    <t-input id="issue" name="issue"  v-model="form.issue" />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="pages" value="Pages" />
                    <t-input id="pages" name="pages" v-model="form.pages" />
                </div>
            </Section>
            <Section description="Journal section keeps information about the journal publication." header="Authors">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="tags" value="Tags" />
                    <tag-input id="tags" :search="tags" v-model="form.tags"></tag-input>
                </div>
            </Section>
            <Section description="Journal section keeps information about the journal publication." header="Journal fields">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="citation_key" value="Citation key" />
                    <t-input id="citation_key" name="citation_key" v-model="form.citation_key" />
                </div>
            </Section>
        </form>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Editor from "@/Components/Editor";
import Section from "@/Components/Section";
import JetLabel from "@/Jetstream/Label";
import Autocomplete from "@/Components/Autocomplete";
import TagInput from "@/Components/TagInput";
import JetInputError from "@/Jetstream/InputError";


export default {

    components: {TagInput, Autocomplete, Section, Editor, AppLayout, JetLabel, JetInputError},
    props: {
        authors: null,
        publishers: null,
        types: null,
        cities: null,
        errors: null,
        tags: null
    },
    data() {
        return {
            form: {
                title: '',
                type: 'book',
                notes: null,
                year: 2000,
                authors: [],
                editors: [],
                tags: [],
                publisher: '',
                citation_key: ''
            }
        }
    },
    mounted() {

    },
    methods: {
        range(start, end){
            return Array.from(Array(end + 1).keys()).slice(start);
        },
        setCitationKey() {
            if (this.form.authors.length) {
                this.form.citation_key = this.form.authors[0].split(', ').reverse().pop() + this.form.year
            }
            if (!this.form.authors.length && this.form.editors.length) {
                this.form.citation_key = this.form.editors[0].split(', ').reverse().pop() + this.form.year
            }
        }
    },
    computed: {
        years() {
            return this.range(1800, 2050)
        },

    },

}
</script>

<style scoped>

</style>
