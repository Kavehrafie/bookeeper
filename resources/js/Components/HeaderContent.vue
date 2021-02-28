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
            class="flex items-center pr-3 text-sm text-gray-700 transition duration-150 ease-in-out bg-gray-100 border-2 border-gray-200 rounded-full focus:outline-none focus:shadow-solid"
            :class="{ 'border-gray-300 bg-gray-500 text-white ': isShown }"
            aria-label="User menu"
            aria-haspopup="true"
            @mousedown="mousedownHandler"
            @focus="focusHandler"
            @blur="blurHandler"
            @keydown="keydownHandler"
        >
          <img class="w-8 h-8 mr-2 rounded-full"
               src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
               alt="">

          Hi, {{ $page.props.user.name }}!
        </button>
      </div>

      <div slot-scope="{ hide, blurHandler }">
        <inertia-link
            class="block text-center w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
            role="menuitem"
            :href="route('profile.show')"
            @blur="blurHandler"
        >
          Portfolio
        </inertia-link>
        <inertia-link
            class="block text-center w-full px-4 py-2 text-sm leading-5 text-gray-700 transition duration-150 ease-in-out hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
            role="menuitem"
            as="button"
            method="post"
            :href="route('logout')"
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
