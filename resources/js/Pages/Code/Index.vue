<template>
    <app-layout>
        <template #header>
            <div class="flex">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    Codes
                </h2>
                <div class="flex ml-auto mr-0">
                    <!-- create a new code -->
                    <inertia-link :href="route('codes.create')">Add</inertia-link>
<!--                    <t-toolbar-button :href.prevent="route('codes.create')">Add</t-toolbar-button>-->
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
                            <tr :class="[props.trClass, props.rowIndex % 2 === 0 ? 'bg-indigo-100 bg-opacity-25' : '']">
                                <td :class="props.tdClass">
                                    <div v-html="props.row.body"></div>
                                </td>
                                <td :class="props.tdClass">
                                    {{ props.row.reference }}
                                </td>
                                <td :class="props.tdClass">
                                    <div class="flex space-x-1" v-for="tag in props.row.tags" :key="tag">
                                        <inertia-link class="text-indigo-500 hover:text-red-500 transition-color duration-200" replace :href="route('codes.index', {tag: tag})">{{tag}}</inertia-link>
                                    </div>
                                </td>
                                <td :class="props.tdClass">
                                    {{props.row.pages}}
                                </td>
<!--                                <td :class="props.tdClass">-->
<!--                                    <inertia-link :href="route('references.edit',props.row.id)" >Edit</inertia-link>-->
<!--                                </td>-->
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
        'codes'
    ],
    data() {
        return {
            tableHeaders: ['Body', 'Reference', 'Tags', 'Pages'],
        }
    },
    mounted() {
        console.log(this.codes)
    },
    computed: {
        tableData() {
            return this.codes.map(el => ({
                id: el.id,
                body: el.body,
                reference: el.referenceTitle,
                tags: el.tags.map(e => e.name['en']),
                pages: el.pages,
            }))
        }
    },
    methods: {}
}
</script>
