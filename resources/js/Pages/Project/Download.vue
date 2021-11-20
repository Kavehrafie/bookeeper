<template>
    <!-- Note that the visual style of the example comes from a custom theme made for this docs -->
    <t-modal
        :value="true"
        header="Download"
        @closed="$inertia.get(route('projects.collection.edit', project.id))"
    >

        <p>The file is downlaodable in this link:</p>
        <a :href="$page.props.download.link">{{$page.props.download.title}}</a>

        <template v-slot:footer>
            <div class="flex justify-between">
                <t-button type="button">
                    Ok
                </t-button>
            </div>
        </template>
    </t-modal>
</template>

<script>
export default {
    props: ['project']
}
</script>

<style scoped>

</style>
