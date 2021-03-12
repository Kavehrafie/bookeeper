<template>
    <t-dropdown>
        <div
            slot="trigger"
            slot-scope="{
                          mousedownHandler,
                          focusHandler,
                          blurHandler,
                          keydownHandler,
                          isShown
                        }"
        >
            <button
                id="user-menu"
                :class="{ 'border-gray-300 bg-purple-100 text-white ': isShown }"
                aria-haspopup="true"
                aria-label="User menu"
                class="flex items-center pr-3 text-sm text-gray-700 transition duration-150 ease-in-out bg-gray-100 border-2 border-gray-200 rounded-full focus:outline-none focus:shadow-solid"
                @blur="blurHandler"
                @focus="focusHandler"
                @keydown="keydownHandler"
                @mousedown="mousedownHandler"
            >
                <img :src="`https://icotar.com/avatar/${$page.props.user.name }`"
                     alt=""
                     class="w-8 h-8 mr-2 rounded-full">

                Hi, {{ $page.props.user.name }}!
            </button>
        </div>

        <div slot-scope="{ hide, blurHandler }">
            <inertia-link
                :href="route('profile.show')"
                class="block text-center w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                role="menuitem"
                @blur="blurHandler"
            >
                Portfolio
            </inertia-link>
            <inertia-link
                :href="route('logout')"
                as="button"
                class="block text-center w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                method="post"
                role="menuitem"
                @blur="blurHandler"
            >
                Logout
            </inertia-link>

            <button
                class="block w-full px-4 py-2 text-sm leading-5 text-red-500 transition duration-150 ease-in-out border-t hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                @click="hide"
            >
                Close me
            </button>
        </div>
    </t-dropdown>

</template>
<script>
import Button from "@/Jetstream/Button"

export default {
    name: 'HeaderContent',
    components: {Button}
}
</script>
