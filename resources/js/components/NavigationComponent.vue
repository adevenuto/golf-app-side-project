<template>
    <nav class="sm:flex sm:justify-between p-3 border shadow">

        <div class="flex items-center justify-between">
            <a class="flex items-center" href="/">
                <img src="/images/golf-ball.svg" class="mr-1" height="35" width="35" alt="golfball icon"> 
                <span class="text-3xl text-gray-900 font-bold">TeeTyme</span>
            </a>
            
            <div class="sm:hidden" @click="toggle">
                <img v-if="!toggled" src="/images/hamburger.svg" width="30" height="30" alt="hamburger"> 
                <img v-if="toggled" src="/images/hamburger-close.svg" width="27" height="27" alt="hamburger"> 
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
                        <div v-if="dropdown" class="sm:absolute sm:mt-3 w-full sm:border sm:bg-white sm:shadow">
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
    // .navbar .navbar-brand {
    //     font-size: 1.35rem;
    //     font-weight: 600;
    //     display: flex;
    //     align-items: center;
    // }
    // .navbar-light .navbar-toggler {
    //     border-color: transparent;
    //     height: 0;
    //     width: 0;
    //     &:focus, &:active, &:visited {
    //         border-color: transparent;
    //         outline: none;
    //     }
    //     .navbar-toggler-icon {
    //         background-image: none;
    //         width: inherit;
    //         height: 4px;
    //         border-radius: 4px;
    //         background: #000;
    //     }
    // }
    // .icon_inline {
    //     width: 15px;
    //     height: 15px;
    //     margin: 0 3px;
    //     position: relative;
    //     top: -2px;
    //     display: inline-block;
    // }
    // .navbar-light .navbar-nav .nav-link-standard {
    //     color: #077132;
    //     font-weight: 600;
    //     &:hover {
    //         color: #003a18;
    //     }
    // }
    // .navbar-light .navbar-toggler.menu-open {
    //     .navbar-toggler-icon {
    //         opacity: 1;
    //         transition: all 250ms ease-in-out;
    //         &:nth-child(1) {
    //             transform: translate(0px, 8px) rotate(-135deg);
    //         }
    //         &:nth-child(2) {
    //             opacity: 0;
    //             transform: scale(0);
    //         }
    //         &:nth-child(3) {
    //             transform: translate(0px, -8px) rotate(135deg);
    //         }
    //     }
    // }
    // @media (min-width: 768px) {
    //     .navbar-expand-md .navbar-nav .dropdown-menu {
    //         position: absolute;
    //         left: -85px;
    //         width: 222px;
    //     }
    // }
    // @media (max-width: 767px) {
    //     .dropdown {
    //         .dropdown-menu {
    //             padding: 0;
    //             border: none;
    //             animation-name: example; 
    //             animation-duration: .25s;
    //             .dropdown-item {
    //                 margin: 3px 0;
    //             }
    //         }
    //     }
    //     .navbar-light .navbar-toggler {
    //         height: 20px;
    //         width: 22px;
    //         border-width: 0px;
    //     }
    //     @keyframes example {
    //         from {opacity:.3;transform: translateY(-5px);}
    //         to {opacity:1;transform: translateY(0px);}
    //     }
    // }
    // @media (min-width: 992px) {
    //     .navbar {
    //         padding: 0.5rem 0;
    //     }
    // }  
</style>