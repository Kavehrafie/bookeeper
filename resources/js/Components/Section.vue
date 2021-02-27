<template>
    <section class="grid grid-cols-12 gap-4 pt-5">
        <div class="col-span-12 md:col-span-4">
            <h2>{{header}}</h2>
            <p>{{description}}</p>
        </div>
        <div class="col-span-8" :class="[transparent ? '' : bgClasses]">
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
    data() {
        return {
            bgClasses: 'bg-white rounded shadow-sm'
        }
    }
}
</script>

<style scoped>

</style>
