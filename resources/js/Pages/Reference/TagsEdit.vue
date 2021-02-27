<template>
    <t-modal header="Add a new reference." :value="true" :variants="{wrapper: 'z-50 max-w-3xl px-3 py-12'}">

        <p>TEST {{data}}</p>
        <!-- Author -->

<!--        <label for="authors">Author(s)</label>-->
<!--        <tag-input :initTags="['amanda, flex', 'jim, jorge']"></tag-input>-->



<!--        &lt;!&ndash; City &ndash;&gt;-->
<!--        <label for="city">City</label>-->
<!--        <autocomplete id="city" :items="['Chicago', 'Tehran', 'New York']"></autocomplete>-->



        <!--        <t-input id="title" v-model="form.title" name=title" />-->

        <template v-slot:footer>
            <div class="flex justify-end space-x-2">
                <t-button type="button">
                    Cancel
                </t-button>
                <t-button type="button">
                    Ok
                </t-button>
            </div>
        </template>
    </t-modal>
</template>

<script>
import Autocomplete from "@/Components/Autocomplete";
import TagInput from "@/Components/TagInput";
export default {
    components: {TagInput, Autocomplete},
    props: {
        data: null
    },
    data() {
        return {
            form: {
                title: "",
                year: 0,
            }
        }
    },
    methods: {

    },
    computed: {

    }
}
</script>

<style scoped>

</style>
