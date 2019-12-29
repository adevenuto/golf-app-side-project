<template>
    <nav class="navbar navbar-expand-md navbar-light shadow-sm">
        <div class="container-fluid">
            <a class="navbar-brand" href="/">
                <img src="/images/golf-ball.svg" class="mr-1" height="30" width="30" alt="golfball icon"> TeeTyme
            </a>
            <button :class="{'menu-open': toggled}" 
                    @click="toggle"
                    class="navbar-toggler p-0 d-flex flex-column justify-content-between" 
                    type="button" 
                    data-toggle="collapse" 
                    data-target="#navbarSupportedContent" 
                    aria-controls="navbarSupportedContent" 
                    aria-expanded="false">
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <!-- Right Side Of Navbar -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item">
                        <a class="nav-link nav-link-standard" href="/courses">
                        <img class="icon_inline" src="/images/flagstick_and_green.svg" alt="star icon">Courses</a>
                    </li>
                    <template v-if="!authUser">
                        <li class="nav-item">
                            <a class="nav-link" href="/login">Login</a>
                        </li>   
                        <span class="nav-link px-0">|</span>                           
                        <li class="nav-item">
                            <a class="nav-link" href="/register">Register</a>
                        </li>
                    </template>
                    <template v-else>
                        <li class="nav-item">
                            <a class="nav-link nav-link-standard" href="/course/create">
                                <img class="icon_inline" src="/images/star_yellow.svg" alt="star icon">NewCourse
                            </a>
                        </li>
                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                {{ authUser.email }} <span class="caret"></span>
                            </a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a class="dropdown-item" href="/dashboard">Dashboard</a>
                                <a class="dropdown-item" href="/profile">Profile</a>
                                <a class="dropdown-item text-danger" href="#" @click.prevent="logout">Logout</a>
                            </div>
                        </li>
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>
<script>
    export default {
        data() {
            return {
                toggled: false
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
            }
        }
    }
</script>
<style lang="scss" scoped>
    .navbar .navbar-brand {
        font-size: 1.35rem;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    .navbar-light .navbar-toggler {
        border-color: transparent;
        height: 0;
        width: 0;
        &:focus, &:active, &:visited {
            border-color: transparent;
            outline: none;
        }
        .navbar-toggler-icon {
            background-image: none;
            width: inherit;
            height: 4px;
            border-radius: 4px;
            background: #000;
        }
    }
    .icon_inline {
        width: 12px;
        height: 12px;
        margin: 0 3px;
        position: relative;
        top: -2px;
        display: inline-block;
    }
    .navbar-light .navbar-nav .nav-link-standard {
        color: #077132;
        font-weight: 600;
        &:hover {
            color: #003a18;
        }
    }
    .navbar-light .navbar-toggler.menu-open {
        .navbar-toggler-icon {
            opacity: 1;
            transition: all 250ms ease-in-out;
            &:nth-child(1) {
                transform: translate(0px, 8px) rotate(-135deg);
            }
            &:nth-child(2) {
                opacity: 0;
                transform: scale(0);
            }
            &:nth-child(3) {
                transform: translate(0px, -8px) rotate(135deg);
            }
        }
    }
    @media (max-width: 767px) {
        .dropdown {
            .dropdown-menu {
                padding: 0;
                border: none;
                animation-name: example; 
                animation-duration: .25s;
                .dropdown-item {
                    margin: 3px 0;
                }
            }
        }
        .navbar-light .navbar-toggler {
            height: 20px;
            width: 22px;
            border-width: 0px;
        }
        @keyframes example {
            from {opacity:.3;transform: translateY(-5px);}
            to {opacity:1;transform: translateY(0px);}
        }
    }
    @media (min-width: 992px) {
        .navbar {
            padding: 0.5rem 0;
        }
    }  
</style>