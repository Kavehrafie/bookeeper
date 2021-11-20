<template>
    <AppLayout>
        <template #title>
            <div class="flex">
                <h2 class="font-semibold text-xl my-auto text-gray-800 leading-tight">
                    <span class="text-gray-400">Edit</span>  {{form.title}}
                </h2>

            </div>
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button @click="$inertia.get(route('references.index'))" variant="secondary">Cancel</t-button>
                <t-button @click="$inertia.put(route('references.update', reference.id), form)">Update</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto pb-10" >
            <Section description="Select the reference type." header="Type">
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
            <Section description="Enter the primary fields, title, etc." header="Primary fields">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="title">Title <span class="text-red-500">*</span></jet-label>
                    <t-input id="title" name="title" v-model="form.title" :variant="{'danger': errors.title}" required />
                    <jet-input-error :message="errors.title" class="mt-2" />
                </div>
                <div class="mt-2 mb-4 mx-4" v-show="form.type === 'book chapter'">
                    <jet-label for="book_title">Book Title <span class="text-red-500">*</span></jet-label>
                    <t-input id="book_title" name="book_title" v-model="form.book_title"  />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="year" value="Year" />
                    <int-input v-model="form.year" :minlength="4" :maxlength="4" :min="1800" ></int-input>
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="city" value="City" />
                    <t-input id="city" name="city" v-model="form.city" />
                </div>
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="publisher" value="Publisher" />
                    <t-rich-select
                        v-model="form.publisher"
                        :options="publishers"
                    >
                        <template
                            slot="dropdownDown"
                            slot-scope="{ query, selectedOption, options }"
                        >
                            <div
                                v-if="query"
                                class="text-center"
                            >
                                <button
                                    type="button"
                                    class="block w-full p-3 text-white bg-blue-500 border hover:bg-blue-600"
                                    @click="publishers.push(query); form.publisher = query"
                                >
                                    Create {{ query }}
                                </button>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.publisher" class="mt-2" />

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
            <Section description="The authors, editors and translators" header="Authors">

                <!-- authors -->
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="authors" value="Authors" />
                    <t-rich-select
                        v-model="form.authors"
                        :options="authors"
                        multiple
                    >
                        <template
                            slot="dropdownDown"
                            slot-scope="{ query, selectedOption, options }"
                        >
                            <div
                                v-if="query"
                                class="text-center"
                            >
                                <button
                                    v-if="query.split(', ').length === 2"
                                    type="button"
                                    :class="createListBtnPassedClass"
                                    @click="createAuthor(query)"
                                >
                                     {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname, firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.authors"></jet-input-error>
                </div>

                <!-- editors -->
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="editors" value="Editors" />
                    <t-rich-select
                        v-model="form.editors"
                        :options="authors"
                        multiple
                    >
                        <template
                            slot="dropdownDown"
                            slot-scope="{ query, selectedOption, options }"
                        >
                            <div
                                v-if="query"
                                class="text-center"
                            >
                                <button
                                    v-if="query.split(', ').length === 2"
                                    type="button"
                                    :class="createListBtnPassedClass"
                                    @click="createEditor(query)"
                                >
                                    {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname, firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.editors"></jet-input-error>
                </div>

                <!-- Translators -->
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="editors" value="Translators" />
                    <t-rich-select
                        v-model="form.translators"
                        :options="authors"
                        multiple
                    >
                        <template
                            slot="dropdownDown"
                            slot-scope="{ query, selectedOption, options }"
                        >
                            <div
                                v-if="query"
                                class="text-center"
                            >
                                <button
                                    v-if="query.split(', ').length === 2"
                                    type="button"
                                    :class="createListBtnPassedClass"
                                    @click="createTranslator(query)"
                                >
                                    {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname, firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.translators"></jet-input-error>
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
            <Section description="This section contains tags ans citation key" header="Meta fields">
                <div class="mt-2 mb-4 mx-4">
                    <jet-label for="tags" value="Tags" />
                    <tag-input id="tags" :search="tags" v-model="form.tags"></tag-input>
                </div>
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
import IntInput from "@/Components/IntInput";
import JetInputError from "@/Jetstream/InputError";


export default {

    components: {TagInput, Autocomplete, Section, Editor, AppLayout, JetLabel, JetInputError, IntInput},
    props: {
        reference: null,
        authors: null,
        publishers: null,
        types: null,
        cities: null,
        errors: null,
        tags: null
    },
    data() {
        return {
            createListBtnPassedClass: 'block w-full p-3 text-white bg-blue-500 border hover:bg-blue-600',
            createListBtnErrorClass: 'block w-full p-3 text-white bg-red-500 border hover:bg-red-600',
            test: 1900,
            form: {
                title: this.reference.title,
                book_title: this.reference.book_title,
                type: this.reference.type,
                notes: null,
                city: this.reference.city,
                volume: this.reference.volume,
                pages: this.reference.pages,
                year: this.reference.year,
                authors: Object.values(this.reference.authors),
                translators: Object.values(this.reference.translators),
                editors: Object.values(this.reference.editors),
                tags: this.reference.tags.map(el => el.name.en),
                journal: this.reference.journal,
                publisher: this.reference.publisher.title,
                citation_key: ''
            }
        }
    },
    mounted() {
        console.log(this.reference, this.tags)
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
        },
        createAuthor(value) {
            this.authors.push(value)
            this.form.authors.push(value)
            this.setCitationKey()
        },
        createEditor(value) {
            this.authors.push(value)
            this.form.editors.push(value)
            if (this.form.authors.length === 0 ) {
                this.setCitationKey()
            }
        },
        createTranslator(value) {
            this.authors.push(value)
            this.form.translators.push(value)
        },
        isNameValidated(value) {
            let arr = value.split(', ')
            return arr.length === 2
        },
        nameParser(value) {
            let arr = value.split(', ')
            if (arr.length === 2) {
                return `Create first name: ${arr[1]} | last name: ${arr[0]}`;
            } else {
                return "Incorrect input. Follow the pattern e.g. lastname, firstname."
            }
        }
    },
    computed: {
        years() {
            return this.range(1800, 2050)
        },
        currentYear() {
            const year = new Date().getFullYear()
            return year
        }

    },

}
</script>

<style scoped>

</style>
