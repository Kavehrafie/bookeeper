<template>
    <div>
        <div
            class="mt-2 flex space-x-1 border border-gray-300 rounded-md shadow-sm"
            :class="{'border-indigo-300 ring ring-indigo-200 ring-opacity-50': isFocused}">
            <div v-for='(tag, index) in inlineTags' :key='tag'
                 class='inline-flex bg-purple-500 text-white border border-white rounded-full text-sm h-7 px-1 my-auto first:ml-2'>
                <button :class="['mr-2 hover:bg-purple-400 transition duration-100 ease-in rounded-full my-1', tagClasses]"
                        @click="removeTag(index)">
                    <Icon name="cancel"></Icon>
                </button>
                <span class="mr-2 whitespace-nowrap my-auto pr-1">{{ tag }}</span>
            </div>
            <autocomplete variant="transparent" :items="search"
                                placeholder="tag, ..."
                                @keydown.enter.native='addTag'
                                @keydown.13.native='addTag'
                                @keydown.186.native='addTag'
                                @keydown.59.native='addTag'
                                @focus="isFocused = true"
                                @blur="isFocused = false"
                                @keydown.delete.native='removeLastTag'
                                @click='onClick'
            ></autocomplete>
        </div>
        <div v-show="otherTags.length" class="flex space-x-1 mt-2">
            <div v-for='(tag, index) in otherTags' :key='tag'
                 class='inline-flex bg-purple-500 text-white border border-white rounded-full text-sm py-1 px-1'>
                <button :class="['mr-2 hover:bg-purple-400 transition duration-100 ease-in rounded-full', tagClasses]"
                        @click="removeTag(index + sliceIndex)">
                    <Icon name="cancel"></Icon>
                </button>
                <span class="mr-2 whitespace-nowrap my-auto pr-1">{{ tag }}</span>
            </div>
        </div>
    </div>
</template>

<script>
import Autocomplete from "@/Components/Autocomplete";
import Icon from "@/Components/Icon";

export default {
    components: { Icon, Autocomplete},
    props: {
        search: {
            type: Array
        },
        value: {
            type: Array
        },
        tagClasses: {
            type: String
        }
    },
    data() {
        return {
            tags: this.value ? this.value : [],
            sliceIndex: 3,
            isFocused: false,
        }
    },
    computed: {
        otherTags() {
            return this.tags.slice(this.sliceIndex)
        },
        inlineTags() {
            return  this.tags.slice(0, this.sliceIndex)
        },
        showTagsOutside() {
            return this.sliceIndex <= this.tags.length
        }
    },
    methods: {
        onClick(value) {
            var val = value.trim()
            if (val.length > 0 && (this.tags.indexOf(val) === -1)) {

                this.tags.push(val)
                event.target.value = ''
            }
            this.update()
        },
        addTag(event) {
            event.preventDefault()
            var val = event.target.value.trim()
            if (val.length > 0 && (this.tags.indexOf(val) === -1)) {

                this.tags.push(val)
                event.target.value = ''
            }
            this.update()
        },
        removeTag(index) {
            this.tags.splice(index, 1)
            this.update()
        },
        removeLastTag(event) {
            if (event.target.value.length === 0) {
                this.removeTag(this.tags.length - 1)
            }
            this.update()
        },
        update() {
            this.$emit('input', this.tags)
        }
    }
}
</script>
