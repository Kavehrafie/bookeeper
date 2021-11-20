<template>
    <app-layout>
        <!-- header & title -->
        <template #title>
            {{ project.title }}
        </template>

        <!-- toolbar actions:  -->
        <template #toolbar>
            <div class="flex space-x-2">
                <t-button @click="addToCart">Add to Cart</t-button>
                <t-button @click="createANewGroup">New Section</t-button>
                <t-button @click="$inertia.get(route('projects.downloadCollection', project.id))">Download</t-button>
            </div>
        </template>


        <div v-for="(group, index) in project.codes" :key="index" class="mt-4">
            <template>
                <h3 v-if="!index" class="text-2xl text-medium ">No Section Asssigned</h3>
                <h3 v-else class="text-2xl text-medium ">{{index}}</h3>
            </template>
            <draggable :data-group="index" class="space-y-2" draggable=".draggable" group="codes" @end="dragEnd">
                <div v-for="item in group" :key="item.id"
                     :data-code="item.id"
                     class="draggable rounded-md bg-white shadow border-gray-500 py-3 px-2">
                    <p v-html="item.body"></p>
                    <span class="text-sm text-gray-500">{{item.referenceTitle}}</span>
                    <inertia-link class="text-red-500 text-sm"
                                  as="button"
                                  :href="route('projects.collection.delete',
                     [project.id, item.id])"
                    method="delete">Remove</inertia-link>
                </div>
            </draggable>
        </div>
        <div v-for="(newGroup, index) in newGroups" :key="index" class="">
            <h3 class="text-2xl text-medium ">{{newGroup}}</h3>
            <draggable :data-group="newGroup" class="space-y-2" draggable=".draggable" group="codes" @end="dragEnd">
            </draggable>
        </div>

    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import draggable from "vuedraggable";

export default {
    components: {
        AppLayout,
        draggable,
    },
    data() {
        return {
            newGroups: []
        }
    },
    props: ['project'],
    methods: {
        dragEnd(event) {
            const newGroup = event.to.dataset.group;
            const oldGroup = event.from.dataset.group;

            console.log(event)
            if (newGroup !== oldGroup || event.newIndex !== event.oldIndex) {
                this.$inertia.put(route('projects.updateCollection', [this.project.id, event.item.dataset.code]),{
                    oldGroup: oldGroup,
                    newGroup: newGroup,
                    oldIndex: event.oldIndex,
                    newIndex: event.newIndex,
                },{
                    onFinish: () => {
                        this.newGroups.splice(this.newGroups.indexOf(newGroup), 1)
                        console.log(this.newGroups)
                    }
                })
            }
        },
        addToCart() {
            this.$inertia.get(route('projects.showAddToCollection', this.project.id))
        },
        createANewGroup() {
            return this.$dialog.prompt({
                title: 'New Group',
                text: 'Enter the new group title.',
                icon: 'question',
            }).then((result) => {
                if (result.isOk) {
                    this.newGroups.push(result.input)
                }
            })
        }
    },
    computed: {
        tableData() {
            return this.project.codes.map(el => ({
                id: el.id,
                body: el.body,
                reference: el.referenceTitle,
                tags: el.tags.map(e => e.name['en']),
                pages: el.pages,
            }))
        }
    },
    mounted() {
        console.log(this.project.codes)
    },

}
</script>

<style scoped>

</style>
