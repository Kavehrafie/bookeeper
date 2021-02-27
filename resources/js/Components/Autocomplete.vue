<template>
    <div class="relative border-none p-0 w-full">
        <input
            :id="id"
            :class="variantClasses"
            type="text"
            ref="input"
            @keydown.down="onArrowDown"
            @keydown.up="onArrowUp"
            @keydown.enter="onEnter"
            v-model="search"
            @input="onChange"
            @focus="$emit('focus')"
            @blur="isOpen = false, $emit('blur')"
            :placeholder="placeholder"
        />
        <ul class="rounded w-48 overflow-auto max-h-20 border border-gray-300 absolute z-10 bg-white"
            v-show="(results.length && isOpen)">
            <li
                class="loading"
                v-if="isLoading">
                Loading results...
            </li>
            <li class="text-left px-3 py-1 cursor-pointer hover:bg-gray-100 transition duration-200"
                v-for="(result, i) in results"
                :key="i"
                :class="{ 'is-active bg-gray-100': i === arrowCounter }"
                @click="setResult(result)"
            >
                {{ result }}
            </li>
        </ul>
    </div>
</template>

<script>
export default {
    props: {
        id: {
            type: String,
            default: ''
        },
        value: {
            type: String,
            default: ''
        },
        items: {
            type: Array,
            required: false,
            default: () => [],
        },
        isAsync: {
            type: Boolean,
            required: false,
            default: false,
        },
        variant: {
            type: String,
            default: 'default'
        },
        placeholder: {
            type: String,
            default: ''
        }
    },
    data() {
        return {
            search: this.value,
            results: [],
            isOpen: false,
            isLoading: false,
            arrowCounter: -1,

        }
    },
    mounted() {
        document.addEventListener('click', this.handleClickOutside);
    },
    destroyed() {
        document.removeEventListener('click', this.handleClickOutside);
    },
    computed: {
        variantClasses() {
            return {
                "w-full border-gray-300 focus:border-indigo-300 focus:ring-2 focus:ring-blue-500 focus:outline-none focus:ring-opacity-50 rounded-md shadow-sm": this.variant === 'default',
                "w-full border-none bg-transparent focus:border-none focus:ring-0": this.variant === 'transparent'
            }
        }
    },
    methods: {
        focus() {
            this.$refs.input.focus()
        },
        filterResults() {

            this.results = this.items.filter(item => {
                return item.toLowerCase().indexOf(this.search.toLowerCase()) > -1});
        },
        setResult(result) {
            this.search = result
            this.isOpen = false;
            this.$emit('input', result)
        },
        onArrowDown() {
            if (this.arrowCounter < this.results.length) {
                this.arrowCounter = this.arrowCounter + 1;
            }
        },
        onArrowUp() {
            if (this.arrowCounter > 0) {
                this.arrowCounter = this.arrowCounter - 1;
            }
        },
        onEnter(event) {

            this.search = this.results[this.arrowCounter];
            this.isOpen = false;
            this.arrowCounter = -1;

            event.preventDefault()
            // event.target.nextElementSibling.focus()
        },
        handleClickOutside(evt) {
            if (!this.$el.contains(evt.target)) {
                this.isOpen = false;
                this.arrowCounter = -1;
            }
        },
        onChange: _.debounce(function (e) {
            // Let's warn the parent that a change was made
            this.$emit('input', this.search);

            // Is the data given by an outside ajax request?
            if (this.isAsync) {
                this.isLoading = true;
            } else {
                // Data is sync, we can search our flat array
                this.filterResults();
                this.isOpen = true;
            }

        }, 200),

    },
    watch: {
        // Once the items content changes, it means the parent component
        // provided the needed data
        items: function (value, oldValue) {
            // we want to make sure we only do this when it's an async request
            if (this.isAsync) {
                this.results = value;
                this.isOpen = true;
                this.isLoading = false;
            }
        }
    }
}
</script>
