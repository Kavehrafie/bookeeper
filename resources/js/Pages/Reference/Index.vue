<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Reference index page
                </h2>
                <div class="flex ml-auto mr-0">
                    <!-- create a new code -->
                    <t-toolbar-button :href.prevent="route('references.create')">Add</t-toolbar-button>
                </div>
            </div>
        </template>


        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <t-table
                        :data="tableData"
                        :headers="tableHeaders"
                    >
                        <template slot="row" slot-scope="props">
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-gray-100' : '']">
                                <td :class="props.tdClass">
                                    {{ props.row.title }}
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.authors }}
                                </td>
                                <td :class="props.tdClass">
                                    {{props.row.year}}
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.publisher }}
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.type }}
                                </td>
                                <td :class="props.tdClass">
                                    <inertia-link :href="route('references.edit',props.row.id)" >Edit</inertia-link>
                                </td>
                            </tr>
                        </template>
                    </t-table>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";

export default {
    components: {AppLayout},
    props: [
        'references'
    ],
    data() {
        return {
            tableHeaders: ['Title', 'Authors', 'Year', 'Publisher', 'Type',  'Actions'],
        }
    },
    mounted() {

    },
    computed: {
        tableData() {
            return this.references.map(el => ({
                id: el.id,
                title: el.title,
                publisher: el.publisher ? el.publisher.title : '',
                type: el.type,
                authors: Object.values(el.authors).reduce((acc, value, index) =>  (acc + (index > 0 ? ' & ' : '' ) + value )),
                year: el.year,
            }))
        }
    },
    methods: {}
}
</script>
