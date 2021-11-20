<template>
    <div class="flex">
        <t-input classes="border-r-0 border-gray-300 rounded-r-none" v-bind="$attrs"
                 ref="input" :value="valueInput" @keyup.up.prevent="stepUpDown(step)" @keyup.down.prevent="stepUpDown(-step)"
                 @input="$emit('input', $event)">
            <slot></slot>
        </t-input>
        <div class="divide-y">
            <t-button @click.prevent="stepUpDown(step)" class="rounded-b-none rounded-l-none text-sm pt-0 pb-0" ><icon name="chevron-up"></icon></t-button>
            <t-button @click.prevent="stepUpDown(-step)" class="rounded-t-none rounded-l-none text-sm pt-0 pb-0" ><icon name="chevron-down"></icon></t-button>
        </div>
    </div>
</template>

<script>
import Icon from "@/Components/Icon";

export default {

    components: {Icon,},
    props: {
        value: {
            default: 0
        },

        step: {
            default: 1
        },
        min: {
            default: null
        },
        max: {
            default: null
        }
    },
    data() {
        return {
            valueInput: this.value
        }
    },
    methods: {
        stepUpDown(step) {
            if (this.max) {
                this.valueInput = this.valueInput + step > this.max ? this.max : this.valueInput + step
            }
            if (this.min) {
                this.valueInput = this.valueInput + step < this.min ? this.min : this.valueInput + step
            }
        }
    },
    watch: {
        value:  _.throttle(function(val) {
            const num = Number(val);
            if (num) {
                this.valueInput = num
            }
        })
    }
}

</script>

<style scoped>

</style>
