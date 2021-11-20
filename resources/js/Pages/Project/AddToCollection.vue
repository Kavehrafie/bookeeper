<template>
    <t-modal
        v-model="isModal"
        header="Create a New Project"
        variant="large"
        @closed="$inertia.get(route('projects.collection.edit', project.id))"
    >
        <p class="text-gray-700">Click on the passage to add to the collection.</p>
        <div  scroll-region ref="container" class="border-t height-max mt-2 pt-2 overflow-y-scroll overflow-x-hidden pr-2">
            <div class="text-center text-gray-500 m-auto" :style="{height: dummyTopHeight + 'px'}">
                Load previous codes...
            </div>
            <ul class="space-y-3">
                <li v-for="row in tableData" :key="row.id">
                    <button
                        class="rounded text-left p-2 hover:bg-gray-100 bg-white shadow-sm border border-gray-300 text-gray-900 w-full"
                        @click.prevent="addTo(row.id)">
                        <div v-html="row.body"></div>
                        <div class="tag-list inline-flex space-x-1 justify-start flex-wrap">
                           <span v-for="tag in row.tags" :key="tag" class="text-sm text-gray-700 break-all">
                               {{ tag }}
                           </span>
                        </div>
                    </button>
                </li>
            </ul>
            <div :style="{height: dummyBottomHeight + 'px'}"></div>
        </div>
    </t-modal>
</template>

<script>
import Label from "@/Jetstream/Label";
import InputError from "@/Jetstream/InputError";
import Editor from "@/Components/Editor";

export default {
    props: ['errors', 'project', 'codes'],
    components: {
        JetLabel: Label,
        JetInputError: InputError,
        Editor,

    },
    data() {

        return {
            tableHeaders: ['Body', 'Reference', 'Tags'],
            isModal: true,
            form: this.$inertia.form({
                title: '',
                description: '',
            }),
            tableData: this.format(),
            dummyBottomHeight: 0,
            dummyTopHeight: 0,
        }
    },

    mounted() {
        if (this.codes.prev_page_url) {
            this.dummyTopHeight = 50;
        }
        this.$refs.container.scrollTop = this.dummyTopHeight;
        this.dummyBottomHeight = this.$refs?.container.scrollHeight < 500 ? 500 - this.$refs?.container.scrollHeight : 0;
        this.getNextCodes()
    },
    methods: {
        format() {
            return this.codes.data.map(el => ({
                id: el.id,
                body: el.body,
                reference: el.referenceTitle,
                tags: el.tags.map(e => e.name['en']),
            }))
        },
        addTo(codeId) {
            this.$inertia.post(route('projects.storeAddToCollection', this.project.id),
                {id: codeId},
                {
                    onSuccess: () => {
                    }
                })
        },
        cancel() {
            this.$inertia.get(route('projects.index'))
        },
        create() {
            this.form.post(route('projects.store'))
        },
        getNextCodes() {
            this.$refs.container.addEventListener('scroll', _.debounce(
                () => {
                    let bottomOfWindow = this.$refs.container.clientHeight + this.$refs.container.scrollTop === this.$refs.container.scrollHeight;

                    if (bottomOfWindow && this.codes.next_page_url) {
                        this.$inertia.visit(this.codes.next_page_url, { preserveScroll: true })
                    }

                    if (!this.$refs.container.scrollTop) {
                        this.$inertia.visit(this.codes.prev_page_url, { preserveScroll: true })
                    }
                }
                , 200));
        }
    }
}
</script>

<style scoped>
.height-max {
    max-height: calc(100vh - 12.5rem);
}
</style>
