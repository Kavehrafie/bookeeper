<template>
    <div class="bg-gray-200 grid grid-cols-base">
        <header class="bg-white col-start-2 col-span-1 z-20 shadow-md">
            <div class="flex justify-between pt-4 pb-2 mx-auto max-w-5xl px-2 md:px-4 xl:px-0">
                <h1 class="font-medium leading-5 text-3xl my-auto">
                    <slot name="title"></slot>
                </h1>
                <header-content/>
            </div>
        </header>

        <div class="col-start-2 col-span-1 py-4 mt-6 sticky top-0 z-10 bg-gray-200 w-full">
            <div class="max-w-5xl mx-auto px-2 md:px-4 xl:px-0">
                <slot name="toolbar"></slot>
            </div>
        </div>

        <!-- contain -->
        <main class="bg-gray-200 col-start-2 col-span-1 min-h-screen">
            <div class="px-2 mb-4 md:px-4 xl:px-0 xl:max-w-5xl mx-auto">
                <slot></slot>
            </div>
        </main>

        <!-- sidebar -->
        <aside class="col-start-1 col-span-1 row-start-1 row-span-4 bg-indigo-700 shadow-lg menu-aside
                    z-30 relative shadow transition-all duration-250 ease-in-out"
        >
            <div class="sticky top-0 h-screen flex flex-col">
                <div class="mt-8 mb-20 pt-2 ">
                    <logo/>
                </div>


                <inertia-link v-for="(link, index) in links"
                              :key="index" :active="route().current(link.value)"
                              :href="route(link.value)"
                              class="flex text-white menu-aside-item px-2 py-4 hover:bg-indigo-600">
                    <icon :name="link.icon" :size="35" :stroke-width="2"/>
                    <span class="my-auto menu-aside-item__text">{{ link.title }}</span>
                </inertia-link>

                <div class="flex-auto flex items-end  w-full text-sm">
                    <p class="pb-4 mx-auto">v.0.1</p>
                </div>
            </div>
        </aside>

        <jet-banner class="col-span-2"/>
        <!-- footer -->
        <footer class="col-start-2 row-start-4 border-t border-white">
            <div class="bg-gray-100 text-purple-800 flex flex-col pt-5 pb-3 justify-center items-center">
                <p class="">PHP version: {{ PHP_VERSION }} (<span class="text-black">{{ year }}</span>)</p>
                <p class="">Laravel version: {{ APPLICATION_VERSION }}</p>
            </div>
        </footer>

        <!-- Dynamic Modal -->
        <Component
            :is="$root.modalComponent"
            v-if="$root.modalComponent"
            v-bind="$page.props"
        />

        <portal-target multiple name="modal">
        </portal-target>


        <!--        <div class="min-h-screen bg-gray-100">-->
        <!--            <nav class="bg-white border-b border-gray-100">-->
        <!--                &lt;!&ndash; Primary Navigation Menu &ndash;&gt;-->
        <!--                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">-->
        <!--                    <div class="flex justify-between h-16">-->
        <!--                        <div class="flex">-->
        <!--                            &lt;!&ndash; Logo &ndash;&gt;-->
        <!--                            <div class="flex-shrink-0 flex items-center">-->
        <!--                                <inertia-link :href="route('dashboard')">-->
        <!--                                    <jet-application-mark class="block h-9 w-auto" />-->
        <!--                                </inertia-link>-->
        <!--                            </div>-->

        <!--                            &lt;!&ndash; Navigation Links &ndash;&gt;-->
        <!--                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">-->
        <!--                                <jet-nav-link :href="route('references.index')" :active="route().current('references.index')">-->
        <!--                                    References-->
        <!--                                </jet-nav-link>-->
        <!--                            </div>-->
        <!--                            <div class="hidden space-x-8 sm:-my-px sm:ml-10 sm:flex">-->
        <!--                                <jet-nav-link :href="route('codes.index')" :active="route().current('codes.index')">-->
        <!--                                    Codes-->
        <!--                                </jet-nav-link>-->
        <!--                            </div>-->
        <!--                        </div>-->

        <!--                        <div class="hidden sm:flex sm:items-center sm:ml-6">-->
        <!--                            <div class="ml-3 relative">-->
        <!--                                &lt;!&ndash; Teams Dropdown &ndash;&gt;-->
        <!--                                <jet-dropdown align="right" width="60" v-if="$page.props.jetstream.hasTeamFeatures">-->
        <!--                                    <template #trigger>-->
        <!--                                        <span class="inline-flex rounded-md">-->
        <!--                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:bg-gray-50 hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">-->
        <!--                                                {{ $page.props.user.current_team.name }}-->

        <!--                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">-->
        <!--                                                    <path fill-rule="evenodd" d="M10 3a1 1 0 01.707.293l3 3a1 1 0 01-1.414 1.414L10 5.414 7.707 7.707a1 1 0 01-1.414-1.414l3-3A1 1 0 0110 3zm-3.707 9.293a1 1 0 011.414 0L10 14.586l2.293-2.293a1 1 0 011.414 1.414l-3 3a1 1 0 01-1.414 0l-3-3a1 1 0 010-1.414z" clip-rule="evenodd" />-->
        <!--                                                </svg>-->
        <!--                                            </button>-->
        <!--                                        </span>-->
        <!--                                    </template>-->

        <!--                                    <template #content>-->
        <!--                                        <div class="w-60">-->
        <!--                                            &lt;!&ndash; Team Management &ndash;&gt;-->
        <!--                                            <template v-if="$page.props.jetstream.hasTeamFeatures">-->
        <!--                                                <div class="block px-4 py-2 text-xs text-gray-400">-->
        <!--                                                    Manage Team-->
        <!--                                                </div>-->

        <!--                                                &lt;!&ndash; Team Settings &ndash;&gt;-->
        <!--                                                <jet-dropdown-link :href="route('teams.show', $page.props.user.current_team)">-->
        <!--                                                    Team Settings-->
        <!--                                                </jet-dropdown-link>-->

        <!--                                                <jet-dropdown-link :href="route('teams.create')" v-if="$page.props.jetstream.canCreateTeams">-->
        <!--                                                    Create New Team-->
        <!--                                                </jet-dropdown-link>-->

        <!--                                                <div class="border-t border-gray-100"></div>-->

        <!--                                                &lt;!&ndash; Team Switcher &ndash;&gt;-->
        <!--                                                <div class="block px-4 py-2 text-xs text-gray-400">-->
        <!--                                                    Switch Teams-->
        <!--                                                </div>-->

        <!--                                                <template v-for="team in $page.props.user.all_teams">-->
        <!--                                                    <form @submit.prevent="switchToTeam(team)" :key="team.id">-->
        <!--                                                        <jet-dropdown-link as="button">-->
        <!--                                                            <div class="flex items-center">-->
        <!--                                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>-->
        <!--                                                                <div>{{ team.name }}</div>-->
        <!--                                                            </div>-->
        <!--                                                        </jet-dropdown-link>-->
        <!--                                                    </form>-->
        <!--                                                </template>-->
        <!--                                            </template>-->
        <!--                                        </div>-->
        <!--                                    </template>-->
        <!--                                </jet-dropdown>-->
        <!--                            </div>-->

        <!--                            &lt;!&ndash; Settings Dropdown &ndash;&gt;-->
        <!--                            <div class="ml-3 relative">-->
        <!--                                <jet-dropdown align="right" width="48">-->
        <!--                                    <template #trigger>-->
        <!--                                        <button v-if="$page.props.jetstream.managesProfilePhotos" class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition duration-150 ease-in-out">-->
        <!--                                            <img class="h-8 w-8 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />-->
        <!--                                        </button>-->

        <!--                                        <span v-else class="inline-flex rounded-md">-->
        <!--                                            <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none transition ease-in-out duration-150">-->
        <!--                                                {{ $page.props.user.name }}-->

        <!--                                                <svg class="ml-2 -mr-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">-->
        <!--                                                    <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />-->
        <!--                                                </svg>-->
        <!--                                            </button>-->
        <!--                                        </span>-->
        <!--                                    </template>-->

        <!--                                    <template #content>-->
        <!--                                        &lt;!&ndash; Account Management &ndash;&gt;-->
        <!--                                        <div class="block px-4 py-2 text-xs text-gray-400">-->
        <!--                                            Manage Account-->
        <!--                                        </div>-->

        <!--                                        <jet-dropdown-link :href="route('profile.show')">-->
        <!--                                            Profile-->
        <!--                                        </jet-dropdown-link>-->

        <!--                                        <jet-dropdown-link :href="route('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">-->
        <!--                                            API Tokens-->
        <!--                                        </jet-dropdown-link>-->

        <!--                                        <div class="border-t border-gray-100"></div>-->

        <!--                                        &lt;!&ndash; Authentication &ndash;&gt;-->
        <!--                                        <form @submit.prevent="logout">-->
        <!--                                            <jet-dropdown-link as="button">-->
        <!--                                                Logout-->
        <!--                                            </jet-dropdown-link>-->
        <!--                                        </form>-->
        <!--                                    </template>-->
        <!--                                </jet-dropdown>-->
        <!--                            </div>-->
        <!--                        </div>-->

        <!--                        &lt;!&ndash; Hamburger &ndash;&gt;-->
        <!--                        <div class="-mr-2 flex items-center sm:hidden">-->
        <!--                            <button @click="showingNavigationDropdown = ! showingNavigationDropdown" class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out">-->
        <!--                                <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">-->
        <!--                                    <path :class="{'hidden': showingNavigationDropdown, 'inline-flex': ! showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />-->
        <!--                                    <path :class="{'hidden': ! showingNavigationDropdown, 'inline-flex': showingNavigationDropdown }" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />-->
        <!--                                </svg>-->
        <!--                            </button>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->

        <!--                &lt;!&ndash; Responsive Navigation Menu &ndash;&gt;-->
        <!--                <div :class="{'block': showingNavigationDropdown, 'hidden': ! showingNavigationDropdown}" class="sm:hidden">-->
        <!--                    <div class="pt-2 pb-3 space-y-1">-->
        <!--                        <jet-responsive-nav-link :href="route('dashboard')" :active="route().current('dashboard')">-->
        <!--                            Dashboard-->
        <!--                        </jet-responsive-nav-link>-->
        <!--                    </div>-->

        <!--                    &lt;!&ndash; Responsive Settings Options &ndash;&gt;-->
        <!--                    <div class="pt-4 pb-1 border-t border-gray-200">-->
        <!--                        <div class="flex items-center px-4">-->
        <!--                            <div v-if="$page.props.jetstream.managesProfilePhotos" class="flex-shrink-0 mr-3" >-->
        <!--                                <img class="h-10 w-10 rounded-full object-cover" :src="$page.props.user.profile_photo_url" :alt="$page.props.user.name" />-->
        <!--                            </div>-->

        <!--                            <div>-->
        <!--                                <div class="font-medium text-base text-gray-800">{{ $page.props.user.name }}</div>-->
        <!--                                <div class="font-medium text-sm text-gray-500">{{ $page.props.user.email }}</div>-->
        <!--                            </div>-->
        <!--                        </div>-->

        <!--                        <div class="mt-3 space-y-1">-->
        <!--                            <jet-responsive-nav-link :href="route('profile.show')" :active="route().current('profile.show')">-->
        <!--                                Profile-->
        <!--                            </jet-responsive-nav-link>-->

        <!--                            <jet-responsive-nav-link :href="route('api-tokens.index')" :active="route().current('api-tokens.index')" v-if="$page.props.jetstream.hasApiFeatures">-->
        <!--                                API Tokens-->
        <!--                            </jet-responsive-nav-link>-->

        <!--                            &lt;!&ndash; Authentication &ndash;&gt;-->
        <!--                            <form method="POST" @submit.prevent="logout">-->
        <!--                                <jet-responsive-nav-link as="button">-->
        <!--                                    Logout-->
        <!--                                </jet-responsive-nav-link>-->
        <!--                            </form>-->

        <!--                            &lt;!&ndash; Team Management &ndash;&gt;-->
        <!--                            <template v-if="$page.props.jetstream.hasTeamFeatures">-->
        <!--                                <div class="border-t border-gray-200"></div>-->

        <!--                                <div class="block px-4 py-2 text-xs text-gray-400">-->
        <!--                                    Manage Team-->
        <!--                                </div>-->

        <!--                                &lt;!&ndash; Team Settings &ndash;&gt;-->
        <!--                                <jet-responsive-nav-link :href="route('teams.show', $page.props.user.current_team)" :active="route().current('teams.show')">-->
        <!--                                    Team Settings-->
        <!--                                </jet-responsive-nav-link>-->

        <!--                                <jet-responsive-nav-link :href="route('teams.create')" :active="route().current('teams.create')">-->
        <!--                                    Create New Team-->
        <!--                                </jet-responsive-nav-link>-->

        <!--                                <div class="border-t border-gray-200"></div>-->

        <!--                                &lt;!&ndash; Team Switcher &ndash;&gt;-->
        <!--                                <div class="block px-4 py-2 text-xs text-gray-400">-->
        <!--                                    Switch Teams-->
        <!--                                </div>-->

        <!--                                <template v-for="team in $page.props.user.all_teams">-->
        <!--                                    <form @submit.prevent="switchToTeam(team)" :key="team.id">-->
        <!--                                        <jet-responsive-nav-link as="button">-->
        <!--                                            <div class="flex items-center">-->
        <!--                                                <svg v-if="team.id == $page.props.user.current_team_id" class="mr-2 h-5 w-5 text-green-400" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" stroke="currentColor" viewBox="0 0 24 24"><path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>-->
        <!--                                                <div>{{ team.name }}</div>-->
        <!--                                            </div>-->
        <!--                                        </jet-responsive-nav-link>-->
        <!--                                    </form>-->
        <!--                                </template>-->
        <!--                            </template>-->
        <!--                        </div>-->
        <!--                    </div>-->
        <!--                </div>-->
        <!--            </nav>-->

        <!--            &lt;!&ndash; Page Heading &ndash;&gt;-->
        <!--            <header class="bg-white shadow" v-if="$slots.header">-->
        <!--                <div class="max-w-7xl mx-auto py-2 min-h-2 px-4 sm:px-6 lg:px-8">-->
        <!--                    <slot name="header"></slot>-->
        <!--                </div>-->
        <!--            </header>-->

        <!--            &lt;!&ndash; Page Content &ndash;&gt;-->
        <!--            <main class="min-h-screen">-->
        <!--                <slot></slot>-->
        <!--            </main>-->

        <!--            <footer class="mt-5">-->
        <!--                <div class="bg-gray-800 flex flex-col pt-5 pb-3 justify-center items-center">-->
        <!--                    <p class="text-white">PHP version: {{PHP_VERSION}} (<span class="text-gray-100">{{year}}</span>)</p>-->
        <!--                    <p class="text-white">Laravel version: {{APPLICATION_VERSION}}</p>-->
        <!--                </div>-->
        <!--            </footer>-->
        <!--            &lt;!&ndash; Modal Portal &ndash;&gt;-->
        <!--            <portal-target name="modal" multiple>-->
        <!--            </portal-target>-->

        <!--        </div>-->
    </div>
</template>

<script>
import JetBanner from '@/Jetstream/Banner'
import HeaderContent from "@/Components/HeaderContent";
import Icon from "@/Components/Icon";
import Logo from "@/Components/Logo";

export default {
    components: {
        Logo,
        HeaderContent,
        JetBanner,
        Icon
    },

    data() {
        return {
            show: false,
            showingNavigationDropdown: false,
            links: this.$page.props.mainMenu,
        }
    },
    mounted() {
        console.log('s', this.$page.props)
    },
    methods: {
        switchToTeam(team) {
            this.$inertia.put(route('current-team.update'), {
                'team_id': team.id
            }, {
                preserveState: false
            })
        },

        logout() {
            this.$inertia.post(route('logout'));
        },
    },
    computed: {
        APPLICATION_VERSION() {
            return this.$page.props.APPLICATION_VERSION
        },
        PHP_VERSION() {
            return this.$page.props.PHP_VERSION
        },
        year() {
            let date = new Date();
            return date.getFullYear()
        }
    }
}
</script>


<style lang="css">
.menu-aside {
    width: 100px;
}

.menu-aside:hover {
    width: 200px;
}

.menu-aside-item {
    margin: auto;
}

.menu-aside:hover .menu-aside-item {
    margin: 0;
}

.menu-aside .menu-aside-item__text {
    display: none;
}

.menu-aside:hover .menu-aside-item__text {
    display: initial;
}
</style>
