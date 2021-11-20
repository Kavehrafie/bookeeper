<template>
    <AppLayout>
        <template #title>
            Create a New Reference
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button variant="secondary" @click="$inertia.get(route('references.index'))">Cancel</t-button>
                <t-button @click="$inertia.post(route('references.store'), form)">Create</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto pb-10">
            <Section description="Select the reference type." header="Type">
                <jet-label for="type" value="Type"/>
                <t-select
                    id="type"
                    v-model="form.type"
                    :options="types"
                    name="type"
                    placeholder="Select an entry type"
                ></t-select>
            </Section>
            <Section description="Enter the primary fields." header="Primary fields">
                <text-input v-model="form.title" :error="errors.title" :required="true" label="Title"/>

                <text-input v-show="form.type === 'book chapter'"
                            v-model="form.book_title"
                            :error="errors.book_title"
                            :required="true"
                            label="Book Title"/>

                <div class="mt-2">
                    <jet-label for="year" value="Year"/>
                    <int-input v-model="form.year" :maxlength="4" :min="1800" :minlength="4"></int-input>
                </div>

                <text-input v-model="form.city" :error="errors.city" class="mt-2" label="City"/>

                <div class="mt-2">
                    <jet-label for="publisher" value="Publisher"/>
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
                                    class="block w-full p-3 text-white bg-blue-500 border hover:bg-blue-600"
                                    type="button"
                                    @click="publishers.push(query); form.publisher = query"
                                >
                                    Create {{ query }}
                                </button>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.publisher" class="mt-2"/>
                </div>

                <text-input v-model="form.volume" :error="errors.volume" class="mt-2" label="Volume"/>

                <text-input v-show="form.type === 'book chapter'"
                            v-model="form.pages" :error="errors.pages" class="mt-2" label="Pages"/>
            </Section>

            <!-- authors -->
            <Section description="Enter the authors and editors." header="Authors">
                <div class="mt-2">
                    <jet-label for="authors" value="Authors"/>
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
                                    :class="createListBtnPassedClass"
                                    type="button"
                                    @click="createAuthor(query)"
                                >
                                    {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname,
                                    firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.authors"></jet-input-error>
                </div>

                <!-- editors -->
                <div class="mt-2">
                    <jet-label for="editors" value="Editors"/>
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
                                    :class="createListBtnPassedClass"
                                    type="button"
                                    @click="createEditor(query)"
                                >
                                    {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname,
                                    firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.editors"></jet-input-error>
                </div>

                <!-- translators -->
                <div class="mt-2">
                    <jet-label for="editors" value="Translators"/>
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
                                    :class="createListBtnPassedClass"
                                    type="button"
                                    @click="createTranslator(query)"
                                >
                                    {{ nameParser(query) }}
                                </button>
                                <div v-else class="block w-full p-3 text-white bg-red-500 border">
                                    <span class="text-sm">Incorrect input. Follow the pattern:  </span>lastname,
                                    firstname.
                                </div>
                            </div>
                        </template>
                    </t-rich-select>
                    <jet-input-error :message="errors.translators"></jet-input-error>
                </div>
            </Section>
            <Section v-show="form.type === 'article'"
                     description="Journal section keeps information about the journal publication."
                     header="Journal fields">

                <text-input v-model="form.journal" :error="errors.journal" class="mt-2" label="Journal"/>

                <text-input v-model="form.issue" :error="errors.issue" class="mt-2" label="Issue"/>

                <text-input v-model="form.pages" :error="errors.pages" class="mt-2" label="Pages"/>

            </Section>
            <Section description="This section contains tags and citation key" header="Meta Fields">
                <div class="mt-2">
                    <jet-label for="tags" value="Tags"/>
                    <tag-input id="tags" v-model="form.tags" :search="tags"></tag-input>
                </div>
                <div class="mt-2">
                    <jet-label for="citation_key" value="Citation key"/>
                    <t-input id="citation_key" v-model="form.citation_key" name="citation_key"/>
                </div>
            </Section>
        </form>

    </AppLayout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Section from "@/Components/Section";
import JetLabel from "@/Jetstream/Label";
import Autocomplete from "@/Components/Autocomplete";
import TagInput from "@/Components/TagInput";
import JetInputError from "@/Jetstream/InputError";
import TextInput from "@/Components/TextInput";
import IntInput from "@/Components/IntInput";


export default {

    components: {TextInput, TagInput, Autocomplete, Section, AppLayout, JetLabel, JetInputError, IntInput},
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
            createListBtnPassedClass: 'block w-full p-3 text-white bg-blue-500 border hover:bg-blue-600',
            createListBtnErrorClass: 'block w-full p-3 text-white bg-red-500 border hover:bg-red-600',
            form: {
                title: '',
                book_title: '',
                type: 'book',
                notes: null,
                year: 2000,
                city: '',
                authors: [],
                editors: [],
                translators: [],
                tags: [],
                publisher: '',
                citation_key: ''
            }
        }
    },
    mounted() {
    },
    methods: {
        range(start, end) {
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
            if (this.form.authors.length === 0) {
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

    },

}
</script>

