<template>
    <section class="mt-2">
        <div class="pt-2 flex justify-between w-full">
            <h2 class="text-lg">{{header}}</h2>
            <p class="text-sm">{{description}}</p>
        </div>

        <div class="py-2">
            <slot></slot>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        header: '',
        description: '',
        transparent: false
    },

}
</script>

<style scoped>

</style>
