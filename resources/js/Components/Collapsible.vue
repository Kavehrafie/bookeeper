<template>
    <div>
        <div class="flex bg-gray-300 hover:bg-gray-200 px-4 py-1 justify-between" @click="show = !show">
            <t-tag class="my-auto" :tag-name="tag" variant="h3">{{ title }}</t-tag>
            <div>{{subTitle}}</div>
            <div class="collapsible__actions">
                <slot name="actions"></slot>
            </div>
        </div>
        <div class="bg-white mb-2 px-6" v-show="show">
            <slot></slot>
        </div>
    </div>
</template>

<script>
export default {
name: "Collapsible",
    props: {
        tag: {
            default: 'h3'
        },
        title: {
            type: String,
        },
        subTitle: {
            type: String
        }
    },
    data() {
        return {
            show: false
        }
    }

}
</script>

