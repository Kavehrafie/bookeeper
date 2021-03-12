<template>
    <app-layout>

        <!-- header & title -->
        <template #title>
            <div class="flex">
                <h2 class="font-semibold text-2xl text-gray-800 leading-tight">
                    References
                </h2>
            </div>
        </template>

        <!-- toolbar actions: Add -->
        <template #toolbar>
            <div class="flex justify-end ml-auto mr-0">
                <!-- create a new code -->
                <t-button @click="$inertia.get(route('references.create'))">Add</t-button>
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
                                <td :class="[props.tdClass, 'w-24']">
                                    <div class="flex text-sm space-x-3">
                                        <inertia-action-link :href="route('references.edit',props.row.id)">
                                            <icon name="edit" stroke-width="1.5"></icon>
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
        'references'
    ],
    data() {
        return {
            tableHeaders: ['Title', 'Authors', 'Year', 'Publisher', 'Type',  'Actions'],
        }
    },
    computed: {
        tableData() {
            return this.references.map(el => ({
                id: el.id,
                title: el.title,
                publisher: el.publisher ? el.publisher.title : '',
                type: el.type,
                authors: Object.values(el.authors).reduce((acc, value, index) =>  (acc + (index > 0 ? ' & ' : '' ) + value ), ''),
                year: el.year,
            }))
        }
    },
    methods: {
        deleteCode(id){
            this.$inertia.delete(route('references.destroy', id), {
                onBefore: () => confirm('Are you sure you want to delete this code?'),
            })
        },
    }
}
</script>
