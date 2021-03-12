<template>
  <inertia-link
      v-bind="$attrs"
      class="text-purple-500 hover:text-black transform scale-110 transition-all duration-100 rounded-full p-1 hover:bg-purple-200 focus:scale-110"
      :variant="variant">
    <slot></slot>
  </inertia-link>
</template>
<script>
import Icon from "@/Components/Icon"

export default {
  name: 'InertiaActionLink',
  components: {Icon},
  props: {
    variant: {
        type: String,
        default: 'link'
    }
  }
}
</script>
