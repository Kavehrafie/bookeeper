<template>
    <app-layout>
        <template #title>
            <div class="flex">
                <h2 class="font-semibold text-2xl leading-tight">
                    Edit Notes
                </h2>
            </div>
        </template>
        <template #toolbar>
            <div class="flex justify-end w-full space-x-2">
                <!-- create a new code -->
                <t-button @click="$inertia.get(route('codes.index'))" variant="secondary">Cancel</t-button>
                <t-button @click="$inertia.put(route('codes.reviews.update', code.id), form)" >Update</t-button>
            </div>
        </template>

        <form class="max-w-6xl mx-auto">
            <Section :transparent="true" description="Primary code card information" header="Primary">
                <div class="px-3 py-4">
                    <div v-html="code.body"></div>
                </div>
                <div class="shadow-none flex space-x-2 bg-gray-100">
                    <span v-for="tag in code.tags" :key="tag.id" class="rounded-full px-3 py-1 bg-blue-300">
                        {{ tag.name.en }}
                    </span>
                </div>
            </Section>
            <Section :transparent="true" description="Notes that can be added in reviews" header="Notes">
                <div class="px-3 py-4">
                    <t-button @click.prevent="isCreateNoteModal = true">Add A New Note</t-button>
                </div>
                <div class="mt-2 mb-4 mx-4 rounded overflow-hidden">
                    <draggable v-model="notesEdit" draggable=".item">
                        <div v-for="(element, index) in notesEdit" :key="index" class="cursor-pointer item border border-b-gray-300">
                            <collapsible :title="element.title">
                                <template #actions>
                                    <t-button v-if="element.id"
                                              @click.prevent.stop="notesEdit.splice(index, 1)">
                                        <Icon name="bin"/></t-button>
                                    <t-button v-else @click.prevent.stop="notesEdit.splice(index, 1)"><Icon name="bin"/></t-button>
                                </template>
                                <span class="text-sm text-gray-500">
                                    {{ 'created_at' in element ? element.created_at : ''}}
                                </span>
                                <div v-html="element.description"></div>
                            </collapsible>
                        </div>
                    </draggable>
                </div>
            </section>
        </form>
        <portal to="modal">
            <t-modal
                v-model="isCreateNoteModal"
                header="Create a new note"
                variant="large"
            >
                <text-input v-model="title" label="Title"></text-input>

                <label class="text-gray-500">Description</label>
                <div>
                    <editor v-model="description"/>
                </div>
                <template v-slot:footer>
                    <div class="flex justify-end space-x-2">
                        <t-button type="button" variant="secondary">
                            Cancel
                        </t-button>
                        <t-button type="button" @click.prevent="addANote">
                            Create
                        </t-button>
                    </div>
                </template>
            </t-modal>
        </portal>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Section from "@/Components/Section";
import draggable from "vuedraggable";
import Editor from "@/Components/Editor";
import Collapsible from "@/Components/Collapsible";
import TextInput from "@/Components/TextInput";
import Icon from "@/Components/Icon";

export default {
    components: {Icon, TextInput, Collapsible, AppLayout, draggable, Section, Editor},
    props: {
        code: {},
        notes: null
    },
    mounted() {
        console.log(this.notes)
    },
    data() {
        return {
            isCreateNoteModal: false,
            title: "",
            description: "",
            order: 1,
            notesEdit: Object.values(this.notes).sort((a, b) => a.order - b.order),
        }
    },
    computed: {
        form() {
            return {
                notes: this.notesEdit.map( (el, i) =>  ({
                    id: el.id,
                    title: el.title,
                    description: el.description,
                    order: i + 1
                }))
            }
        }
    },
    methods: {
        addANote() {
            this.notesEdit.push({
                id: 0,
                title: this.title,
                description: this.description,
                order: this.order,
            })
            this.order = this.order + 1
            this.reset()
            this.closeModal()
        },
        reset() {
            this.title = ""
            this.description = ""
        },
        closeModal() {
            this.isCreateNoteModal  = false;
        },
    }
}
</script>

<style scoped>

</style>
