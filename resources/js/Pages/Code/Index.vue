<template>
    <app-layout>
        <template #title>Codes List</template>
        <template #toolbar>
            <div class="flex space-x-2 ml-auto mr-0">
                <!-- create a new code -->
                <t-button @click="$inertia.get(route('codes.create'))">Add</t-button>
                <div class="flex flex-auto">
                    <div :class="{'w-full': isSearchFocused}" class="w-1/3 ml-auto mr-0 transition-all duration-100">
                        <t-input v-model="form.search" class="rounded-r-none"
                                 placeholder="Search"
                                 @blur="isSearchFocused = false" @focus="isSearchFocused = true"/>
                    </div>
                    <t-button :disabled="!isFilterApplied"
                              class="rounded-l-none rounded-r-none"
                              @click="resetFilters"
                    >
                        <my-icon name="filter" strokeSize="2"/>
                    </t-button>
                    <t-button class="rounded-l-none py-0" @click="isFilterMoreOptions = !isFilterMoreOptions">
                        <my-icon class="transform duration-100" name="chevron-down" strokeSize="2"/>
                    </t-button>
                </div>
            </div>
            <div v-show="isFilterMoreOptions" class="pt-4">
                <t-rich-select
                    v-model="form.references"
                    :close-on-select="false"
                    :options="options"
                    multiple
                    placeholder="Select multiple options"
                >
                </t-rich-select>
            </div>
        </template>


        <div class="py-8">


            <t-table
                :data="tableData"
                :headers="tableHeaders"
            >
                <template slot="row" slot-scope="props">
                    <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-indigo-100 bg-opacity-25' : '']">
                        <td :class="props.tdClass">
                            <div v-html="props.row.body"></div>
                        </td>
                        <td :class="props.tdClass" class="text-sm w-12 overflow-ellipsis overflow-hidden">
                            {{ props.row.reference }}
                        </td>
                        <td :class="props.tdClass">
                            <ul class="tag-list w-32 inline-flex space-x-1 justify-start flex-wrap">
                                <li v-for="tag in props.row.tags" :key="tag">
                                    <button
                                        class="text-sm text-left break-words py-1 underline px-1 text-purple-500 hover:text-purple-800 duration-100 transition-color"
                                        @click="form.tags.push(tag)">
                                        {{ tag }}
                                    </button>
                                </li>
                            </ul>
                        </td>
                        <td :class="[props.tdClass, 'text-sm w-8']" >
                            {{ props.row.pages }}
                        </td>
                        <td :class="[props.tdClass,  'w-10']">
                            <t-dropdown variant="group">
                                <div slot="trigger"
                                     slot-scope="{
                                          mousedownHandler,
                                          focusHandler,
                                          blurHandler,
                                          keydownHandler,
                                          isShown
                                        }">
                                    <button
                                        id="user-menu"
                                        class="flex items-center p-1 text-sm text-gray-700 transition duration-150 ease-in-out rounded-full focus:outline-none focus:shadow-solid"
                                        :class="{ 'focus:border-gray-300 focus:bg-gray-500 hover:bg-gray-500 text-white ': isShown }"
                                        aria-label="User menu"
                                        aria-haspopup="true"
                                        @mousedown="mousedownHandler"
                                        @focus="focusHandler"
                                        @blur="blurHandler"
                                        @keydown="keydownHandler"
                                    >
                                        <my-icon size="24" name="ellypsis"></my-icon>
                                    </button>
                                </div>
                                <ul slot-scope="{ hide, blurHandler }">

                                        <li class="w-full"
                                            role="menuitem"
                                            @blur="blurHandler"
                                        >
                                            <inertia-link
                                                class="inline-flex w-full justify-between px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                :href="route('codes.reviews.edit', props.row.id)">
                                                <my-icon name="chat" stroke-width="1.5"/> Add notes
                                                <span :class="[props.row.notes_count ? 'text-red-200' : 'opacity-0']">
                                                    {{ props.row.notes_count }}
                                                </span>
                                            </inertia-link>
                                        </li>
                                    <li class="w-full"
                                        role="menuitem"
                                        @blur="blurHandler">
                                        <inertia-link
                                            class="inline-flex w-full justify-between items-left px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            :href="route('codes.edit', props.row.id)" as="button">
                                            <my-icon name="edit" stroke-width="1.5"/>
                                            Edit
                                            <span></span>
                                        </inertia-link>
                                    </li>
                                    <li class="w-full" role="medium" @blur="blurHandler">
                                        <button
                                            class="inline-flex w-full justify-between items-left px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            @click="deleteCode(props.row.id)">
                                            <my-icon name="bin" stroke-width="1.5"/>
                                            Delete
                                            <span></span>
                                        </button>

                                    </li>
                                </ul>
                            </t-dropdown>

                        </td>
                    </tr>
                </template>
            </t-table>

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
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MyIcon from "@/Components/Icon";
import InertiaActionLink from "@/Components/InertiaActionLink";


export default {
    components: {InertiaActionLink, MyIcon, AppLayout},
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
        deleteCode(id) {
            this.$inertia.delete(route('codes.destroy', id), {
                onBefore: () => confirm('Are you sure you want to delete this code?'),
            })
        },
    },
    watch: {
        form: {
            handler: _.throttle(function () {
                let query = _.pickBy(this.form)
                this.$inertia.get(route('codes.index'),
                    Object.keys(query).length ? query : {remember: 'forget'},
                    {preserveState: true})
            }, 150),
            deep: true
        }
    }

}
</script>
