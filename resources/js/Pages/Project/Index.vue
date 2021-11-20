<template>
    <app-layout>
        <!-- header & title -->
        <template #title>
            Projects
        </template>

        <!-- toolbar actions: Add -->
        <template #toolbar>
            <!-- create a new code -->
            <t-button variant="link" @click="$inertia.get(route('projects.create'))">
                Create a New Project
            </t-button>
        </template>

        <div class="py-4 px-2 max-w-5xl gap-2 grid grid-cols-1 sm:grid-cols-2 md:grid-cols-2 lg:grid-cols-3">

        <div
            v-for="project in projects" :key="project.index"
            class="border border-gray-400 bg-white rounded-sm p-4 flex flex-col justify-between leading-normal">
                <div class="mb-8">
                    <div class="text-sm text-gray-600 flex items-center justify-between">
                        <div>
                            <svg class="fill-current text-gray-500 w-3 h-3 mr-2" xmlns="http://www.w3.org/2000/svg"
                                 viewBox="0 0 20 20">
                                <path
                                    d="M4 8V6a6 6 0 1 1 12 0v2h1a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2v-8c0-1.1.9-2 2-2h1zm5 6.73V17h2v-2.27a2 2 0 1 0-2 0zM7 6v2h6V6a3 3 0 0 0-6 0z"/>
                            </svg>
                            Members only
                        </div>
                        <div><button class="text-red-500 rounded-full hover:bg-gray-100 p-2 hover:ring-2 hover:ring-red-500 hover:ring-opacity-50"
                         @click="deleteProject(project.id)"
                        ><my-icon :size="24" name="bin" stroke-width="1.5"/></button></div>
                    </div>
                    <div class="text-gray-900 font-bold text-xl mb-2">{{ project.title }}</div>
                    <p class="text-box text-gray-700 overflow-ellipsis overflow-hidden" v-html="project.description"/>
                </div>
                <div class="flex items-center space-x-4">
                    <inertia-link :href="route('projects.edit', project.id)" class="text-sm">
                        Edit
                    </inertia-link>
                    <inertia-link :href="route('projects.collection.edit', project.id)" class="text-sm">
                        Manage Collection
                    </inertia-link>
                </div>
        </div>

        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import MyIcon from "@/Components/Icon";

export default {
    props: ['projects'],
    components: {
        AppLayout,
        MyIcon,
    },
    methods: {
        deleteProject(id) {
            this.$dialog.confirm('Delete Project?', 'This action cannot be undone.', 'info')
                .then((result) => {
                    if (result.isOk) {
                        this.$inertia.delete(route('projects.destroy', id))
                    }
                })
        }
    }
}
</script>

<style scoped>
    .text-box {
        max-height: 4em;
    }
</style>
