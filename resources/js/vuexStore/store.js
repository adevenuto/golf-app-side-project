export default {
    state: {
        isLoggedIn: !!window.Laravel.authUser,
        userEmail: window.Laravel.authUser ? window.Laravel.authUser.email : null
    },
    
    getters: {
        isLoggedIn(state) {
           return state.isLoggedIn;
        },
        userEmail(state) {
           return state.userEmail;
        },
    },
    mutations: {
        
    },
    actions: {
        
    }
};