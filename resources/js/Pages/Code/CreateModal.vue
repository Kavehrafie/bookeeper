<template>

        <form action="submit" >


                <editor :init="form.body" @input="bodyChange"></editor>


        </form>

</template>

<script>



import Editor from "@/Components/Editor";
export default {
    components: {Editor},
    data() {
        return {
            form: {
                body: '<p>TESsT</p>',
                notes: null,
            },
            show: true
        }
    },
    methods: {
        submit() {
            this.$inertia.post(this.route('codes.create', this.from))
        },
        bodyChange(content) {
            console.log('dd')
            console.log(content)
        }

    }

}
</script>

<style scoped>

</style>
