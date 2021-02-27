<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Codes
                </h2>
                <div class="flex ml-auto mr-0">
                    <!-- create a new code -->
                    <inertia-link :href="route('codes.create')" replace >Add</inertia-link>
                    <!--                    <t-toolbar-button :href.prevent="route('codes.create')">Add</t-toolbar-button>-->
                </div>
            </div>
        </template>


        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex w-full">
                    <div class="w-1/3 ml-auto mr-0 transition-all duration-100" :class="{'w-full': isSearchFocused}" >
                        <t-input class="rounded-r-none" placeholder="Search"
                                 @blur="isSearchFocused = false"
                                 @focus="isSearchFocused = true" v-model="form.search"/>
                    </div>
                    <t-button class="rounded-l-none rounded-r-none"
                              :disabled="!isFilterApplied"
                              @click="resetFilters"
                    >
                        <icon  strokeSize="2" name="filter"/></t-button>
                    <t-button class="rounded-l-none py-0" @click="isFilterMoreOptions = !isFilterMoreOptions">
                        <icon class="transform duration-100" strokeSize="2" name="chevron-down"/></t-button>
                </div>
                <div class="pt-4" v-show="isFilterMoreOptions">
                    <t-rich-select
                        :close-on-select="false"
                        :options="options"
                        multiple
                        placeholder="Select multiple options"
                        v-model="form.references"
                    >
                    </t-rich-select>
                </div>
                <div class="mt-6 bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <t-table
                        :data="tableData"
                        :headers="tableHeaders"
                    >
                        <template slot="row" slot-scope="props">
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-indigo-100 bg-opacity-25' : '']">
                                <td :class="props.tdClass">
                                    <div v-html="props.row.body"></div>
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.reference }}
                                </td>
                                <td :class="props.tdClass">
                                    <ul class="tag-list w-32 flex space-x-1 justify-start flex-wrap">
                                        <li v-for="tag in props.row.tags" :key="tag" >
                                            <button class="py-1 underline px-1 text-indigo-500 hover:text-indigo-400 duration-100 transition-color" @click="form.tags.push(tag)">
                                                {{ tag }}
                                            </button>
                                        </li>
                                    </ul>
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.pages }}
                                </td>
                                <td :class="[props.tdClass,  'w-24']">
                                    <div class="flex text-sm space-x-3">
                                       <span class="relative flex">
                                        <inertia-action-link :href="route('codes.reviews.edit', props.row.id)" >
                                            <icon name="chat" stroke-width="1.5" />
                                        </inertia-action-link>
                                            <span v-show="props.row.notes_count" class="absolute top-0 right-0 inline-flex items-center jus
                                            font-bold leading-none text-red-100 transform translate-x-1/2
                                            -translate-y-1/2 bg-red-600 rounded-full p-0.5 justify-center">
                                                {{ props.row.notes_count }}
                                            </span>
                                        </span>
                                        <inertia-action-link as="button" :href="route('codes.edit', props.row.id)">
                                            <icon name="edit" stroke-width="1.5" />
                                        </inertia-action-link>
                                        <button class="text-indigo-500 hover:text-black transform scale-110 transition duration-100 rounded-full p-1 hover:bg-indigo-200" @click="deleteCode(props.row.id)">
                                            <icon name="bin" stroke-width="1.5" />
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </t-table>
                </div>
                <div class="mt-2">
                    <t-pagination
                        v-model="currentPage"
                        :limit="5"
                        :per-page="codes.per_page"
                        :total-items="codes.total"
                        @change="paginate"
                    />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Icon from "@/Components/Icon";
import InertiaActionLink from "@/Components/InertiaActionLink";


export default {
    components: {InertiaActionLink, Icon, AppLayout},
    props: [
        'codes',
        'references',
        'filters',
        'current_id'
    ],
    data() {
        return {
            tableHeaders: ['Body', 'Reference', 'Tags', 'Pages', 'Actions'],
            currentPage: this.codes.current_page,
            isFilterMoreOptions: false,
            isSearchFocused: false,
            form: {
                search: '',
                references: [],
                tags: []
            }
        }
    },
    mounted() {

    },
    computed: {
        tableData() {
            return this.codes.data.map(el => ({
                id: el.id,
                body: el.body,
                reference: el.referenceTitle,
                tags: el.tags.map(e => e.name['en']),
                notes_count: el.notes_count,
                pages: el.pages,
            }))
        },
        isFilterApplied() {
          return this.form.references.length || this.form.tags.length || this.form.search.length
        },
        options() {
            return this.references.map(e => ({
                text: Object.values(e.authors).length ?
                    Object.values(e.authors)[0] + ". " + e.year + ". " + e.title : e.year + ". " + e.title,
                value: e.id,
            }))
        }
    },
    methods: {
        paginate(page_number) {
            this.currentPage = page_number
            this.$inertia.get(route('codes.index', {page: page_number}))
        },
        resetFilters() {
            this.form = {
                search: '',
                references: [],
                tags: []
            }
        },
        deleteCode(id){
            this.$inertia.delete(route('codes.destroy', id), {
                onBefore: () => confirm('Are you sure you want to delete this code?'),
            })
        },
    },
    watch: {
        form: {
            handler: _.throttle(function(){
                let query = _.pickBy(this.form)
                this.$inertia.get(route('codes.index'),
                    Object.keys(query).length ? query : {remember: 'forget'},
                    { preserveState: true })
            }, 150),
            deep: true
        }
    }

}
</script>
