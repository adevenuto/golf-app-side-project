<template>
    <nav class="sm:flex sm:justify-between p-3 border shadow">

        <div class="flex items-center justify-between">
            <a class="flex items-center" href="/">
                <img src="/images/golf-ball.svg" class="mr-1" height="35" width="35" alt="golfball icon"> 
                <span class="text-3xl text-gray-900 font-bold">TeeTyme</span>
            </a>
            
            <div class="sm:hidden" @click="toggle">
                <img v-if="!toggled" src="/images/hamburger-r.svg" width="25" height="25" alt="hamburger"> 
                <img v-if="toggled" src="/images/hamburger-close-r.svg" width="23" height="23" alt="hamburger"> 
            </div>
        </div>
            
        <transition name="fade">
            <div :class="toggled ? 'block' : 'hidden'" class="sm:flex items-center mt-3 sm:mt-0">
                <a class="block py-1 sm:mr-2 text-gray-600 hover:text-gray-900" href="/courses">Courses</a>

                <template v-if="!authUser">
                    <a class="" href="/login">Login</a>      
                    <a class="" href="/register">Register</a>
                </template>

                <template v-else>
                    <a class="block py-1 sm:mr-1 text-gray-600 hover:text-gray-900" href="/course/create">Newcourse</a>
                    <div class="relative sm:ml-3 cursor-pointer" @click="toggleDropdown">
                        <div class="my-1 sm:my-0">
                            <a class="text-lg text-gray-900" @click.prevent="">{{ authUser.email }} 
                                <img class="inline-block" src="/images/down-arrow.svg" width="15" height="15" alt="hamburger"> 
                            </a>
                        </div>
                        <div v-if="dropdown" class="sm:absolute sm:mt-3 z-50 w-full sm:border sm:bg-white sm:shadow">
                            <ul class="px-3">
                                <li class="py-1"><a class="text-gray-600 hover:text-gray-900" href="/dashboard">Dashboard</a></li>
                                <li class="py-1"><a class="text-gray-600 hover:text-gray-900" href="/profile">Profile</a></li>
                                <li class="py-1"><a class="text-red-700 hover:text-red-800" href="#" @click.prevent="logout">Logout</a></li>
                            </ul>
                        </div>
                    </div>
                </template>
            </div>
        </transition>

    </nav>
</template>
<script>
    export default {
        data() {
            return {
                toggled: false,
                dropdown: false
            }
        },
        props: ['user'],
        computed: {
            authUser: function() {
                return this.user ? JSON.parse(this.user) : null;
            }
        },
        methods: {
            logout: function() {
                axios.post('/logout')
                .then(response => {
                    if (response.status === 302 || 401) {
                        window.location.href = '/';
                    }
                })
            },
            toggle: function() {
                return this.toggled = !this.toggled;
            },
            toggleDropdown: function() {
                return this.dropdown = !this.dropdown;
            }
        }
    }
</script>
<style lang="scss" scoped>
     
</style>