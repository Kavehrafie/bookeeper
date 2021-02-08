<template>

    <svg v-if="name === 'bin'" role="img" xmlns="http://www.w3.org/2000/svg"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize" stroke-linecap="square" stroke-linejoin="miter"
         class="stroke-current"
         viewBox="0 0 24 24" aria-labelledby="binIconTitle"
         fill="none"><title id="binIconTitle">Bin</title>
        <path
            d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/>
    </svg>

    <svg v-else-if="name === 'crop'" role="img" xmlns="http://www.w3.org/2000/svg"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize" stroke-linecap="square" stroke-linejoin="miter"
         class="stroke-current"
         viewBox="0 0 24 24" aria-labelledby="cropIconTitle"
         fill="none"><title id="cropIconTitle">Crop</title>
        <polyline points="17 3 17 17 3 17"/>
        <polyline points="7 21 7 7 21 7"/>
    </svg>

    <svg v-else-if="name === 'edit'" role="img" xmlns="http://www.w3.org/2000/svg"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         viewBox="0 0 24 24"
         aria-labelledby="editIconTitle"
         stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="editIconTitle">Edit</title>
        <path
            d="M18.4142136 4.41421356L19.5857864 5.58578644C20.366835 6.36683502 20.366835 7.63316498 19.5857864 8.41421356L8 20 4 20 4 16 15.5857864 4.41421356C16.366835 3.63316498 17.633165 3.63316498 18.4142136 4.41421356zM14 6L18 10"/>
    </svg>

    <svg v-else-if="name === 'save'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="saveIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="saveIconTitle">Save</title>
        <path
            d="M17.2928932,3.29289322 L21,7 L21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 L16.5857864,3 C16.8510029,3 17.1053568,3.10535684 17.2928932,3.29289322 Z"/>
        <rect width="10" height="8" x="7" y="13"/>
        <rect width="8" height="5" x="8" y="3"/>
    </svg>

    <svg v-else-if="name === 'plus' " role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="plusIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="plusIconTitle">Plus</title>
        <path d="M20 12L4 12M12 4L12 20"/>
    </svg>

    <svg v-else-if="name === 'chevron-right'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="chevronRightIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="chevronRightIconTitle">Chevron Right</title>
        <polyline points="10 6 16 12 10 18 10 18"/>
    </svg>

    <svg v-else-if="name === 'chevron-left'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="chevronLeftIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="chevronLeftIconTitle">Chevron Left</title>
        <polyline points="14 18 8 12 14 6 14 6"/>
    </svg>

    <svg v-else-if="name === 'ellypsis'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="ellypsisVerticalIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="ellypsisVerticalIconTitle">Ellypsis</title>
        <path
            d="M11 12C11 11.4477153 11.4477153 11 12 11 12.5522847 11 13 11.4477153 13 12 13 12.5522847 12.5522847 13 12 13 11.4477153 13 11 12.5522847 11 12zM11 6C11 5.44771525 11.4477153 5 12 5 12.5522847 5 13 5.44771525 13 6 13 6.55228475 12.5522847 7 12 7 11.4477153 7 11 6.55228475 11 6zM11 18C11 17.4477153 11.4477153 17 12 17 12.5522847 17 13 17.4477153 13 18 13 18.5522847 12.5522847 19 12 19 11.4477153 19 11 18.5522847 11 18z"/>
    </svg>

    <svg v-else-if="name === 'chevron-down'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="chevronDownIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none"><title id="chevronDownIconTitle">Chevron Down</title>
        <polyline points="6 10 12 16 18 10"/>
    </svg>

    <svg v-else-if="name === 'cancel'" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
         :width='size + "px"' :height='size + "px"'
         :stroke-width="strokeSize"
         class="stroke-current"
         aria-labelledby="cancelIconTitle" stroke-linecap="square"
         stroke-linejoin="miter" fill="none" ><title id="cancelIconTitle">Cancel</title>
        <path d="M15.5355339 15.5355339L8.46446609 8.46446609M15.5355339 8.46446609L8.46446609 15.5355339"/>
        <path
            d="M4.92893219,19.0710678 C1.02368927,15.1658249 1.02368927,8.83417511 4.92893219,4.92893219 C8.83417511,1.02368927 15.1658249,1.02368927 19.0710678,4.92893219 C22.9763107,8.83417511 22.9763107,15.1658249 19.0710678,19.0710678 C15.1658249,22.9763107 8.83417511,22.9763107 4.92893219,19.0710678 Z"/>
    </svg>
</template>
<script>
export default {
    name: 'Icon',
    props: {
        name: {
            type: String,
            default: 'bin'
        },
        strokeSize: {
            default: 1,
        },
        size: {
            default: 20
        }
    }
}
</script>
