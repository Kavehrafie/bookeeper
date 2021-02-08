<template>
    <section class="grid grid-cols-12 gap-4 pt-5">
        <div class="col-span-12 md:col-span-4">
            <h2>{{header}}</h2>
            <p>{{description}}</p>
        </div>
        <div class="col-span-8 bg-white rounded shadow-sm">
            <slot></slot>
        </div>
    </section>
</template>

<script>
export default {
    props: {
        header: '',
        description: ''
    }
}
</script>

<style scoped>

</style>
