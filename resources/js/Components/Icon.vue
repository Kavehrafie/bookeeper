<template>

    <svg v-if="name === 'bin'" :height='size + "px"' :stroke-width="strokeSize"
         :width='size + "px"' aria-labelledby="binIconTitle"
         class="stroke-current" fill="none" role="img"
         stroke-linecap="square"
         stroke-linejoin="miter" viewBox="0 0 24 24"
         xmlns="http://www.w3.org/2000/svg"><title id="binIconTitle">Bin</title>
        <path
            d="M19 6L5 6M14 5L10 5M6 10L6 20C6 20.6666667 6.33333333 21 7 21 7.66666667 21 11 21 17 21 17.6666667 21 18 20.6666667 18 20 18 19.3333333 18 16 18 10"/>
    </svg>

    <svg v-else-if="name === 'crop'" :height='size + "px"' :stroke-width="strokeSize"
         :width='size + "px"' aria-labelledby="cropIconTitle"
         class="stroke-current" fill="none" role="img"
         stroke-linecap="square"
         stroke-linejoin="miter" viewBox="0 0 24 24"
         xmlns="http://www.w3.org/2000/svg"><title id="cropIconTitle">Crop</title>
        <polyline points="17 3 17 17 3 17"/>
        <polyline points="7 21 7 7 21 7"/>
    </svg>

    <svg v-else-if="name === 'edit'" :height='size + "px"' :stroke-width="strokeSize"
         :width='size + "px"' aria-labelledby="editIconTitle"
         class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square"
         stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="editIconTitle">Edit</title>
        <path
            d="M18.4142136 4.41421356L19.5857864 5.58578644C20.366835 6.36683502 20.366835 7.63316498 19.5857864 8.41421356L8 20 4 20 4 16 15.5857864 4.41421356C16.366835 3.63316498 17.633165 3.63316498 18.4142136 4.41421356zM14 6L18 10"/>
    </svg>

    <svg v-else-if="name === 'save'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="saveIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="saveIconTitle">Save</title>
        <path
            d="M17.2928932,3.29289322 L21,7 L21,20 C21,20.5522847 20.5522847,21 20,21 L4,21 C3.44771525,21 3,20.5522847 3,20 L3,4 C3,3.44771525 3.44771525,3 4,3 L16.5857864,3 C16.8510029,3 17.1053568,3.10535684 17.2928932,3.29289322 Z"/>
        <rect height="8" width="10" x="7" y="13"/>
        <rect height="5" width="8" x="8" y="3"/>
    </svg>

    <svg v-else-if="name === 'plus' " :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="plusIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="plusIconTitle">Plus</title>
        <path d="M20 12L4 12M12 4L12 20"/>
    </svg>

    <svg v-else-if="name === 'chevron-right'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="chevronRightIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="chevronRightIconTitle">Chevron Right</title>
        <polyline points="10 6 16 12 10 18 10 18"/>
    </svg>

    <svg v-else-if="name === 'chevron-left'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="chevronLeftIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="chevronLeftIconTitle">Chevron Left</title>
        <polyline points="14 18 8 12 14 6 14 6"/>
    </svg>

    <svg v-else-if="name === 'ellypsis'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="ellypsisVerticalIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="ellypsisVerticalIconTitle">Ellypsis</title>
        <path
            d="M11 12C11 11.4477153 11.4477153 11 12 11 12.5522847 11 13 11.4477153 13 12 13 12.5522847 12.5522847 13 12 13 11.4477153 13 11 12.5522847 11 12zM11 6C11 5.44771525 11.4477153 5 12 5 12.5522847 5 13 5.44771525 13 6 13 6.55228475 12.5522847 7 12 7 11.4477153 7 11 6.55228475 11 6zM11 18C11 17.4477153 11.4477153 17 12 17 12.5522847 17 13 17.4477153 13 18 13 18.5522847 12.5522847 19 12 19 11.4477153 19 11 18.5522847 11 18z"/>
    </svg>

    <svg v-else-if="name === 'chevron-down'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="chevronDownIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="chevronDownIconTitle">Chevron Down</title>
        <polyline points="6 10 12 16 18 10"/>
    </svg>

    <svg v-else-if="name === 'cancel'" :height='size + "px"' :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="cancelIconTitle" class="stroke-current"
         fill="none"
         role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="cancelIconTitle">Cancel</title>
        <path d="M15.5355339 15.5355339L8.46446609 8.46446609M15.5355339 8.46446609L8.46446609 15.5355339"/>
        <path
            d="M4.92893219,19.0710678 C1.02368927,15.1658249 1.02368927,8.83417511 4.92893219,4.92893219 C8.83417511,1.02368927 15.1658249,1.02368927 19.0710678,4.92893219 C22.9763107,8.83417511 22.9763107,15.1658249 19.0710678,19.0710678 C15.1658249,22.9763107 8.83417511,22.9763107 4.92893219,19.0710678 Z"/>
    </svg>
    <svg v-else-if="name === 'filter'" :height='size + "px"'
         :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="filterIconTitle" class="stroke-current" fill="none"
         sstroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="filterIconTitle">Filter</title>
        <path d="M10 12.261L4.028 3.972h16L14 12.329V17l-4 3z"/>
    </svg>
    <svg v-else-if="name === 'chat'" :height='size + "px"'
         :stroke-width="strokeSize" :width='size + "px"'
         aria-labelledby="chatAltIconTitle" class="stroke-current" fill="none"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><title id="chatAltIconTitle">Chat</title>
        <path d="M13,17 L7,21 L7,17 L3,17 L3,4 L21,4 L21,17 L13,17 Z"/>
    </svg>

    <svg v-else-if="name === 'chevron-up'"
         :stroke-width="strokeSize"
         class="stroke-current"
         :width='size + "px"' :height='size + "px"'
         aria-labelledby="chevronUpIconTitle"  fill="none" role="img"
         stroke-linecap="square" stroke-linejoin="miter"
         viewBox="0 0 24 24"  xmlns="http://www.w3.org/2000/svg"><title id="chevronUpIconTitle">Chevron Up</title>
        <polyline points="6 14 12 8 18 14 18 14"/>
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
